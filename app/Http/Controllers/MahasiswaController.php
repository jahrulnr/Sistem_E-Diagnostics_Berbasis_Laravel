<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
 
class MahasiswaController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        if(session('is_mahasiswa')){
	        	$db = DB::table('mahasiswa')->where('npm', session('id'))->first();
	        	if(!$db){
	        		$request->session()->flush();
	        		return redirect('/#login_gagal');
	        	}
	        }
	        else
	        	return redirect('/');

	        return $next($request);
    	});
	}

	function dashboard(){
	    return view('mahasiswa.dashboard');
	}

	function materi(){
		$db = DB::table('materi')
			->orderBy('pertemuan', 'asc')
			->get();

		return view('mahasiswa.materi', ['data' => $db]);
	}

	function form_tes($id_materi){
		// Data Materi
		$data['materi'] = DB::table('materi')
			->where('id_materi', $id_materi)
			->first();

		$data['dosen'] = DB::table('admin')
			->select('admin.*')
			->join('kelas', 'kelas.id_admin', 'admin.id_admin')
			->where('kelas.id_kelas', session('id_kelas'))
			->first();
		// return $data['dosen'];

		// Data soal dan jawaban
		$data['soal'] = DB::table('soal')
			->select(['soal.*', 'jawaban.jawaban_mhs'])
			->leftJoin('jawaban', 'soal.id_soal', 'jawaban.id_soal')
			->where('id_admin', $data['dosen']->id_admin)
			->where('id_materi', $id_materi);
		$data['soal_count'] = $data['soal']->count();
		$data['soal'] = $data['soal']->get();
		// return $data['soal'];
		
		// cek jawaban
		$data['jawaban'] = false;
		foreach($data['soal'] as $soal) {
			if($soal->jawaban_mhs != null){
				$data['jawaban'] = true;
				break;
			}
		}

		return view('mahasiswa.materi_tes', $data);
	}

	function submit_soal($id_materi, Request $request){
		$data = [];
		foreach($request->jawaban as $id => $jawaban){
			if( 
			DB::table('jawaban')
				->where('npm', session('id'))
				->where('id_soal', $id)
				->exists()
			)

			$data[] = [
				'npm'	  	  => session('id'),
				'id_soal' 	  => $id,
				'jawaban_mhs' => $jawaban
			];
		}

		if(!empty($data))
			DB::table('jawaban')
				->insert($data);

		return redirect(url()->previous() . '#berhasil_disimpan');
	}
}