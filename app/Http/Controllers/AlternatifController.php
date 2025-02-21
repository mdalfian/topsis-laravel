<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AlternatifController extends Controller
{
    public function add_alternatif(Request $request)
    {
        $data = [
            'nama_alternatif' => $request->input('nama_alternatif'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
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

    public function edit_alternatif(Request $request, $id)
    {
        $data = [
            'nama_alternatif' => $request->input('nama_alternatif'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
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