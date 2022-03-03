<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 
class AdminController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        if(session('is_admin')){
	        	$db = DB::table('admin')->where('id_admin', session('id'))->first();
	        	if(!$db){
	        		$request->session()->flush();
	        		return redirect('/');
	        	}
	        }
	        else
	        	return redirect('/');

	        return $next($request);
    	});
	}

	function dashboard(){
		$cpu = "Tidak didukung";
		$ram = "Tidak didukung";
		$uptime = "Tidak didukung";
		if(function_exists('shell_exec')){
			if(function_exists('sys_getloadavg')){
				$exec_loads = sys_getloadavg();
				$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
				$cpu = round($exec_loads[1]/($exec_cores + 1)*100, 0) . '%';
			}

			if(shell_exec('free')){
				$exec_free = explode("\n", trim(shell_exec('free')));
				$get_mem = preg_split("/[\s]+/", $exec_free[1]);
				$mem = number_format(round($get_mem[2]/1024/1024, 2), 2) . '/' . number_format(round($get_mem[1]/1024/1024, 2), 2);
				$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
				$uptime = $exec_uptime[2] . ' Days';
			}
		}

	    return view('admin.dashboard', [
	    	'cpu'	  => $cpu,
	    	'ram'	  => $ram,
	    	'uptime'  => $uptime
	    ]);
	}

	function dosen(){
		$db = DB::table('admin')->select(['id_admin','email','nama_dsn','hak_akses'])->get();

		return view('admin.dosen', [ 
			'data'	=> $db,
			'i'		=> 1 
		]);
	}

	function tambah_dosen(Request $request){
		if(DB::table('admin')->where('email', strtolower($request->email))->doesntExist()){
			$id = DB::table('admin')->insertGetId([
				'nama_dsn'	=> $request->nama_dsn,
				'email'		=> strtolower($request->email),
				'noHP'		=> $request->noHP,
				'password'	=> bcrypt($request->password),
				'hak_akses'	=> $request->hak_akses
			]);

			$datakelas = [];
			preg_match_all("/[a-zA-Z]+/", strtoupper($request->kelas), $kelas);
			foreach($kelas[0] as $kls){
				$datakelas[] = [
					'id_admin' => $id, 
					'kelas'	   => $kls
				];
			}

			$db = DB::table('kelas')->insert($datakelas);

			return redirect('/admin/dosen#berhasil_disimpan');
		}

		else
			return redirect('/admin/dosen#gagal_disimpan');
	}

	function ubah_dosen(Request $request){
		$data = [
				'nama_dsn'	=> $request->nama_dsn,
				'email'		=> strtolower($request->email),
				'noHP'		=> $request->noHP,
				'hak_akses'	=> $request->hak_akses
			];
		if(!empty($request->password))
			$data['password'] = bcrypt($request->password);

		$db = DB::table('admin')
			->where('id_admin', $request->id_admin)
			->update($data);

		if(!$db)
			return redirect('/admin/dosen#gagal_diubah');
		return redirect('/admin/dosen#berhasil_diubah');
	}

	function hapus_dosen($id){
		$db = false;

		try {
			if($id != session('id_admin'))
				$db = DB::table('admin')->where('id_admin', $id)->delete();

			if(!$db)
				return redirect('/admin/dosen#gagal_dihapus');
		}
		catch(\Illuminate\Database\QueryException $ex){ 
		  return $ex->getMessage(); 
		}

		return redirect('/admin/dosen#berhasil_dihapus');
	}

	function mahasiswa(){
		$db = DB::table('mahasiswa')->select(['npm','email','nama_mhs','kelas'])->get();

		return view('admin.mahasiswa', [ 
			'data'	=> $db,
			'i'		=> 1 
		]);
	}

	function tambah_mahasiswa(Request $request){
		$db = DB::table('mahasiswa')->insert([
			'npm'	=> $request->npm,
			'nama_mhs'	=> $request->nama_mhs,
			'email'		=> $request->email,
			'password'	=> bcrypt($request->password),
			'kelas'	=> $request->kelas
		]);

		if(!$db)
			return redirect('/admin/mahasiswa#gagal_disimpan');
		return redirect('/admin/mahasiswa#berhasil_disimpan');
	}

	function ubah_mahasiswa(Request $request){
		$data = [
				'nama_mhs'	=> $request->nama_mhs,
				'email'		=> $request->email,
				'kelas'		=> $request->kelas
			];
		if(!empty($request->password))
			$data['password'] = bcrypt($request->password);

		$db = DB::table('mahasiswa')
			->where('npm', $request->npm)
			->update($data);

		if(!$db)
			return redirect('/admin/mahasiswa#gagal_diubah');
		return redirect('/admin/mahasiswa#berhasil_diubah');
	}

	function hapus_mahasiswa($id){
		$db = false;

		try {
			$db = DB::table('mahasiswa')->where('npm', $id)->delete();

			if(!$db)
				return redirect('/admin/mahasiswa#gagal_dihapus');
		}
		catch(\Illuminate\Database\QueryException $ex){ 
		  return $ex->getMessage(); 
		}

		return redirect('/admin/mahasiswa#berhasil_dihapus');
	}

	function materi(){
		$db = DB::table('materi')
			->select('*')
			->orderBy('pertemuan', 'asc')
			->get();

		return view('admin.materi', [ 
			'data'	=> $db,
			'i'		=> 1 
		]);
	}

	function tambah_materi(Request $request){
		$db = DB::table('materi')->insert([
			'judul_materi'	=> $request->judul_materi,
			'pertemuan'		=> $request->pertemuan
		]);

		if(!$db)
			return redirect('/admin/materi#gagal_disimpan');
		return redirect('/admin/materi#berhasil_disimpan');		
	}

	function ubah_materi(Request $request){
		$data = [
				'judul_materi'	=> $request->judul_materi,
				'pertemuan'		=> $request->pertemuan
			];

		$db = DB::table('materi')
			->where('id_materi', $request->id_materi)
			->update($data);

		if(!$db)
			return redirect('/admin/materi#gagal_diubah');
		return redirect('/admin/materi#berhasil_diubah');
	}

	function hapus_materi($id){
		$db = false;

		try {
			$db = DB::table('materi')->where('id_materi', $id)->delete();

			if(!$db)
				return redirect('/admin/materi#gagal_dihapus');
		}
		catch(\Illuminate\Database\QueryException $ex){ 
		  return $ex->getMessage(); 
		}

		return redirect('/admin/materi#berhasil_dihapus');
		
	}

}

?>