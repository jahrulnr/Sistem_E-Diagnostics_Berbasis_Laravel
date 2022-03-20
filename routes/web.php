<?php

use Illuminate\Support\Facades\Route;
require_once 'apiAndroid.php';

Route::get('/welcome', function () {
    return view('welcome');
}); 

Route::get('/ping', function(){});

// Login
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::post('/login', 'App\Http\Controllers\MainController@verify');
Route::post('/mahasiswa/login', 'App\Http\Controllers\MainController@verify');

// Logout 
Route::get('/keluar', 'App\Http\Controllers\MainController@logout');

// Admin
Route::get('/admin', 'App\Http\Controllers\AdminController@dashboard'); 
Route::post('/admin/importExcel', 'App\Http\Controllers\AdminController@importExel');

Route::get('/admin/dosen', 'App\Http\Controllers\AdminController@dosen'); 
Route::post('/admin/dosen/kelas/tambah', 'App\Http\Controllers\AdminController@tambah_kelas'); 
Route::get('/admin/dosen/kelas/hapus/{id}', 'App\Http\Controllers\AdminController@tambah_kelas'); 
Route::post('/admin/dosen/tambah', 'App\Http\Controllers\AdminController@tambah_dosen'); 
Route::post('/admin/dosen/ubah', 'App\Http\Controllers\AdminController@ubah_dosen'); 
Route::get('/admin/dosen/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_dosen'); 

Route::get('/admin/mahasiswa', 'App\Http\Controllers\AdminController@mahasiswa'); 
Route::post('/admin/mahasiswa/tambah', 'App\Http\Controllers\AdminController@tambah_mahasiswa'); 
Route::post('/admin/mahasiswa/ubah', 'App\Http\Controllers\AdminController@ubah_mahasiswa'); 
Route::get('/admin/mahasiswa/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_mahasiswa'); 

Route::get('/admin/materi', 'App\Http\Controllers\AdminController@materi'); 
Route::post('/admin/materi/tambah', 'App\Http\Controllers\AdminController@tambah_materi'); 
Route::post('/admin/materi/ubah', 'App\Http\Controllers\AdminController@ubah_materi'); 
Route::get('/admin/materi/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_materi'); 

// Dosen
Route::get('/dosen', 'App\Http\Controllers\DosenController@dashboard'); 

// Materi
Route::get('/dosen/materi', 'App\Http\Controllers\DosenController@materi'); 
Route::post('/dosen/materi/tambah', 'App\Http\Controllers\DosenController@tambah_materi'); 
Route::post('/dosen/materi/ubah', 'App\Http\Controllers\DosenController@ubah_materi'); 
Route::get('/dosen/materi/hapus/{id}', 'App\Http\Controllers\DosenController@hapus_materi'); 

// -- Penilaian Materi
Route::get('/dosen/materi/penilaian', 'App\Http\Controllers\DosenController@materi_penilaian');
Route::get('/dosen/materi/penilaian/{id_materi}', 'App\Http\Controllers\DosenController@data_jawaban');
Route::get('/dosen/materi/penilaian/kelas/{kelas}', 'App\Http\Controllers\DosenController@api_mahasiswa');
Route::get('/dosen/materi/penilaian/{id_materi}/{npm}', 'App\Http\Controllers\DosenController@api_jawaban');
Route::post('/dosen/materi/penilaian/nilai', 'App\Http\Controllers\DosenController@nilai_jawaban');

// -- Mahasiswa
Route::get('/dosen/mahasiswa', 'App\Http\Controllers\DosenController@mahasiswa'); 
Route::post('/dosen/mahasiswa/tambah', 'App\Http\Controllers\DosenController@tambah_mahasiswa'); 
Route::post('/dosen/mahasiswa/ubah', 'App\Http\Controllers\DosenController@ubah_mahasiswa'); 
Route::get('/dosen/mahasiswa/hapus/{id}', 'App\Http\Controllers\DosenController@hapus_mahasiswa'); 

// -- Diagnosis -- belum siap
Route::get('/dosen/diagnostics', 'App\Http\Controllers\DosenController@diagnostics');

// -- Profil
Route::get('/dosen/profil', 'App\Http\Controllers\DosenController@profil');
Route::post('/dosen/profil/ubah', 'App\Http\Controllers\DosenController@ubah_profil');

// Mahasiswa
Route::get('/mahasiswa', 'App\Http\Controllers\MahasiswaController@dashboard');  
Route::get('/mahasiswa/materi', 'App\Http\Controllers\MahasiswaController@materi');
Route::get('/mahasiswa/materi/{id_materi}', 'App\Http\Controllers\MahasiswaController@form_tes');  
Route::post('/mahasiswa/materi/{id_materi}', 'App\Http\Controllers\MahasiswaController@submit_soal');  
Route::post('/mahasiswa/materi/{id_materi}/{id_dosen}', 'App\Http\Controllers\MahasiswaController@api_soal');  
Route::get('/mahasiswa/profil', 'App\Http\Controllers\MahasiswaController@profil');  
Route::post('/mahasiswa/profil/simpan', 'App\Http\Controllers\MahasiswaController@ubah_profil');  
Route::get('/mahasiswa/hasil_tes', 'App\Http\Controllers\MahasiswaController@hasil_tes');  
