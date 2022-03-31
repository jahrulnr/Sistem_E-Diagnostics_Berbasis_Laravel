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
	<h1 class="my-4">Hasil Diagnostics</h1>
	<div class="card shadow">
		<div class="card-body">
			<!-- <h3>Diagnosis Per Materi</h3> -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link active" id="tabPerMateri-tab" data-bs-toggle="tab" data-bs-target="#tabPerMateri" type="button" role="tab" aria-controls="tabPerMateri" aria-selected="true">Diagnosis per Materi</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabPerMahasiswa-tab" data-bs-toggle="tab" data-bs-target="#tabPerMahasiswa" type="button" role="tab" aria-controls="tabPerMahasiswa" aria-selected="false">Diagnosis per Mahasiswa</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabSeluruhMateri-tab" data-bs-toggle="tab" data-bs-target="#tabSeluruhMateri" type="button" role="tab" aria-controls="tabSeluruhMateri" aria-selected="false">Diagnosis Seluruh Materi</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabSeluruhMahasiswa-tab" data-bs-toggle="tab" data-bs-target="#tabSeluruhMahasiswa" type="button" role="tab" aria-controls="tabSeluruhMahasiswa" aria-selected="false">Diagnosis Seluruh Mahasiswa</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabSeluruhSoal-tab" data-bs-toggle="tab" data-bs-target="#tabSeluruhSoal" type="button" role="tab" aria-controls="tabSeluruhSoal" aria-selected="false">Diagnosis Seluruh Soal</button>
			  	</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<!-- tabPerMateri ------------------------------------------------------>
			  	<div class="tab-pane fade show active" id="tabPerMateri" role="tabpanel" aria-labelledby="tabPerMateri-tab">
			  		<table class="table table-borderless table-header w-auto">
						<tr>
							<td>Nama Dosen</td>
							<td>: {{ session('nama') }}</td>
						</tr>
						<tr>
							<td>Materi</td>
							<td>: 
								<select class="form-select form-select-sm w-auto d-inline" name="materi"placeholder="-- Pilih Materi">
									<option pertemuan="-" disabled selected>-- Pilih Materi</option>
									@foreach($materi as $m)
									<option value="{{ $m->id_materi }}" pertemuan="{{ $m->pertemuan }}">{{ $m->judul_materi }}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>Pertemuan</td>
							<td class="pertemuan">: -</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>: 
								<select class="form-select form-select-sm w-auto d-inline" name="kelas"placeholder="-- Pilih Kelas">
									<option disabled selected>-- Pilih Kelas</option>
									@foreach($kelas as $k)
									<option value="{{ $k->kelas }}">{{ $k->kelas }}</option>
									@endforeach
								</select>
							</td>
						</tr>
					</table>
						
					<table class="table table-bordered" id="tablePerMateri">
						<thead>
							<tr>
								<th>No.</th>
								<th>NPM</th>
								<th>Nama Mahasiswa</th>
								<th>Hasil Tes</th>
								<th>Hasil Diagnosis</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
			  	</div>

				<!-- tabPerMahasiswa ------------------------------------------------------>
			  	<div class="tab-pane fade" id="tabPerMahasiswa" role="tabpanel" aria-labelledby="tabPerMahasiswa-tab">
			  		<table class="table table-borderless table-header w-auto">
						<tr>
							<td>Kelas</td>
							<td>: 
								<select class="form-select form-select-sm w-auto d-inline" name="kelas" placeholder="-- Pilih Kelas">
									<option disabled selected>-- Pilih Kelas</option>
									@foreach($kelas as $k)
									<option value="{{ $k->kelas }}">{{ $k->kelas }}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>Mahasiswa</td>
							<td>: 
								<select class="form-select form-select-sm w-auto d-inline" name="npm">
									<option selected disabled>-- Pilih Mahasiswa</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>NPM</td>
							<td class="td_npm">: </td>
						</tr>
						<tr>
							<td>Nama Mahasiswa</td>
							<td class="td_namaMhs">: </td>
						</tr>
					</table>
						
					<table class="table table-bordered" id="tablePerMahasiswa">
						<thead>
							<tr>
								<th>Pertemuan</th>
								<th>Materi</th>
								<th>Hasil Tes</th>
								<th>Hasil Diagnosis</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
			  	</div>

				<!-- tabSeluruhMateri ------------------------------------------------------>
			  	<div class="tab-pane fade" id="tabSeluruhMateri" role="tabpanel" aria-labelledby="tabSeluruhMateri-tab">
					<div class="row">
						<div class="col-12 mb-3" style="height: 300px;">
							<canvas id="canvasSeluruhMateri" class="w-100"></canvas>
						</div>
						<div class="col-12">
							<script type="text/javascript">
								var chart_data = { 
									SeluruhMateri: [], 
									SeluruhKelas: [], 
									SeluruhSoal: []
								};
							</script>
							<table class="table table-bordered" id="tableSeluruhMateri">
								<thead>
									<tr>
										<th>No.</th>
										<th>Materi</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody><?php $i = 1; ?>
								@foreach($seluruhMateri as $m)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>{{ $m->judul_materi }}</td>
										<td align="center">{{ $m->rata_rata }}</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhMateri.push({{ $m->rata_rata == null ? "0" : $m->rata_rata  }})
											</script>
										@if($m->rata_rata > $rata2_semua_materi)
											Mudah dipahami
										@elseif($m->rata_rata == $rata2_semua_materi)
											Cukup dipahami
										@else
											Kurang dipahami
										@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
			  	</div>

				<!-- tabSeluruhMahasiswa ------------------------------------------------------>
			  	<div class="tab-pane fade" id="tabSeluruhMahasiswa" role="tabpanel" aria-labelledby="tabSeluruhMahasiswa-tab">
					<div class="row">
						<div class="col-12 mb-3" style="height: 200px;">
							<canvas id="canvasSeluruhMahasiswa" class="w-100"></canvas>
						</div>
						<div class="col-12">
							<table class="table table-bordered" id="tableSeluruhMahasiswa">
								<thead>
									<tr> 
										<th>No.</th>
										<th>Kelas</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody><?php $i = 1; ?>
								@foreach($seluruhKelas as $k)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>{{ $k->kelas }}</td>
										<td align="center">{{ $k->rata_rata }}</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhKelas.push({{ $k->rata_rata == null ? "0" : $k->rata_rata  }})
											</script>
										@if($k->rata_rata > $rata2_semua_materi)
											Mudah dipahami
										@elseif($k->rata_rata == $rata2_semua_materi)
											Cukup dipahami
										@else
											Kurang dipahami
										@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
			  	</div>

				<!-- tabSeluruhSoal ------------------------------------------------------>
			  	<div class="tab-pane fade" id="tabSeluruhSoal" role="tabpanel" aria-labelledby="tabSeluruhSoal-tab">
					<div class="row">
						<div class="col-12 mb-3" style="height: 200px;">
							<canvas id="canvasSeluruhSoal" class="w-100"></canvas>
						</div>
						<div class="col-12">
							<table class="table table-bordered" id="tableSeluruhSoal">
								<thead>
									<tr> 
										<th>No. Soal</th>
										<th>Materi</th>
										<th>Soal</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody><?php $i = 1; ?>
								@foreach($seluruhSoal as $s)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>
											<a href="/dosen/materi#materi={{ $s->id_materi }}">
												{{ $s->judul_materi }}
											</a>
										</td>
										<td>{{ strlen($s->soal) > 60 ? substr($s->soal, 0, 60)."..." : $s->soal }}</td>
										<td align="center">{{ round($s->rata_rata, 2) }}</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhSoal.push({{ $s->rata_rata == null ? "0" : $s->rata_rata }})
											</script>
										@if($s->rata_rata == null)
											-
										@elseif($s->rata_rata > $rata2_semua_materi)
											Mudah dipahami
										@elseif($s->rata_rata == $rata2_semua_materi)
											Cukup dipahami
										@else
											Kurang dipahami
										@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
			  	</div>
			</div>
		</div>
	</div>

	<div class="d-none template">
		<div class="rata-rata">
			<li class="paginate_button page-item me-3 my-auto">
				<table class="table table-bordered m-0">
					<tr>
						<td class="py-1">Rata-Rata Nilai</td>
						<td class="py-1">--RATA_RATA--</td>
					</tr>
				</table>
			</li>
		</div>
	</div>
