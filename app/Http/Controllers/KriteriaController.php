<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class KriteriaController extends Controller
{
    public function add_kriteria(Request $request)
    {
        $data = [
            'id_kriteria' => UniqueIdGenerator::generate(['table' => 'kriteria', 'field' => 'id_kriteria', 'length' => 7, 'prefix' => 'KRI']),
            'kode_kriteria' => $request->input('kode_kriteria'),
            'nama_kriteria' => $request->input('nama_kriteria'),
            'bobot_kriteria' => $request->input('bobot_kriteria'),
            'jenis_kriteria' => $request->input('jenis_kriteria'),
            'kat_kriteria' => $request->input('kat_kriteria'),
        ];

        $kode = trim($request->input('kode_kriteria'));
        $nama = trim($request->input('nama_kriteria'));
        $count_kode =  DB::table('kriteria')->where('nama_kriteria', $nama)->count();
        $count_nama =  DB::table('kriteria')->where('kode_kriteria', $kode)->count();

        if ($count_kode > 0) {
            Session::flash('failed', 'Sudah ada kriteria dengan kode tersebut');
            return Redirect::back();
        } elseif ($count_nama > 0) {
            Session::flash('failed', 'Sudah ada kriteria dengan nama tersebut');
            return Redirect::back();
        } else {
            $query =  DB::table('kriteria')->insert($data);
        }

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah Kriteria');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah Kriteria');
            return Redirect::back();
        }
    }

    public function check_kriteria(Request $request)
    {
        $kode = trim($request->input('kode'));
        $nama = trim($request->input('nama'));

        if ($kode == '') {
            $count =  DB::table('kriteria')->where('nama_kriteria', $nama)->count();
        } elseif ($nama == '') {
            $count =  DB::table('kriteria')->where('kode_kriteria', $kode)->count();
        }

        echo json_encode($count);
    }

    public function select_kriteria(Request $request)
    {
        $kat = $request->input('kat');

        $data = [
            'kriteria' => DB::table('kriteria')->where('kat_kriteria', $kat)->get(),
            'sub_kriteria' => DB::table('sub_kriteria')->get()->sortByDesc('nilai'),
            'mode' => $request->input('mode')
        ];

        return view('select_view', $data);
    }

    public function edit_kriteria(Request $request, $id)
    {
        $data = [
            'kode_kriteria' => $request->input('kode_kriteria'),
            'nama_kriteria' => $request->input('nama_kriteria'),
            'bobot_kriteria' => $request->input('bobot_kriteria'),
            'jenis_kriteria' => $request->input('jenis_kriteria'),
        ];

        $query =  DB::table('kriteria')->where('id_kriteria', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Kriteria');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Kriteria');
            return Redirect::back();
        }
    }

    public function delete_kriteria($id_kriteria)
    {
        $query = Kriteria::find($id_kriteria)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit Kriteria');
            return redirect()->back()->with('success', 'Berhasil menghapus Kriteria');
        } else {
            Session::flash('failed', 'Gagal menghapus Kriteria');
            return Redirect::back();
        }
    }

    public function add_sub_kriteria(Request $request, $id)
    {
        $data = [
            'id_sub_kriteria' => UniqueIdGenerator::generate(['table' => 'sub_kriteria', 'field' => 'id_sub_kriteria', 'length' => 7, 'prefix' => 'SUB']),
            'nama_sub_kriteria' => $request->input('nama_sub_kriteria'),
            'nilai' => $request->input('nilai'),
            'id_kriteria' => $id
        ];

        $query =  DB::table('sub_kriteria')->insert($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah Sub Kriteria');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah Sub Kriteria');
            return Redirect::back();
        }
    }

    public function check_sub(Request $request)
    {
        $id = trim($request->input('id'));
        $nama = trim($request->input('nama'));

        $count =  DB::table('sub_kriteria')->where('nama_sub_kriteria', $nama)->where('id_kriteria', $id)->count();

        echo json_encode($count);
    }

    public function edit_sub_kriteria(Request $request, $id)
    {
        $data = [
            'nama_sub_kriteria' => $request->input('nama_sub_kriteria'),
            'nilai' => $request->input('nilai'),
        ];

        $query =  DB::table('sub_kriteria')->where('id_sub_kriteria', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Sub Kriteria');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Sub Kriteria');
            return Redirect::back();
        }
    }

    public function delete_sub_kriteria($id_sub_kriteria)
    {
        $query = DB::table('sub_kriteria')->where('id_sub_kriteria', $id_sub_kriteria)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit Kriteria');
            return redirect()->back()->with('success', 'Berhasil menghapus Sub Kriteria');
        } else {
            Session::flash('failed', 'Gagal menghapus Sub Kriteria');
            return Redirect::back();
        }
    }
}