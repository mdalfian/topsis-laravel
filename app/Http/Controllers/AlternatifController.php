<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class AlternatifController extends Controller
{
    public function add_alternatif(Request $request)
    {
        $data = [
            'id_alternatif' => UniqueIdGenerator::generate(['table' => 'alternatif', 'field' => 'id_alternatif', 'length' => 7, 'prefix' => 'ALT']),
            'nama_alternatif' => $request->input('nama_alternatif'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'level_alternatif' => $request->input('level_alternatif'),
        ];

        $query =  DB::table('alternatif')->insert($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah Alternatif');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah Alternatif');
            return Redirect::back();
        }
    }

    public function check_alternatif(Request $request)
    {
        $nama = trim($request->input('nama'));

        $count =  DB::table('alternatif')->where('nama_alternatif', $nama)->count();

        echo json_encode($count);
    }

    public function select_alt(Request $request)
    {
        $kat = $request->input('kat');

        $data = [
            'kriteria' => Kriteria::where('kat_kriteria', $kat)->get(),
            'alternatif' => Alternatif::where('level_alternatif', $kat)->get(),
            'sub_kriteria' => DB::table('sub_kriteria')->get()->sortByDesc('nilai'),
            'mode' => 'rank',
            'penilaian' => DB::table('penilaian')
                ->select('penilaian.*', 'kriteria.nama_kriteria')
                ->join('kriteria', 'penilaian.id_kriteria', '=', 'kriteria.id_kriteria')
                ->where('kat_kriteria', '=', $kat)
                ->get(),
            'perhitungan' => DB::table('penilaian')
                ->select('penilaian.*', 'kriteria.nama_kriteria', 'alternatif.nama_alternatif')
                ->join('kriteria', 'kriteria.id_kriteria', '=', 'penilaian.id_kriteria')
                ->join('alternatif', 'alternatif.id_alternatif', '=', 'penilaian.id_alternatif')
                ->where('kat_kriteria', '=', $kat)
                ->where('level_alternatif', '=', $kat)
                ->groupBy('penilaian.id_alternatif')
                ->get(),
            'total' => DB::table('penilaian')
                ->selectRaw('penilaian.id_kriteria, SUM(pow(nilai, 2)) as total')
                ->join('kriteria', 'kriteria.id_kriteria', '=', 'penilaian.id_kriteria')
                ->where('kat_kriteria', '=', $kat)
                ->groupBy('penilaian.id_kriteria')
                ->get(),
            'normalisasi' => DB::table('penilaian')
                ->selectRaw('penilaian.*, MAX(penilaian.nilai / SQRT(tb2.total) * kriteria.bobot_kriteria) as max, MIN(penilaian.nilai / SQRT(tb2.total) * kriteria.bobot_kriteria) as min, kriteria.kode_kriteria')
                ->join(DB::raw("(SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = " . $kat . " GROUP BY penilaian.id_kriteria) AS tb2"), function ($join) {
                    $join->on('penilaian.id_kriteria', '=', 'tb2.id_kriteria');
                })
                ->join('kriteria', 'penilaian.id_kriteria', '=', 'kriteria.id_kriteria')
                ->where('kat_kriteria', '=', $kat)
                ->groupBy('penilaian.id_kriteria')
                ->get(),
            'solusi' => DB::select('SELECT tb1.*, (tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS normalisasi, tb4.min, tb4.max, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY tb1.id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria JOIN alternatif tb5 ON tb1.id_alternatif = tb5.id_alternatif WHERE level_alternatif = ' . $kat . ' GROUP BY tb1.id_alternatif;'),
            'ranking' => DB::select('SELECT *, (tb2.solusi_negatif/(tb2.solusi_negatif+tb2.solusi_positif)) AS kedekatan FROM penilaian tb1 JOIN (SELECT tb1.id_alternatif AS alt, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT penilaian.id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian JOIN kriteria ON kriteria.id_kriteria = penilaian.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY penilaian.id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria WHERE kat_kriteria = ' . $kat . ' GROUP BY tb1.id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif) tb2 ON tb1.id_alternatif = tb2.alt JOIN alternatif tb3 ON tb1.id_alternatif = tb3.id_alternatif WHERE tb3.level_alternatif = ' . $kat . ' GROUP BY tb1.id_alternatif ORDER BY kedekatan DESC;')
        ];

        return view('select_view', $data);
    }

    public function edit_alternatif(Request $request, $id)
    {
        $data = [
            'nama_alternatif' => $request->input('nama_alternatif'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'level_alternatif' => $request->input('level_alternatif'),
        ];

        $query =  DB::table('alternatif')->where('id_alternatif', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Alternatif');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Alternatif');
            return Redirect::back();
        }
    }

    public function delete_alternatif($id_alternatif)
    {
        $query = Alternatif::find($id_alternatif)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit Alternatif');
            return redirect()->back()->with('success', 'Berhasil menghapus Alternatif');
        } else {
            Session::flash('failed', 'Gagal menghapus Alternatif');
            return Redirect::back();
        }
    }
}