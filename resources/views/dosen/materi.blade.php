@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* DataTables */
	@import url('/vendor/datatables/css/dataTables.bootstrap5.min.css');
	@import url('/vendor/datatables/css/responsive.bootstrap5.min.css');
	/* Toastr */
	@import url('/vendor/toastr/toastr.min.css');
</style>
<!-- DataTables -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/js/responsive.bootstrap5.min.js"></script>
<!-- Toastr -->
<script src="/vendor/toastr/toastr.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="my-4">Kelola Materi</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<th>No.</th>
					<th>Soal</th>
					<th>Kunci Jawaban</th>
					<th>Bobot</th>
					<th>Aksi</th>
				</thead>
				<tbody></tbody>
			</table>
			<table_data class="d-none">
				<div class="table_aksi">
					<data id="data---ID-SOAL--" class="d-none">--DATA-JSON--</data>
					<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="info('#data---ID-SOAL--')">
						<span class="fas fa-info px-1"></span>
					</button>
					<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="edit('#data---ID-SOAL--')">
						<span class="fas fa-pencil-alt"></span>
					</button>
					<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('--ID-SOAL--')">
						<span class="fas fa-trash"></span>
					</button>
				</div>
			</table_data>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambah_header">Tambah Soal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="id_soal">
        <div class="form-input mb-3">
        	<label>Judul Materi</label>
        	<select type="text" name="id_materi" class="form-select" required>
        		<option disabled selected>-- Pilih Materi</option>
        		@foreach($materi as $m)
        			<option value="{{ $m->id_materi }}">{{ $m->judul_materi }}</option>
        		@endforeach
        	</select>
        </div>
        <div class="form-input mb-3">
        	<label>Soal</label>
        	<textarea name="soal" class="form-control" rows="5" placeholder="Soal" required></textarea>
        </div>
        <div class="form-input mb-3">
        	<label>Jawaban</label>
        	<textarea name="jawaban_soal" class="form-control" rows="2" placeholder="Jawaban" required></textarea>
        </div>
        <div class="form-input mb-3">
        	<label>Bobot Soal</label>
        	<input type="number" min="0" value="" name="bobot" class="form-control" placeholder="Bobot Soal" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="label_hapus" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label_hapus">
           Hapus Soal
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	Yakin menghapus soal ini?<br/>
      	<small class="text-danger">
      		* Menghapus soal akan menghapus semua data yang terkait. (Ex. Jawaban, Hasil Diagnosis, dll.)
      	</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        	Tidak
        </button>
        <a href="#" class="btn btn-danger" id="hapus_data">
        	Ya
        </a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var $form = $('form')[0];
	var $input = $('form').find('select, textarea, input');

	function info(id){
		edit(id);
		$('#tambah_header').html("Rincian Soal Materi");
		$.each($input, function(i, v){
			$(v).attr('disabled', 'disabled');
		});
		$('form button[type="submit"]').hide();
	}

	function tambah(){
		$('form').attr('action', '/dosen/materi/tambah#materi=' + $('#data_materi').val());
		$('#tambah_header').html("Tambah Soal Materi");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('form button[type="submit"]').show();
		if($('#jumlah_bobot').html()*1.0 < 100 || $('#jumlah_bobot').html() == null){
			$("#tambah").modal('show');
			$("#tambah").find('select').val($('#data_materi').val());
		}
		else
			toastr.error("Bobot melebihi batas (Maks. 100).<br/>Silakan kurangi bobot soal terlebih dahulu.");
	}

	function edit(id){
		var data = JSON.parse($(id).html());
		$('form').attr('action', '/dosen/materi/ubah#materi=' + $('#data_materi').val());
		$('#tambah_header').html("Ubah Soal Materi");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('input[name="id_soal"]').val(data['id_soal']);
		$('select[name="id_materi"]').val(data['id_materi']);
		$('textarea[name="soal"]').val(data['soal']);
		$('textarea[name="jawaban_soal"]').val(data['jawaban_soal']);
		$('input[name="bobot"]').val(data['bobot']);
		$('form button[type="submit"]').show();
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/dosen/materi/hapus/' + id + '#materi=' + $('#data_materi').val());
	}

	var table;
	var table_opt = {
	  "responsive": true,
	  "autoWidth": false,
	  "language": {
		  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
	  },
	  columnDefs: [
	  	{targets: 0,className: 'text-center'},
	  	{targets: 3,className: 'text-center'},
	  	{targets: 4,className: 'text-center'}
  	],
	  initComplete: function (settings, json){
			$('.dataTables_filter')
				.append(' <span class="d-none d-md-inline">|</span> <button class="btn btn-info btn-sm mb-1" id="btn_add" onclick="tambah()">Tambah Materi</button>');
			$('#table_data_length')
				.append('<div class="mb-1 ms-1 d-md-inline d-block"><span class="d-none d-md-inline">|</span> Materi: <select class="form-select form-select-sm w-auto d-inline" style="max-width: 40%;" id="data_materi">'+
					$('select[name="id_materi"]').html() +
					'</select></div>');

			if((window.location.hash).search('materi') > 0)
				$('#data_materi').val((window.location.hash).substr(8, (window.location.hash).search('&')-8));
			if($('#data_materi').val() != null) update_table();
			$('#data_materi').change(function(){
				update_table();
			});
	  }
	};

	table = $('#table_data').DataTable(table_opt);

	function update_table(){
		var id_materi = $('#data_materi').val();
		var tmp_row = $('.table_aksi').html()
			.replaceAll('tr_data', 'tr').replaceAll('td_data', 'td');
		var tb_data = [];
		$.ajax({
			url: '/dosen/materi/' + id_materi,
			type: "GET",
			success: function(msg){
				// $('#total-bobot').html(msg.jumlah_bobot);
				if(msg.data == null)
					tb_data = [];
				else {
					$.each(msg.data, function(i, v){
						var data_temp = [
							(i+1) + ".",
							v.soal.length > 40 ? v.soal.substr(0, 40) + "..." : v.soal,
							v.jawaban_soal.length > 40 ? v.jawaban_soal.substr(0, 40) + "..." : v.jawaban_soal,
							v.bobot,
							tmp_row.replace("--DATA-JSON--", JSON.stringify(v))
								.replaceAll("--ID-SOAL--", v.id_soal)
						];
						tb_data.push(data_temp);
					});
				}
				table.clear();
				table.rows.add(tb_data);
				table.draw();
				$("#table_data_paginate .pagination").prepend("<div class='my-auto me-3'>Total Bobot: <span id='jumlah_bobot'>"+ msg.jumlah_bobot +"</span></div>");
			}
		})
		.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});;
	}
</script>

@endsection