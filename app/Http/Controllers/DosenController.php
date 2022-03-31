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
		$materi = DB::table('materi')->get();

		return view('dosen.materi', [ 
			'materi' => $materi,
			'i'		 => 1 
		]);
	}

	function data_materi($id_materi){
		$soal = DB::table('soal')
			->where('id_admin', session('id'))
			->join('materi', 'materi.id_materi', '=', 'soal.id_materi')
			->where('soal.id_materi', $id_materi)
			->orderBy('soal.id_materi', 'asc')
			->get();

		$jumlah_bobot = 0;
		foreach($soal as $c)
			$jumlah_bobot += $c->bobot;

		return (object) [
			'data'	 => $soal,
			'jumlah_bobot' => $jumlah_bobot
		];
	}

	function tambah_materi(Request $request){
		$db = DB::table('soal')->insert([
			'id_admin'	   => session('id'),
			'id_materi'	   => $request->id_materi,
			'soal'		   => $request->soal,
			'jawaban_soal' => $request->jawaban_soal,
			'bobot'		   => $request->bobot
		]);

		if(!$db)
			return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&gagal_disimpan";</script>';//return redirect('/dosen/materi#gagal_disimpan');
		return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&berhasil_disimpan";</script>';// redirect('/dosen/materi#berhasil_disimpan');
	}

	function ubah_materi(Request $request){
		try { 
			$db = DB::table('soal')
				->where('id_soal', $request->id_soal)
				->where('id_admin', session('id'))
				->update([
					'id_materi'	   => $request->id_materi,
					'soal'		   => $request->soal,
					'jawaban_soal' => $request->jawaban_soal,
					'bobot'		   => $request->bobot
				]);

		} catch(\Exception $ex){ 
		  return ($ex->getMessage()); 
		}

		if(!$db)
		// 	return redirect('/dosen/materi#gagal_diubah');
		// return redirect('/dosen/materi#berhasil_diubah');
			return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&gagal_diubah";</script>';
		return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&berhasil_diubah";</script>';
	}

	function hapus_materi($id){
		$db = DB::table('soal')
			->where('id_soal', $id)
			->where('id_admin', session('id'))
			->delete();

		if(!$db)
		// 	return redirect('/dosen/materi#gagal_dihapus');
		// return redirect('/dosen/materi#berhasil_dihapus');
			return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&gagal_dihapus";</script>';
		return '<script>window.location.href = "'.url()->previous().'" + window.location.hash + "&berhasil_dihapus";</script>';
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

		$kelas = DB::table('kelas')
			->where('id_admin', session('id'))
			->get();

		return view('dosen.data_jawaban', [
			'judul_materi' => $materi,
			'kelas' => $kelas
		]);
	}

	function api_mahasiswa($kelas){
		$json = array();
		$db = DB::table('mahasiswa')
			->where('id_kelas', $kelas)
			->orderBy('nama_mhs', 'asc')
			->get();

		$id_materi = strpos("@".parse_url(url()->previous())['path'], '/dosen/materi/penilaian/') > 0 ? 
			substr(parse_url(url()->previous())['path'], 24) : false;
		if($db){
			foreach($db as $data){
				if($id_materi > 0){
					$c_jawaban = DB::table('soal')
						->join('jawaban', 'soal.id_soal', 'jawaban.id_soal')
						->join('mahasiswa', 'jawaban.npm', 'mahasiswa.npm')
						->leftJoin('nilai', function($join){
							$join->on('soal.id_materi', 'nilai.id_materi');
							$join->on('mahasiswa.npm', 'nilai.npm');
						})
						// ->join('nilai', 'soal.id_materi', 'nilai.id_materi')
						->where('soal.id_materi', $id_materi)
						->where('mahasiswa.npm', $data->npm);
					$data->c_jawaban = $c_jawaban->count();
					$data->nilai = $data->c_jawaban > 0 ? $c_jawaban->first()->nilai_akhir : '-';
				}

				unset($data->password);
				$json[] = $data;
			}
		}

		return $json;
	}

	function api_jawaban($id_materi, $npm){
		$json = [];
		$db = DB::table('soal')
			->select([
				'mahasiswa.npm','mahasiswa.email','mahasiswa.nama_mhs','kelas.kelas',
				'jawaban.*', 'soal.*'
			])
			->join('jawaban', 'soal.id_soal', 'jawaban.id_soal')
			->join('mahasiswa', 'jawaban.npm', 'mahasiswa.npm')
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where('soal.id_materi', $id_materi)
			->where('mahasiswa.npm', $npm)
			->get();

		$total_bobot = 0.0;
		foreach($db as $data){
			unset($data->password);
			$total_bobot += $data->bobot;
			$json[] = $data;
		}

		if(empty($json))
			return false;
		else{
			$json['total_bobot'] = $total_bobot;
			return $json;
		}
	}

	function nilai_jawaban(Request $request){
		$data = [
			'npm'	    => $request->npm,
			'id_materi' => $request->id_materi
		];

		$jumlah_bobot = 0.0;
		foreach($request->id_soal as $id => $val){
			$jumlah_bobot += (float) $val;
			DB::table('jawaban')
				->where('npm', $data['npm'])
				->where('id_soal', $id)
				->update(['bobot_jawaban' => (float) $val]);
		}

		if(
			DB::table('nilai')
				->where('npm', $data['npm'])
				->where('id_materi', $data['id_materi'])
				->doesntExist()
		){
			$data['nilai_akhir'] =  ($jumlah_bobot / (float) $request->soal_total) * 100.0;
			DB::table('nilai')
				->insert($data);
		}
		else {
			DB::table('nilai')
				->where($data)
				->update(['nilai_akhir' => ($jumlah_bobot / (float) $request->soal_total) * 100.0]);
		}

		// Server ga bisa nangkap hash dari browser
		// Jadi ga bisa pake script di bawah ini
		// return redirect(url()->previous());

		// Untuk fix nya, kita pake javascript buat ngalihkan halaman
		return '
			<html style="background: #000"></html>
			<script>window.location.href = "'.url()->previous().'" + window.location.hash;</script>';
	}

	function mahasiswa(){
		$mahasiswa = DB::table('mahasiswa')
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->orderBy('kelas', 'asc')
			->orderBy('nama_mhs', 'asc')
			->get();

		$kelas = DB::table('kelas')
			->where('id_admin', session('id'))
			->orderBy('kelas', 'asc')
			->get();

		return view('dosen.mahasiswa', [ 
			'data'	 => $mahasiswa,
			'kelas'	 => $kelas
		]);
	}

	function diagnostics(){
		$data['materi'] = DB::table('materi')
			->orderBy('pertemuan', 'asc')->get();
		$data['kelas'] = DB::table('kelas')
			->where('id_admin', session('id'))
			->orderBy('kelas', 'asc')
			->groupBy('kelas')
			->get();
		$data['seluruhMateri'] = DB::table('materi')
			->select([
				'materi.*',
				DB::raw("AVG(if(materi.id_materi=nilai.id_materi,nilai_akhir,null)) as rata_rata")
			])
			->leftJoin('soal', function($join){
				$join->on('materi.id_materi', 'soal.id_materi');
				// $join->on('soal.id_admin', DB::raw("'".session('id')."'"));
				$join->where('soal.id_admin', session('id'));
			})
			->leftJoin('nilai', function($join){
				$join->on('soal.id_materi', 'nilai.id_materi');
			})
			->groupBy('judul_materi')
			->orderBy('pertemuan', 'asc')
			->get();
		$data['seluruhKelas'] = DB::table('kelas')
			->select([
				'kelas.*',
				// 'mahasiswa.*',
				DB::raw("AVG(if(mahasiswa.npm=nilai.npm,nilai_akhir,0)) as rata_rata")
			])
			->leftJoin('mahasiswa', 'kelas.id_kelas', 'mahasiswa.id_kelas')
			->leftJoin('nilai', 'mahasiswa.npm', 'nilai.npm')
			->where('kelas.id_admin', session('id'))
			->groupBy('kelas.kelas')
			->orderBy('kelas.kelas', 'asc')
			->get();
		$data['seluruhSoal'] = DB::table('soal')
			->select([
				'soal.*',
				'materi.*',
				// 'mahasiswa.*',
				DB::raw("(AVG(if(soal.id_soal=jawaban.id_soal,jawaban.bobot_jawaban,0))/soal.bobot*100) as rata_rata")
			])
			->leftJoin('jawaban', 'soal.id_soal', 'jawaban.id_soal')
			->leftJoin('materi', 'soal.id_materi', 'materi.id_materi')
			->where('soal.id_admin', session('id'))
			->groupBy('soal.id_soal')
			->orderBy('soal.id_soal', 'asc')
			->get();
			// return $data['seluruhSoal'];
		$data['rata2_semua_materi'] = DB::table('nilai')
			->select([
				DB::raw("sum(nilai_akhir) as total"),
				DB::raw("count(nilai_akhir) as jumlah")
			])
			->join('mahasiswa', 'nilai.npm', 'mahasiswa.npm')
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where('kelas.id_admin', session('id'))
			->first(); 
			// return $data['rata2_semua_materi'];

		$data['rata2_semua_materi'] = 
			$data['rata2_semua_materi']->jumlah > 0
			? $data['rata2_semua_materi']->total/$data['rata2_semua_materi']->jumlah : 0;

		return view('dosen.diagnostics', $data);
	}

	function diagnostics_kelas($kelas){
		$data = DB::table('mahasiswa')
			->select(['mahasiswa.npm', 'mahasiswa.nama_mhs'])
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where('kelas.kelas', $kelas)
			->where('kelas.id_admin', session('id'))
			->get();
		return $data;
	}

	function diagnostics_permateri($materi, $kelas){
		$data = DB::table('mahasiswa')
			->select(['mahasiswa.npm', 'mahasiswa.nama_mhs', 'nilai.*'])
			->join('nilai', 'mahasiswa.npm', 'nilai.npm')
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where('id_materi', $materi)
			->where('kelas.kelas', $kelas)
			->where('kelas.id_admin', session('id'))
			->get();

		return $data;
	}

	function diagnostics_permahasiswa($npm){
		$data = DB::table('materi')
			->select(['materi.*', 'nilai.*'])
			->join('nilai', 'materi.id_materi', 'nilai.id_materi')
			->join('mahasiswa', 'mahasiswa.npm', 'nilai.npm')
			->join('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where('mahasiswa.npm', $npm)
			->where('kelas.id_admin', session('id'))
			->orderBy('pertemuan', 'asc')
			->get();

		return $data;
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