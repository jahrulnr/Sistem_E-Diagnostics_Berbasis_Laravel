@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* DataTables */
	@import url('/vendor/datatables/css/dataTables.bootstrap5.min.css');
	@import url('/vendor/datatables/css/responsive.bootstrap5.min.css');

	/* Custom style */
	#tab-soal {
		flex-wrap: nowrap;
		overflow-x: auto;
		overflow-y: clip;
		scrollbar-width: thin;

		/* Fix border */
		border-bottom: none;
  	border-top: 1px solid #dee2e6 !important;
	}

	.dark-bg #tab-soal {
		border-bottom: none;
  	border-top: 1px solid var(--bs-gray-600) !important;
	}

	#tab-soal .nav-item {
		white-space: nowrap;
	}

	#tab-soal, #tab-soal .nav-item {
    transform:rotateX(180deg);
    -ms-transform:rotateX(180deg); /* IE 9 */
    -webkit-transform:rotateX(180deg); /* Safari and Chrome */
	}
</style>
<!-- DataTables -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/js/responsive.bootstrap5.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="mt-4 mb-0">Materi {{ $materi->judul_materi }}</h1>
	<h3>Pertemuan {{ $materi->pertemuan }}</h3>
	<div class="d-flex justify-content-center">
		<div class="col-12 col-md-6 col-lg-4" id="card-col">
			<div class="card shadow">

			@if( $data_exists > 0 )
				<div class="card-body" id="form_dosen">
					<div class="form-input mb-3">
						<label>
							Dosen Pengampu 
							<a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#info_select_dosen">
								<span class="fas fa-sm fa-info-circle"></span>
							</a>
						</label>
						<select id="id_dosen" class="form-select">
							<option selected disabled>-- Pilih Dosen Pengampu</option>
							@foreach($dosen as $data)
							<option value="{{ $data->id_admin }}">{{ $data->nama_dsn }}</option>
							@endforeach
						</select>
					</div>
					<div class="d-flex justify-content-end">
						<button class="btn btn-primary" id="btn_dsn_chs">Mulai</button>
					</div>
				</div>

				<div class="card-body fade d-none" id="form_soal">
					<ul class="nav nav-tabs overflow-x-auto" id="tab-soal" role="tablist">
				  	<li class="nav-item" role="presentation">
				    	<button class="nav-link" id="dataSoal---id---tab" data-bs-toggle="tab" data-bs-target="#dataSoal---id--" type="button" role="tab" aria-controls="dataSoal---id--" aria-selected="true">
				    		<span>Soal</span> --id--
				    	</button>
				  	</li>
					</ul>

					<form class="tab-content" id="tab-soal-content" method="POST">
				  	<div class="tab-pane fade" id="dataSoal---id--" role="tabpanel" aria-labelledby="dataSoal---id---tab">
				  		<div class="form-input">
				  			<label>--soal--<hr class="mt-0 mb-3">Jawab</label>
				  			<textarea class="form-control" rows="5" name="jawaban[--uid--]" placeholder="Jawab ..."></textarea>
				  		</div>
				  	</div>
				  </form>

				  <div class="d-none" id="last-tab">
		  			<li class="nav-item" role="presentation">
				    	<button class="nav-link" id="last-tab-li" data-bs-toggle="tab" data-bs-target="#last-tab-div" type="button" role="tab" aria-controls="last-tab-div" aria-selected="true">
				    		Selesai
				    	</button>
				  	</li>
			  		<div class="tab-pane fade" id="last-tab-div" role="tabpanel" aria-labelledby="last-tab-li">
				  		<div class="form-input">
				  			@csrf
				  			<u class="h5">Konfirmasi</u>
				  			<div class="mt-1">
				  				&nbsp;&nbsp;Mohon cek kembali form yang telah dijawab sebelum menyelesaikan tes.
					  			<div class="mt-3 w-100 text-center">
						  			<button type="submit" class="btn btn-primary">Kirim Jawaban</button>
					  			</div>
				  			</div>
				  		</div>
				  	</div>
			  	</div>
				</div>

			@elseif( $data_exists !== null )
			
				<div class="card-body">
					<div class="form-input mb-3 text-center">
						<label class="mb-3">
							Kamu sudah menjawab materi ini
						</label><br/>
						<a class="btn btn-primary" href="/mahasiswa/materi">
							Kembali
						</a>
					</div>
				</div>

			@else

				<div class="card-body">
					<div class="form-input mb-3 text-center">
						<label class="mb-3">
							Soal belum tersedia
						</label><br/>
						<a class="btn btn-primary" href="/mahasiswa/materi">
							Kembali
						</a>
					</div>
				</div>

			@endif

			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="info_select_dosen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="fas fa-info-circle"></span> Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <ul class="modal-body ms-2">
        <li>Jangan memulai tes sebelum diizinkan oleh dosen pengampu.</li>
        <li>Dosen pengampu yang telah dipilih tidak dapat diganti.</li>
        <li>Dosen pengampu dipilih manual disetiap materi.</li>
      </ul>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="loading" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	Mengambil data ...
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
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

	  	$('#btn_dsn_chs').click(function(){
	  		var id = $('#id_dosen').val();
	  		if(id){
		  		getSoal(id);
		  	}
	  	});
	});

	function getSoal(dosen){
		var s = true;
		var request = $.ajax({
			type: "POST",
			data: { _token: "{{ csrf_token() }}" },
		  url: "/mahasiswa/materi/{{ $materi->id_materi }}/" + dosen,
		  beforeSend: function(){
		  	$('#loading').modal('show');
		  },
		  success: function(msg){
		  	var $h = $('#tab-soal');
				var $b = $('#tab-soal-content');
				var $lc = $('#last-tab > li');
				var $lt = $('#last-tab > div');
				var temph = '';
				var tempb = '';
				if(msg.length > 0){
					$.each(msg, function(i, v){
	     			temph += $h.html().replaceAll('--id--', i+1);
	     			tempb += $b.html().replaceAll('--id--', i+1)
	     				.replace('--uid--', v.id_soal).replace('--soal--', v.soal);
	     		});
				}
     		$h.html('');
     		$b.html('');
     		$h.html(temph + $lc.prop("outerHTML"));
     		$b.html(tempb + $lt.prop("outerHTML"));
		  },
		  complete: function(){
		  	if( s ){
			  	$('#card-col').removeClass('col-md-6 col-lg-4');
			  	$('#loading').modal('hide');
			  	$('#form_dosen').hide();
			  	$('#form_soal').removeClass('d-none').addClass('show');
					$($('[role="presentation"] .nav-link')[0]).addClass('active');
					$($('[role="tabpanel"]')[0]).addClass('show active');
				}
		  },
		  error: function(xhr){
		  	$('#loading').modal('hide');
		  	s = false;
		  	alert('Gagal mengambil data, coba lagi.');
		  }
		});
	}
</script>

@endsection