<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class PenilaianController extends Controller
{
    public function add_penilaian(Request $request, $id_alternatif)
    {
        $id_kriteria = $request->input('id_kriteria');
        $nilai = $request->input('nilai');
        $data = [];

        $index = 0;
        foreach ($id_kriteria as $id) {
            array_push($data, [
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id,
                'nilai' => $nilai[$index]
            ]);

            $index++;
        }

        $query = [
            DB::table('penilaian')->insert($data),
            DB::table('alternatif')->where('id_alternatif', $id_alternatif)->update(['status' => 1])
        ];

        if ($query > 0) {
            return redirect()->back()->with('success', 'Berhasil melakukan penilaian');
        } else {
            return redirect()->back()->with('error', 'Gagal melakukan penilaian');
        }
    }

    public function edit_penilaian(Request $request)
    {
        $id_penilaian = $request->input('id_penilaian');
        $nilai = $request->input('nilai');
        $data = [];

        $index = 0;
        foreach ($id_penilaian as $id) {
            array_push($data, [
                'id_penilaian' => $id,
                'nilai' => $nilai[$index]
            ]);

            $index++;
        }

        $ind = 'id_penilaian';

        $query = Penilaian::batchUpdate($data, $ind);

        if ($query > 0) {
            return redirect()->back()->with('success', 'Berhasil mengedit penilaian');
        } else {
            return redirect()->back()->with('error', 'Gagal mengedit penilaian');
        }
    }

    public function pdf($kat)
    {
        $data = [
            // 'ranking' =>  DB::select('SELECT *, (tb2.solusi_negatif/(tb2.solusi_negatif+tb2.solusi_positif)) AS kedekatan FROM penilaian tb1 JOIN (SELECT tb1.id_alternatif AS alt, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria GROUP BY id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif) tb2 ON tb1.id_alternatif = tb2.alt JOIN alternatif tb3 ON tb1.id_alternatif = tb3.id_alternatif GROUP BY tb1.id_alternatif ORDER BY kedekatan DESC;')
            'ranking' => DB::select('SELECT *, (tb2.solusi_negatif/(tb2.solusi_negatif+tb2.solusi_positif)) AS kedekatan FROM penilaian tb1 JOIN (SELECT tb1.id_alternatif AS alt, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY tb1.id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif) tb2 ON tb1.id_alternatif = tb2.alt JOIN alternatif tb3 ON tb1.id_alternatif = tb3.id_alternatif WHERE tb3.level_alternatif = ' . $kat . ' GROUP BY tb1.id_alternatif ORDER BY kedekatan DESC;')
        ];

        $fileName = 'Hasil Perangkingan ' . date('d-m-Y') . '';

        $dompdf = new Dompdf();

        $dompdf->loadHtml(view('pdf', $data));

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream($fileName);
    }
}