@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* DataTables */
	@import url('/vendor/datatables/css/dataTables.bootstrap5.min.css');
	@import url('/vendor/datatables/css/responsive.bootstrap5.min.css');
</style>
<!-- DataTables -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/js/responsive.bootstrap5.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="mt-4">Materi {{ $judul_materi }}</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<tr>
						<th>No.</th>
						<th>NPM</th>
						<th>Nama</th>
						<th>Nilai</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="view-jawaban" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="/dosen/materi/penilaian/nilai" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Periksa Jawaban</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="npm" required>
        <input type="hidden" name="id_materi" required>
        <div class="form-input mb-3">
        	<label>Nama</label>
        	<input type="text" name="nama" class="form-control" readonly>
        	<label>Email</label>
        	<input type="email" name="email" class="form-control" readonly>
        	<label>Kelas</label>
        	<input type="text" name="kelas_mhs" class="form-control" readonly>
        </div>
        <table class="table table-bordered" id="table-soal">
        	<thead>
        		<tr>
        			<th>No.</th>
        			<th>Soal</th>
        			<th>Jawaban Soal</th>
        			<th>Jawaban Mahasiswa</th>
        			<th>Poin</th>
        		</tr>
        	</thead>
        	<tbody id="list-soal"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Template -->
<div class="d-none">
	<div id="inp_kelas">
		Kelas: 
		<select name="kelas" class="form-select form-select-sm d-inline-block w-auto" onchange="update_kelas(this)">
			<option disabled>-- Pilih Kelas</option>
			@foreach($kelas as $data)
			<option value="{{ $data->kelas }}">{{ $data->kelas }}</option>
			@endforeach
		</select>
	</div>
	<div id="td_aksi">
		<button class="btn btn-primary" onclick="view_jawaban('--NPM--');">
			<span class="fas fa-info px-1"></span>
		</button>
	</div>
	<div id="div-soal">
		<tr_table>
			<td_table>--NO--</td_table>
			<td_table>--SOAL--</td_table>
			<td_table>--JAWABAN_SOAL--</td_table>
			<td_table>--JAWABAN_MHS--</td_table>
			<td_table>
				<div class="form-check">
					<input type="radio" name="soal[--INDEX--]" class="form-check-input">
					<label class="form-check-label">Benar</label>
				</div>
				<div class="form-check">
					<input type="radio" name="soal[--INDEX--]" class="form-check-input">
					<label class="form-check-label">Salah</label>
				</div>
			</td_table>
		</tr_table>
	</div>
</div>

<script type="text/javascript">
	var table = $('#table_data').DataTable({
	  "responsive": true,
	  "autoWidth": false,
	  "language": {
		  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
	  },
	  "columnDefs": [
	    { className: "text-center", "targets": [ 0, 3, 4 ] }
	  ],
	  "fnDrawCallback": function (oSettings){
		$('.dataTables_filter').each(function () {
			if($('#opt_kelas').length < 1)
			$(this).append(' <label id="opt_kelas">'
				+ '<script>inp_kelas();<\/script>'
				+ '</label>');
		});
	  }
	});

	getMhs('A');
	
	function update_kelas(id){
		var kelas = $(id).val();
		getMhs(kelas);
	}

	function inp_kelas(){
		$('#opt_kelas').html($('#inp_kelas').html());
	}

	function table_draw(data){
		table.clear();
	    table.rows.add(data);
	    table.draw();
	}

	function getMhs(kelas){
		var template = $('#tabel_data').html();
		var aksi = $('#td_aksi').html();
		var request = $.ajax({
		  url: "/dosen/materi/penilaian/kelas/" + kelas,
		  success: function(msg){
		  	var tb = [];
		  	var json = JSON.parse(msg);

     		$.each(json, function(i, v){
     			aksi = aksi.replaceAll('--NPM--', v.npm);
     			var data_temp = [(i+1) + ".", v.npm, v.nama_mhs, "0", aksi];
     			tb.push(data_temp);
     		});
 			table_draw(tb);
  		  }
		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});
	}

	function view_jawaban(npm){
		var request = $.ajax({
		  url: "/dosen/materi/penilaian/" + window.location.pathname.substr(-1) + "/" + npm,
		  success: function(msg){
		  	var data = JSON.parse(msg);
		  	console.log(msg);
		  	var template = $('#div-soal').html();
		  	var div = "";

		  	$('input[name="nama"]').val(data[0].nama_mhs);
		  	$('input[name="email"]').val(data[0].email);
		  	$('input[name="kelas_mhs"]').val(data[0].kelas);
		  	$.each(data, function(i, v){
		  		div += template
		  			.replaceAll('_table', '')
		  			.replace('--NO--', (i+1)+ ".")
		  			.replace('--SOAL--', v.soal)
		  			.replace('--JAWABAN_SOAL--', v.jawaban_soal)
		  			.replace('--JAWABAN_MHS--', v.jawaban_mhs)
		  			.replaceAll('--INDEX--', i);
		  	});

		  	$('#list-soal').html(div);
		  	$('#view-jawaban').modal('show');
  		  }
		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});
	}

	$(document).ready(function(){
	  	var hash = window.location.hash;
	  	if(hash == '#berhasil_disimpan'){
	  		toastr.success('Data berhasil disimpan');
	  	}
	  	else if(hash == '#gagal_disimpan'){
	  		toastr.error('Data gagal disimpan');
	  	}
	  	else if(hash == '#berhasil_dihapus'){
	  		toastr.success('Data berhasil dihapus');
	  	}
	  	else if(hash == '#gagal_dihapus'){
	  		toastr.error('Data gagal dihapus');
	  	}
	});
</script>

@endsection