<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Session;
use App\User;

class AuthController extends Controller
{

    public function login()
    {
        if (FacadesAuth::check()) {
            return redirect('home');
        } else {
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (FacadesAuth::Attempt($data)) {
            if (FacadesAuth::user()->level == 'Admin') {
                return redirect('admin/home');
            } elseif (FacadesAuth::user()->level == 'Pemilik') {
                return redirect('pemilik/home');
            } elseif (FacadesAuth::user()->level == 'Leader') {
                return redirect('leader/home');
            } else {
                return redirect('karyawan/home');
            }
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        FacadesAuth::logout();
        return redirect('/');
    }
}
