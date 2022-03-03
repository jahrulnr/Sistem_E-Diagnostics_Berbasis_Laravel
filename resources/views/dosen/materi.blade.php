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
					<th>Judul Materi</th>
					<th>Soal</th>
					<th>Jawaban</th>
					<th>Aksi</th>
				</thead>
				<tbody>
				@foreach($data as $d)
					<tr>
						<td align="center">{{ $i++ }}.</td>
						<td>{{ $d->judul_materi }}</td>
						<td>{{ strlen($d->soal) > 30 ? substr($d->soal, 0, 30)."..." : $d->soal }}</td>
						<td>{{ strlen($d->jawaban_soal) > 10 ? substr($d->jawaban_soal, 0, 10)."..." : $d->jawaban_soal }}</td>
						<td align="center">
							<data id="data-{{ $d->id_soal }}" class="d-none">{{ json_encode($d) }}</data>
							<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="info('#data-{{ $d->id_soal}}')">
								<span class="fas fa-info px-1"></span>
							</button>
							<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="edit('#data-{{ $d->id_soal}}')">
								<span class="fas fa-pencil-alt"></span>
							</button>
							<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('{{ $d->id_soal}}')">
								<span class="fas fa-trash"></span>
							</button>
						</td>
					</tr>
      	@endforeach
				</tbody>
			</table>
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
        		<option disabled selected>-- Pilih Judul Materi</option>
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
	var $input = $('form').find('select, textarea');

	function info(id){
		edit(id);
		$('#tambah_header').html("Rincian Soal Materi");
		$.each($input, function(i, v){
			$(v).attr('disabled', 'disabled');
		});
		$('form button[type="submit"]').hide();
	}

	function tambah(){
		$('form').attr('action', '/dosen/materi/tambah');
		$('#tambah_header').html("Tambah Soal Materi");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('form button[type="submit"]').show();
	}

	function edit(id){
		var data = JSON.parse($(id).html());
		$('form').attr('action', '/dosen/materi/ubah');
		$('#tambah_header').html("Ubah Soal Materi");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('input[name="id_soal"]').val(data['id_soal']);
		$('select[name="id_materi"]').val(data['id_materi']);
		$('textarea[name="soal"]').val(data['soal']);
		$('textarea[name="jawaban_soal"]').val(data['jawaban_soal']);
		$('form button[type="submit"]').show();
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/dosen/materi/hapus/' + id);
	}

	$(document).ready(function(){
  	var hash = window.location.hash;
  	if(hash == '#berhasil_disimpan'){
  		toastr.success('Data berhasil disimpan');
  	}
  	else if(hash == '#gagal_disimpan'){
  		toastr.error('Data gagal disimpan');
  	}
  	else if(hash == '#berhasil_diubah'){
  		toastr.success('Data berhasil diubah');
  	}
  	else if(hash == '#gagal_diubah'){
  		toastr.error('Data gagal diubah');
  	}
  	else if(hash == '#berhasil_dihapus'){
  		toastr.success('Data berhasil dihapus');
  	}
  	else if(hash == '#gagal_dihapus'){
  		toastr.error('Data gagal dihapus');
  	}

		$('#table_data').DataTable({
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#btn_add').length < 1)
				$(this).append('<button class="btn btn-info btn-sm" id="btn_add" data-bs-toggle="modal" data-bs-target="#tambah" onclick="tambah()">Tambah Materi</button>');
			});
		  }
		});
	});
</script>

@endsection