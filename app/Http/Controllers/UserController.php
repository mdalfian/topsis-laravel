<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class UserController extends Controller
{
    public function add_user(Request $request)
    {
        $data = [
            'name' => $request->input('nama_lengkap'),
            'username' => $request->input('username'),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT, ['cost' => 12]),
            'level' => $request->input('level'),
            'id_jabatan' => $request->input('jabatan'),
        ];

        $query =  DB::table('users')->insert($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil menambah User');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal menambah User');
            return Redirect::back();
        }
    }

    public function edit_user(Request $request, $id)
    {
        $pass = $request->input('password');
        $op = $request->input('op');

        $data = [
            'name' => $request->input('nama_lengkap'),
            'username' => $request->input('username'),
            'password' => $pass == '' ? $op :  password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]),
            'level' => $request->input('level'),
            'id_jabatan' => $request->input('jabatan'),
        ];

        $query =  DB::table('users')->where('id', $id)->update($data);

        if ($query > 0) {
            Session::flash('success', 'Berhasil mengedit User');
            return Redirect::back();
        } else {
            Session::flash('failed', 'Gagal mengedit User');
            return Redirect::back();
        }
    }

    public function delete_user($id_user)
    {
        $query = DB::table('users')->where('id', $id_user)->delete();

        if ($query > 0) {
            // Session::flash('success', 'Berhasil mengedit User');
            return redirect()->back()->with('success', 'Berhasil menghapus User');
        } else {
            Session::flash('failed', 'Gagal menghapus User');
            return Redirect::back();
        }
    }
}