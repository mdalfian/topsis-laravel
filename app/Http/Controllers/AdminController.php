<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];

        return view('admin.home', $data);
    }

    public function kriteria()
    {
        $data = [
            'title' => 'Kriteria',
            'kriteria' => Kriteria::all()
        ];

        return view('admin.kriteria', $data);
    }

    public function sub_kriteria()
    {
        $data = [
            'title' => 'Sub Kriteria',
            'kriteria' => Kriteria::all(),
            'sub_kriteria' => DB::table('sub_kriteria')->get()->sortByDesc('nilai')
        ];

        return view('admin.sub_kriteria', $data);
    }

    public function alternatif()
    {
        $data = [
            'title' => 'Alternatif',
            'alternatif' => Alternatif::all(),
        ];

        return view('admin.alternatif', $data);
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

        return view('admin.penilaian', $data);
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

        return view('admin.perhitungan', $data);
    }

    public function user()
    {
        $data = [
            'title' => 'User',
            'user' => DB::table('users')
                ->select('users.*', 'jabatan.nama_jabatan')
                ->join('jabatan', 'users.id_jabatan', '=', 'jabatan.id_jabatan')
                ->where('id', '!=', 1)
                ->get(),
            'jabatan' => Jabatan::all()
        ];

        return view('admin.user', $data);
    }

    public function divisi()
    {
        $data = [
            'title' => 'Divisi',
            'divisi' => Divisi::all()
        ];

        return view('admin.divisi', $data);
    }

    public function jabatan()
    {
        $data = [
            'title' => 'Divisi',
            'divisi' => Divisi::all(),
            'jabatan' => DB::table('jabatan')
                ->select('jabatan.*', 'divisi.nama_divisi')
                ->join('divisi', 'jabatan.id_divisi', '=', 'divisi.id_divisi')
                ->get()
        ];

        return view('admin.jabatan', $data);
    }
}