<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 
class DosenController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        if(session('is_dosen')){
	        	$db = DB::table('admin')->where('id_admin', session('id'))->first();
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
	    return view('dosen.dashboard');
	}

	function materi(){
		$soal = DB::table('soal')
			->where('id_admin', session('id'))
			->join('materi', 'materi.id_materi', '=', 'soal.id_materi')
			->orderBy('soal.id_materi', 'asc')
			->get();

		$materi = DB::table('materi')->get();

		return view('dosen.materi', [ 
			'data'	 => $soal,
			'materi' => $materi,
			'i'		 => 1 
		]);
	}

	function tambah_materi(Request $request){
		$db = DB::table('soal')->insert([
			'id_admin'	   => session('id'),
			'id_materi'	   => $request->id_materi,
			'soal'		   => $request->soal,
			'jawaban_soal' => $request->jawaban_soal
		]);

		if(!$db)
			return redirect('/dosen/materi#gagal_disimpan');
		return redirect('/dosen/materi#berhasil_disimpan');
	}

	function ubah_materi(Request $request){
		$db = DB::table('soal')
			->where('id_soal', $request->id_admin)
			->where('id_admin', session('id'))
			->update([
				'id_materi'	   => $request->id_materi,
				'soal'		   => $request->soal,
				'jawaban_soal' => $request->jawaban_soal
			]);

		if(!$db)
			return redirect('/dosen/materi#gagal_diubah');
		return redirect('/dosen/materi#berhasil_diubah');
	}

	function hapus_materi($id){
		$db = false;

		try {
		$db = DB::table('soal')
			->where('id_soal', $id)
			->where('id_admin', session('id'))
			->delete();

			if(!$db)
				return redirect('/dosen/materi#gagal_dihapus');
		}
		catch(\Illuminate\Database\QueryException $ex){ 
		  return $ex->getMessage(); 
		}

		return redirect('/dosen/materi#berhasil_dihapus');
	}

	function materi_penilaian(){
		$db = DB::table('materi')
			->orderBy('pertemuan', 'asc')
			->get();

		return view('dosen.materi_penilaian', ['data' => $db]);
	}

	function data_jawaban($id_materi){
		$materi = DB::table('materi')
			->select('judul_materi')
			->where('id_materi', $id_materi)
			->first()->judul_materi;

		$kelas = DB::table('mahasiswa')
			->select('kelas')
			->orderBy('kelas', 'asc')
			->groupBy('kelas')
			->get();

		return view('dosen.data_jawaban', [
			'judul_materi' => $materi,
			'kelas' => $kelas
		]);
	}

	function api_mahasiswa($kelas){
		header('Content-Type: application/json');

		$json = array();
		$db = DB::table('mahasiswa')
			->where('mahasiswa.kelas', $kelas)
			->get();

		if($db){
			foreach($db as $data){
					unset($data->password);
					$json[] = $data;
			}
		}

		return json_encode($json);
	}

	function api_jawaban($id_materi, $npm){
		header('Content-Type: application/json');

		$json = [];
		$db = DB::table('soal')
			->join('jawaban', 'soal.id_soal', 'jawaban.id_soal')
			->join('mahasiswa', 'jawaban.npm', 'mahasiswa.npm')
			->where('soal.id_materi', $id_materi)
			->where('mahasiswa.npm', $npm)
			->get();

		foreach($db as $data){
			unset($data->password);
			$json[] = $data;
		}
		return json_encode($json);
	}

	function nilai_jawaban(Request $request){

	}

	function mahasiswa(){
		$mahasiswa = DB::table('mahasiswa')
			->orderBy('kelas', 'asc')
			->orderBy('nama_mhs', 'asc')
			->get();

		$kelas = DB::table('mahasiswa')
			->select('kelas')
			->orderBy('kelas', 'asc')
			->groupBy('kelas')
			->get();

		return view('dosen.mahasiswa', [ 
			'data'	 => $mahasiswa,
			'kelas'	 => $kelas,
			'i'		 => 1 
		]);
	}

	function diagnostics(){
		return view('dosen.diagnostics');
	}

	function profil(){
		$data = DB::table('admin')
			->where('id_admin', session('id'))
			->first();

		return view('dosen.profil', [
			'data' => $data
		]);
	}

	function ubah_profil(Request $request){
		$data = [
				'nama_dsn' => $request->nama_dsn,
				'email'	   => strtolower($request->email)
			];

		if($request->password != null)
			$data['password'] = bcrypt($request->password);

		$db = DB::table('admin')
			->where('id_admin', session('id'))
			->update($data);

		if($db)
			return redirect('/dosen/profil#berhasil_disimpan');
		return redirect('/dosen/profil#gagal_disimpan');
	}
}