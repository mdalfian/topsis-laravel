<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');

Route::middleware('auth')->group(function () {
    Route::get('admin/home', [AdminController::class, 'index'])->name('admin.home');
    Route::get('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');
    Route::get('admin/kriteria', [AdminController::class, 'kriteria'])->name('admin.kriteria');
    Route::post('kriteria/add', [KriteriaController::class, 'add_kriteria'])->name('add_kriteria');
    Route::post('kriteria/check', [KriteriaController::class, 'check_kriteria'])->name('check_kriteria');
    Route::put('kriteria/edit{id}', [KriteriaController::class, 'edit_kriteria'])->name('edit_kriteria');
    Route::delete('kriteria/delete{id_kriteria}', [KriteriaController::class, 'delete_kriteria'])->name('delete_kriteria');
    Route::get('admin/sub_kriteria', [AdminController::class, 'sub_kriteria'])->name('admin.sub_kriteria');
    Route::post('sub_kriteria/add{id}', [KriteriaController::class, 'add_sub_kriteria'])->name('add_sub_kriteria');
    Route::post('sub_kriteria/check', [KriteriaController::class, 'check_sub'])->name('check_sub');
    Route::put('sub_kriteria/edit{id}', [KriteriaController::class, 'edit_sub_kriteria'])->name('edit_sub_kriteria');
    Route::delete('sub_kriteria/delete{id_sub_kriteria}', [KriteriaController::class, 'delete_sub_kriteria'])->name('delete_sub_kriteria');
    Route::get('admin/alternatif', [AdminController::class, 'alternatif'])->name('admin.alternatif');
    Route::post('alternatif/add', [AlternatifController::class, 'add_alternatif'])->name('add_alternatif');
    Route::post('alternatif/check', [AlternatifController::class, 'check_alternatif'])->name('check_alternatif');
    Route::put('alternatif/edit{id}', [AlternatifController::class, 'edit_alternatif'])->name('edit_alternatif');
    Route::delete('alternatif/delete{id_alternatif}', [AlternatifController::class, 'delete_alternatif'])->name('delete_alternatif');
    Route::get('admin/penilaian', [AdminController::class, 'penilaian'])->name('admin.penilaian');
    Route::post('penilaian/input{id_alternatif}', [PenilaianController::class, 'add_penilaian'])->name('input_penilaian');
    Route::put('penilaian/edit', [PenilaianController::class, 'edit_penilaian'])->name('edit_penilaian');
    Route::get('admin/perhitungan', [AdminController::class, 'perhitungan'])->name('admin.perhitungan');
    Route::get('admin/cetak/pdf', [PenilaianController::class, 'pdf'])->name('admin.cetak.pdf');
    Route::get('admin/user', [AdminController::class, 'user'])->name('admin.user');
    Route::post('user/add', [UserController::class, 'add_user'])->name('add_user');
    Route::put('user/edit{id}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::delete('user/delete{id_user}', [UserController::class, 'delete_user'])->name('delete_user');
    Route::get('admin/divisi', [AdminController::class, 'divisi'])->name('admin.divisi');
    Route::post('divisi/add', [DivisiController::class, 'add_divisi'])->name('add_divisi');
    Route::post('divisi/check', [DivisiController::class, 'check_divisi'])->name('check_divisi');
    Route::put('divisi/edit{id}', [DivisiController::class, 'edit_divisi'])->name('edit_divisi');
    Route::delete('divisi/delete{id_divisi}', [DivisiController::class, 'delete_divisi'])->name('delete_divisi');
    Route::get('admin/jabatan', [AdminController::class, 'jabatan'])->name('admin.jabatan');
    Route::post('jabatan/add', [JabatanController::class, 'add_jabatan'])->name('add_jabatan');
    Route::post('jabatan/check', [JabatanController::class, 'check_jabatan'])->name('check_jabatan');
    Route::put('jabatan/edit{id}', [JabatanController::class, 'edit_jabatan'])->name('edit_jabatan');
    Route::delete('jabatan/delete{id_jabatan}', [JabatanController::class, 'delete_jabatan'])->name('delete_jabatan');
});
// Route::get('admin/home', [AdminController::class, 'index'])->name('admin.home');
// Route::get('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');
// Route::get('admin/kriteria', [AdminController::class, 'kriteria'])->name('admin.kriteria');
// Route::post('kriteria/add', [KriteriaController::class, 'add_kriteria'])->name('add_kriteria');
// Route::put('kriteria/edit{id}', [KriteriaController::class, 'edit_kriteria'])->name('edit_kriteria');
// Route::delete('kriteria/delete{id_kriteria}', [KriteriaController::class, 'delete_kriteria'])->name('delete_kriteria');
// Route::get('admin/sub_kriteria', [AdminController::class, 'sub_kriteria'])->name('admin.sub_kriteria');
// Route::post('sub_kriteria/add{id}', [KriteriaController::class, 'add_sub_kriteria'])->name('add_sub_kriteria');
// Route::put('sub_kriteria/edit{id}', [KriteriaController::class, 'edit_sub_kriteria'])->name('edit_sub_kriteria');
// Route::delete('sub_kriteria/delete{id_sub_kriteria}', [KriteriaController::class, 'delete_sub_kriteria'])->name('delete_sub_kriteria');
// Route::get('admin/alternatif', [AdminController::class, 'alternatif'])->name('admin.alternatif');
// Route::post('alternatif/add', [AlternatifController::class, 'add_alternatif'])->name('add_alternatif');
// Route::put('alternatif/edit{id}', [AlternatifController::class, 'edit_alternatif'])->name('edit_alternatif');
// Route::delete('alternatif/delete{id_alternatif}', [AlternatifController::class, 'delete_alternatif'])->name('delete_alternatif');
// Route::get('admin/penilaian', [AdminController::class, 'penilaian'])->name('admin.penilaian');
// Route::post('penilaian/input{id_alternatif}', [PenilaianController::class, 'add_penilaian'])->name('input_penilaian');
// Route::put('penilaian/edit', [PenilaianController::class, 'edit_penilaian'])->name('edit_penilaian');
// Route::get('admin/perhitungan', [AdminController::class, 'perhitungan'])->name('admin.perhitungan');
// Route::get('admin/cetak/pdf', [PenilaianController::class, 'pdf'])->name('admin.cetak.pdf');
// Route::get('admin/user', [AdminController::class, 'user'])->name('admin.user');
// Route::post('user/add', [UserController::class, 'add_user'])->name('add_user');
// Route::put('user/edit{id}', [UserController::class, 'edit_user'])->name('edit_user');
// Route::delete('user/delete{id_user}', [UserController::class, 'delete_user'])->name('delete_user');

Route::middleware('auth')->group(function () {
    Route::get('pemilik/home', [PemilikController::class, 'index'])->name('pemilik.home');
    Route::get('pemilik/penilaian', [PemilikController::class, 'penilaian'])->name('pemilik.penilaian');
    Route::get('pemilik/perhitungan', [PemilikController::class, 'perhitungan'])->name('pemilik.perhitungan');
    Route::get('pemilik/profil', [PemilikController::class, 'profile'])->name('pemilik.profil');
    Route::put('pemilik/profil/edit{id}', [PemilikController::class, 'edit_profile'])->name('edit_profile');
    Route::get('pemilik/cetak/pdf', [PenilaianController::class, 'pdf'])->name('pemilik.cetak.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('karyawan/home', [KaryawanController::class, 'index'])->name('karyawan.home');
    Route::get('karyawan/penilaian', [KaryawanController::class, 'penilaian'])->name('karyawan.penilaian');
    Route::get('karyawan/perhitungan', [KaryawanController::class, 'perhitungan'])->name('karyawan.perhitungan');
    Route::get('karyawan/profil', [KaryawanController::class, 'profile'])->name('karyawan.profil');
    Route::put('karyawan/profil/edit{id}', [KaryawanController::class, 'edit_profile'])->name('edit_profile');
    Route::get('karyawan/cetak/pdf', [PenilaianController::class, 'pdf'])->name('karyawan.cetak.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('leader/home', [LeaderController::class, 'index'])->name('leader.home');
    Route::get('leader/alternatif', [LeaderController::class, 'alternatif'])->name('leader.alternatif');
    Route::post('alternatif/add', [AlternatifController::class, 'add_alternatif'])->name('add_alternatif');
    Route::post('alternatif/check', [AlternatifController::class, 'check_alternatif'])->name('check_alternatif');
    Route::put('alternatif/edit{id}', [AlternatifController::class, 'edit_alternatif'])->name('edit_alternatif');
    Route::delete('alternatif/delete{id_alternatif}', [AlternatifController::class, 'delete_alternatif'])->name('delete_alternatif');
    Route::get('leader/perhitungan', [LeaderController::class, 'perhitungan'])->name('leader.perhitungan');
    Route::get('leader/profil', [LeaderController::class, 'profile'])->name('leader.profil');
    Route::put('leader/profil/edit{id}', [LeaderController::class, 'edit_profile'])->name('edit_profile');
    Route::get('leader/cetak/pdf', [PenilaianController::class, 'pdf'])->name('leader.cetak.pdf');
});
