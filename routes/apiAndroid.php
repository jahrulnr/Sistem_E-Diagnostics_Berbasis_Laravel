<?php

	Route::post('api/login', 'App\Http\Controllers\ApiAndroid@login');
	Route::get('api/materi', 'App\Http\Controllers\ApiAndroid@materi');
	
	// Global API
	Route::get('/api/kelas/{id_dosen}', 'App\Http\Controllers\MainController@getKelas')->name('getKelas');