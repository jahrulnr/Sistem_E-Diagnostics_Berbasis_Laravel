<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
 
class MainController extends Controller {

	function index(Request $request){
        if(session('is_admin'))
        	return redirect('/admin/');

        else if(session('is_dosen'))
        	return redirect('/dosen/');

        else if(session('is_mahasiswa'))
        	return redirect('/mahasiswa/');

        else
	        return view('login');
	}

	function verify(Request $request){
        $route = Route::getFacadeRoot()->current()->uri();
		if($route=='login'){
            $user = strtolower($request->post('email'));
            $status = DB::table('admin')->where('email', $user)->first();
            if($status != null && Hash::check($request->post('password'), $status->password)){
                $session = array(
                    'id'   => $status->id_admin,
                    'nama' => $status->nama_dsn,
                );

                if($status->hak_akses == 'admin')
                    $session['is_admin'] = true;
                else 
                    $session['is_dosen'] = true;

                session($session);
                return redirect('/');
            }else{
                return redirect('/#login_gagal');
            }
        }
        else {
            $user = strtolower($request->post('npm'));
            $status = DB::table('mahasiswa')->where('npm', $user)->first();
            if($status != null && Hash::check($request->post('password'), $status->password)){
                $session = array(
                    'is_mahasiswa' => true,
                    'id'   => $status->npm,
                    'nama' => $status->nama_mhs,
                    'id_kelas' => $status->id_kelas 
                );

                session($session);
                return redirect('/admin/');
            }else{
                return redirect('/#login_gagal');
            }
        }
	}

	function logout(Request $request){
		$session = array(
            'is_admin'     => null,
			'is_dosen'     => null,
			'is_mahasiswa' => null,
            'id_user'      => null,
            'nama'         => null,
            'id_kelas'     => null
        );
        session($session);
        return "<script>window.location.href='/' + window.location.hash;</script>";
	}

}