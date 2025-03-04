<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class JabatanController extends Controller
{
    public function add_jabatan(Request $request)
    {
        $data = [
            'id_jabatan' => UniqueIdGenerator::generate(['table' => 'jabatan', 'field' => 'id_jabatan', 'length' => 7, 'prefix' => 'JAB']),
            'nama_jabatan' => $request->input('nama_jabatan'),
            'id_divisi' => $request->input('divisi'),
        ];

        $query =  DB::table('jabatan')->insert($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah Jabatan');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah Jabatan');
            return Redirect::back();
        }
    }

    public function check_jabatan(Request $request)
    {
        $nama = trim($request->input('nama'));

        $count =  DB::table('jabatan')->where('nama_jabatan', $nama)->count();

        echo json_encode($count);
    }

    public function edit_jabatan(Request $request, $id)
    {
        $data = [
            'nama_jabatan' => $request->input('nama_jabatan'),
            'id_divisi' => $request->input('divisi'),
        ];

        $query =  DB::table('jabatan')->where('id_jabatan', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Jabatan');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Jabatan');
            return Redirect::back();
        }
    }

    public function delete_jabatan($id_jabatan)
    {
        $query = Jabatan::find($id_jabatan)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit Jabatan');
            return redirect()->back()->with('success', 'Berhasil menghapus Jabatan');
        } else {
            Session::flash('failed', 'Gagal menghapus Jabatan');
            return Redirect::back();
        }
    }
}