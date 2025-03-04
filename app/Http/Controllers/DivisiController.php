<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class DivisiController extends Controller
{
    public function add_divisi(Request $request)
    {
        $data = [
            'id_divisi' => UniqueIdGenerator::generate(['table' => 'divisi', 'field' => 'id_divisi', 'length' => 7, 'prefix' => 'DIV']),
            'nama_divisi' => $request->input('nama_divisi'),
        ];

        $query =  DB::table('divisi')->insert($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah Divisi');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah Divisi');
            return Redirect::back();
        }
    }

    public function check_divisi(Request $request)
    {
        $nama = trim($request->input('nama'));

        $count =  DB::table('divisi')->where('nama_divisi', $nama)->count();

        echo json_encode($count);
    }

    public function edit_divisi(Request $request, $id)
    {
        $data = [
            'nama_divisi' => $request->input('nama_divisi'),
        ];

        $query =  DB::table('divisi')->where('id_divisi', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit Divisi');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit Divisi');
            return Redirect::back();
        }
    }

    public function delete_divisi($id_divisi)
    {
        $query = Divisi::find($id_divisi)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit Divisi');
            return redirect()->back()->with('success', 'Berhasil menghapus Divisi');
        } else {
            Session::flash('failed', 'Gagal menghapus Divisi');
            return Redirect::back();
        }
    }
}