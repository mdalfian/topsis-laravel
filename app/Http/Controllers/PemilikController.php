<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PemilikController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];

        return view('pemilik.home', $data);
    }

    public function penilaian()
    {
        $data = [
            'title' => 'Penilaian',
            'alternatif' => Alternatif::all(),
            'kriteria' => Kriteria::all(),
            'sub_kriteria' => DB::table('sub_kriteria')->get()->sortByDesc('nilai'),
            'penilaian' => DB::table('penilaian')
                ->select('penilaian.*', 'kriteria.nama_kriteria')
                ->join('kriteria', 'penilaian.id_kriteria', '=', 'kriteria.id_kriteria')
                ->get()
        ];

        return view('pemilik.penilaian', $data);
    }

    public function perhitungan()
    {
        $data = [
            'title' => 'Perhitungan',
            'alternatif' => Alternatif::all(),
            'kriteria' => Kriteria::all(),
            'sub_kriteria' => DB::table('sub_kriteria')->get()->sortByDesc('nilai'),
            'penilaian' => DB::table('penilaian')
                ->select('penilaian.*', 'kriteria.nama_kriteria')
                ->join('kriteria', 'penilaian.id_kriteria', '=', 'kriteria.id_kriteria')
                ->get(),
            'perhitungan' => DB::table('penilaian')
                ->select('penilaian.*', 'kriteria.nama_kriteria', 'alternatif.nama_alternatif')
                ->join('kriteria', 'kriteria.id_kriteria', '=', 'penilaian.id_kriteria')
                ->join('alternatif', 'alternatif.id_alternatif', '=', 'penilaian.id_alternatif')
                ->groupBy('penilaian.id_alternatif')
                ->get(),
            'total' => DB::table('penilaian')
                ->selectRaw('id_kriteria, SUM(pow(nilai, 2)) as total')
                ->groupBy('id_kriteria')
                ->get(),
            'normalisasi' => DB::table('penilaian')
                ->selectRaw('penilaian.*, MAX(penilaian.nilai / SQRT(tb2.total) * kriteria.bobot_kriteria) as max, MIN(penilaian.nilai / SQRT(tb2.total) * kriteria.bobot_kriteria) as min, kriteria.kode_kriteria')
                ->join(DB::raw("(SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2"), function ($join) {
                    $join->on('penilaian.id_kriteria', '=', 'tb2.id_kriteria');
                })
                ->join('kriteria', 'penilaian.id_kriteria', '=', 'kriteria.id_kriteria')
                ->groupBy('id_kriteria')
                ->get(),
            'solusi' => DB::select('SELECT tb1.*, (tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS normalisasi, tb4.min, tb4.max, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria GROUP BY id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif;'),
            'ranking' => DB::select('SELECT *, (tb2.solusi_negatif/(tb2.solusi_negatif+tb2.solusi_positif)) AS kedekatan FROM penilaian tb1 JOIN (SELECT tb1.id_alternatif AS alt, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = "Benefit", tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria GROUP BY id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif) tb2 ON tb1.id_alternatif = tb2.alt JOIN alternatif tb3 ON tb1.id_alternatif = tb3.id_alternatif GROUP BY tb1.id_alternatif ORDER BY kedekatan DESC;')
            // 'solusi' => DB::unprepared("SELECT tb1.*, (tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS normalisasi, tb4.min, tb4.max, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = 'Benefit', tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = 'Benefit', tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria GROUP BY id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif;"),
            // 'ranking' => DB::unprepared("SELECT *, (tb2.solusi_negatif/(tb2.solusi_negatif+tb2.solusi_positif)) AS kedekatan FROM penilaian tb1 JOIN (SELECT tb1.id_alternatif AS alt, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = 'Benefit', tb4.max, tb4.min) , 2)))) AS solusi_positif, (SQRT(SUM(pow((tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) - IF(tb3.jenis_kriteria = 'Benefit', tb4.min, tb4.max) , 2)))) AS solusi_negatif FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria JOIN (SELECT tb1.id_kriteria, MAX(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS max, MIN(tb1.nilai / SQRT(tb2.total) * tb3.bobot_kriteria) AS min,tb3.kode_kriteria FROM penilaian tb1 JOIN (SELECT id_kriteria,SUM(pow(nilai,2)) AS total FROM penilaian GROUP BY id_kriteria) AS tb2 ON tb1.id_kriteria = tb2.id_kriteria JOIN kriteria tb3 ON tb1.id_kriteria = tb3.id_kriteria GROUP BY id_kriteria) tb4 ON tb1.id_kriteria = tb4.id_kriteria GROUP BY id_alternatif) tb2 ON tb1.id_alternatif = tb2.alt JOIN alternatif tb3 ON tb1.id_alternatif = tb3.id_alternatif GROUP BY tb1.id_alternatif ORDER BY kedekatan DESC;")
        ];

        return view('pemilik.perhitungan', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profil',
            'profile' => DB::table('users')->where('id', Auth::user()->id)->first()
        ];

        return view('pemilik.profil', $data);
    }

    public function edit_profile(Request $request, $id)
    {
        $pass = $request->input('password');
        $op = $request->input('op');

        $data = [
            'name' => $request->input('nama_lengkap'),
            'password' => $pass == '' ? $op :  password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]),
        ];

        $query =  DB::table('users')->where('id', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Profil');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Profil');
            return Redirect::back();
        }
    }
}