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

		// Data soal dan dosen
		$data_exists = DB::table('materi')
			->join('soal', 'materi.id_materi', 'soal.id_materi')
			->join('admin', 'soal.id_admin', 'admin.id_admin')
			->select('admin.*')
			->where('materi.id_materi', $id_materi);

		// Data Dosen
		$data['dosen'] = DB::table('materi')
			->join('soal', 'materi.id_materi', 'soal.id_materi')
			->join('admin', 'soal.id_admin', 'admin.id_admin')
			// ->select('admin.id_admin', 'admin.nama_dsn')
			->where('materi.id_materi', $id_materi)
			->groupBy('admin.id_admin')
			->get(['admin.id_admin', 'admin.nama_dsn']);

		// Data jawaban (sudah dijawab atau belum)
		if($data_exists->count() > 0)
			$data['data_exists'] = DB::table('materi')
				->join('soal', 'materi.id_materi', 'soal.id_materi')
				->join('admin', 'soal.id_admin', 'admin.id_admin')
				->leftJoin('jawaban', 'soal.id_soal', 'jawaban.id_soal')
				->select('soal.id_soal')
				->where('materi.id_materi', $id_materi)
				->whereRaw('jawaban.npm = ? is null', session('id'))
				->count();
		else
			$data['data_exists'] = null;

		// return $data['data_exists'];
		return view('mahasiswa.materi_tes', $data);
	}

	function api_soal($id_materi, $id_dosen, Request $request){
		$session = [];
		if(!$request->session()->get('materi_dosen')){
			$request->session()->put('materi_dosen', json_encode([$id_materi, $id_dosen]));
			$session = [$id_materi, $id_dosen];
		}
		else if(json_decode($request->session()->get('materi_dosen'))[0] !== $id_materi){
			$request->session()->put('materi_dosen', json_encode([$id_materi, $id_dosen]));
			$session = [$id_materi, $id_dosen];
		}else{
			$session = json_decode($request->session()->get('materi_dosen'));
		}

		$data = DB::table('soal')
			->select('soal.id_soal','soal.soal')
			->leftJoin('jawaban', 'jawaban.id_soal', 'soal.id_soal')
			->where('soal.id_materi', $session[0])
			->where('soal.id_admin', $session[1])
			->whereRaw("jawaban.npm = ? is null", [session('id')])
			->get();

		return $data;
	}

	function submit_soal($id_materi, Request $request){
		if(!session('materi_dosen'))
			return redirect($_SERVER['HTTP_REFERER'] . '#session_expired');

		$session = json_decode($request->session()->get('materi_dosen'));
		return $request->session()->all();
	}
}