</div>

<!-- ChartJS -->
<script src="/vendor/chartjs/dist/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-autocolors"></script>
<script type="text/javascript">
	var tablePerMateri = $('#tablePerMateri');
	var tablePerMahasiswa = $('#tablePerMahasiswa');
	var tableSeluruhMateri = $('#tableSeluruhMateri');
	var tableSeluruhMahasiswa = $('#tableSeluruhMahasiswa');
	var tableSeluruhSoal = $('#tableSeluruhSoal');

	$(document).ready(function(){
		$.each($('body').find('select, input'), function(i, v){
			$(this).val("");
		});
		var dataTable_opt = {
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "bDestroy": true
		};

		// Action tab
		// Per Materi ---------------------------------------------------------
		tablePerMateri = tablePerMateri.DataTable(dataTable_opt);
		$('#tabPerMateri [name="materi"]').change(function(){
			if($(this).val() == null) return;
			$('#tabPerMateri td.pertemuan').html(": " + $('#tabPerMateri [name="materi"] option:selected').attr('pertemuan'));
			update_tabPerMateri();
		});
		$('#tabPerMateri [name="kelas"]').change(function(){
			if($(this).val() == null) return;
			update_tabPerMateri();
		});
		function update_tabPerMateri(){
			var materi = $('#tabPerMateri [name="materi"]').val();
			var kelas = $('#tabPerMateri [name="kelas"]').val();
			var tb = [];
			var rata_rata = 0.0;
			var data_temp;

			if(materi == null || kelas == null)
				return;
			else
				$.ajax({
					url: "/api/diagnostics/permateri/" + materi +"/"+ kelas,
					type: "GET",
					success: function(msg){
						if(msg == false){
							table_draw(tablePerMateri, []);
						}
						else{
							$.each(msg, function(i, v){
								rata_rata += v.nilai_akhir;
							});
							rata_rata /= msg.length;
							$.each(msg, function(i, v){
								var diagnosis;
								if( v.nilai_akhir < rata_rata )
									diagnosis = "Mudah Dipahami";
								else if(v.nilai_akhir == rata_rata)
									diagnosis = "Cukup Dipahami";
								else 
									diagnosis = "Kurang Dipahami";
								data_temp = [(i+1) + ".", v.npm, v.nama_mhs, v.nilai_akhir, diagnosis];
								tb.push(data_temp);
							});
							table_draw(tablePerMateri, tb);
							
							// renew table
							tablePerMateri.destroy();
							var dataTable_opt_temp = dataTable_opt;
							dataTable_opt_temp.initComplete = function(){
								if($('#tablePerMateri_paginate .pagination .table').length < 1){
									rata_rata = $('.template .rata-rata').html().replace('--RATA_RATA--', rata_rata);
									$('#tablePerMateri_paginate .pagination').prepend(rata_rata);
								}
							}
							tablePerMateri = $('#tablePerMateri').DataTable(dataTable_opt_temp);
						}
					}
				})
				.fail(function(jqXHR, textStatus) {
				  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
				});
		}

		// Per Mahasiswa --------------------------------------------------------------
		tablePerMahasiswa = tablePerMahasiswa.DataTable(dataTable_opt);
		$('#tabPerMahasiswa [name="kelas"]').change(function(){
			if($(this).val() == null) return;
			var mhs = $('#tabPerMahasiswa [name="npm"]');
			var data_temp = "<option selected disabled>-- Pilih Mahasiswa</option>";
			$.ajax({
				url: "/api/diagnostics/kelas/"+ $(this).val(),
				type: "GET",
				success: function(msg){
					if(msg == false) return;
					$.each(msg, function(i, v){
						data_temp += '<option value="'+v.npm+'">'+v.npm+' - '+v.nama_mhs+'</option>';
					});
					mhs.html(data_temp);
				}
			})
			.fail(function(jqXHR, textStatus) {
			  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
			});
		});
		$('#tabPerMahasiswa [name="npm"]').change(function(){
			if($(this).val() == null) return;
			var tb = [];
			var rata_rata = 0.0;
			var data_temp;
			var data = $('#tabPerMahasiswa [name="npm"] option:selected').html().split(' - ');
			$('#tabPerMahasiswa .td_npm').html(": " + data[0]);
			$('#tabPerMahasiswa .td_namaMhs').html(": " + data[1]);
			$.ajax({
				url: "/api/diagnostics/permahasiswa/" + data[0],
				type: "GET",
				success: function(msg){
					if(msg == false) return;
					$.each(msg, function(i, v){
						rata_rata += v.nilai_akhir;
					});
					rata_rata /= msg.length;
					$.each(msg, function(i, v){
						var diagnosis;
						if( v.nilai_akhir < rata_rata )
							diagnosis = "Mudah Dipahami";
						else if(v.nilai_akhir == rata_rata)
							diagnosis = "Cukup Dipahami";
						else 
							diagnosis = "Kurang Dipahami";
						data_temp = [v.pertemuan, v.judul_materi, v.nilai_akhir, diagnosis];
						tb.push(data_temp);
					});
					table_draw(tablePerMahasiswa, tb);

					// renew table
					tablePerMateri.destroy();
					var dataTable_opt_temp = dataTable_opt;
					dataTable_opt_temp.initComplete = function(){
						if($('#tablePerMahasiswa_paginate .pagination table').length < 1){
							rata_rata = $('.template .rata-rata').html().replace('--RATA_RATA--', rata_rata);
							$('#tablePerMahasiswa_paginate .pagination').prepend(rata_rata);
						}
					}
					tablePerMahasiswa = $('#tablePerMahasiswa').DataTable(dataTable_opt_temp);
				}
			})
			.fail(function(jqXHR, textStatus) {
			  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
			});
		});

		// Seluruh Materi --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		dataTable_opt_temp.fnDrawCallback = function(){
			if($('#tableSeluruhMateri_paginate .pagination table').length < 1){
				rata_rata = $('.template .rata-rata').html().replace('--RATA_RATA--', {{ $rata2_semua_materi }});
				$('#tableSeluruhMateri_paginate .pagination').prepend(rata_rata);
			}
		}
		tableSeluruhMateri = tableSeluruhMateri.DataTable(dataTable_opt_temp);

		// Seluruh Mahasiswa --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		dataTable_opt_temp.fnDrawCallback = function(){
			if($('#tableSeluruhMahasiswa_paginate .pagination table').length < 1){
				rata_rata = $('.template .rata-rata').html().replace('--RATA_RATA--', {{ $rata2_semua_materi }});
				$('#tableSeluruhMahasiswa_paginate .pagination').prepend(rata_rata);
			}
		}
		tableSeluruhMahasiswa = tableSeluruhMahasiswa.DataTable(dataTable_opt_temp);

		// Seluruh Soal --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		dataTable_opt_temp.fnDrawCallback = function(){
			if($('#tableSeluruhSoal_paginate .pagination table').length < 1){
				rata_rata = $('.template .rata-rata').html().replace('--RATA_RATA--', {{ $rata2_semua_materi }});
				$('#tableSeluruhSoal_paginate .pagination').prepend(rata_rata);
			}
		}
		tableSeluruhSoal = tableSeluruhSoal.DataTable(dataTable_opt_temp);

		function table_draw(table, data){
			table.clear();
		    table.rows.add(data);
		    table.draw();
		}

		// Action Chart
		const canvasSeluruhMateri = $('#canvasSeluruhMateri');
		const canvasSeluruhMahasiswa = $('#canvasSeluruhMahasiswa');
		const canvasSeluruhSoal = $('#canvasSeluruhSoal');
		createChart(canvasSeluruhMateri, [
        	@foreach($materi as $m)
        	'{{ $m->judul_materi }}',
        	@endforeach
        ], chart_data.SeluruhMateri);
		createChart(canvasSeluruhMahasiswa, [
        	@foreach($kelas as $k)
        	'Kelas {{ $k->kelas }}',
        	@endforeach
        ], chart_data.SeluruhKelas);
		createChart(canvasSeluruhSoal, [<?php $i=1;?>
        	@foreach($seluruhSoal as $s)
        	'Soal {{ $i++ }}',
        	@endforeach
        ], chart_data.SeluruhSoal);

		function createChart(id, label_data, data){
			var data_temp = data.length;

			new Chart(id, {
			    type: 'bar',
			    data: {
			        labels: label_data,
			        datasets: [{
			            label: 'Nilai Rata-Rata',
			            data: data,
			      //       backgroundColor: palette('tol', data.length).map(function(hex) {
					    //     return '#' + hex;
					    // }),
			            borderWidth: 1
			        }]
			    },
			    options: {
			    	responsive: true,
				    maintainAspectRatio: false,
			        scales: {
				        y: {
				            beginAtZero: true,
			                max: 100,
			                min: 0
				        }
			        },
			        plugins: {
					    legend: {
					        display: false
					    },
				        autocolors: {
				        	mode: 'data'
				        }
					}
			    },
			    plugins: [
			    	window['chartjs-plugin-autocolors']
			    ]
			});
		}
	});
</script>

@endsection