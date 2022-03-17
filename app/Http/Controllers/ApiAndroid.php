<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiAndroid extends Controller {

	function login(Request $data){
		$output = [];
		$user = strtolower($data->post('npm'));
        $status = DB::table('mahasiswa')->where('npm', $user)->first();
        if($status != null && Hash::check($data->post('password'), $status->password)){
        	$output['_token'] = base64_encode($data->post('npm'));
        	$output['status'] = 'success';
        }else{
        	$output['status'] = 'fail';
        }

        return $output;
	}

	function materi(){
		$materi = DB::table('materi')
			->orderBy('pertemuan', 'asc')
			->get();

		return $materi;
	}

}