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
	<div class="d-flex justify-content-between my-4">
		<h1>Hasil Diagnostics</h1>
		<button class="btn btn-primary btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#rumus_diagnosis">
			Kategori Diagnosis
		</button>
		<div class="modal fade" id="rumus_diagnosis" tabindex="-1" aria-hidden="true">
		  <div class="modal-dialog modal-md">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title me-3">Kategori Persentase<br/>Tingkat Pemahaman Mahasiswa</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <table class="table table-bordered mb-1">
		        	<tr>
		        		<th>Persentase</th>
		        		<th>Kategori</th>
		        	</tr>
		        	<tr>
		        		<td>0%-30%</td>
		        		<td>Kurang Dipahami</td>
		        	</tr>
		        	<tr>
		        		<td>&gt; 30%-60%</td>
		        		<td>Cukup Dipahami</td>
		        	</tr>
		        	<tr>
		        		<td>&gt; 60%-100%</td>
		        		<td>Mudah Dipahami</td>
		        	</tr>
		        </table>
		        <table class="table table-borderless mb-0">
		        	<tr>
		        		<td class="p-0">Referensi: </td>
		        		<td class="py-0 ps-1 pe-0 text-justify">
		        			<a href="http://ejournal.uin-suska.ac.id/index.php/JNSI/article/view/9911" target="_blank">Identifikasi Miskonsepsi dan Tingkat Pemahaman Mahasiswa Tadris Fisika pada Materi Listrik Dinamis Menggunakan 3-Tier Diagnostic Test (Hal. 131)</a>
		        		</td>
		        	</tr>
		        </table>
	        	
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
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
								<th>Rata-rata Kelas</th>
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
							<td>NPM/Nama Mahasiswa</td>
							<td>: 
								<select class="form-select form-select-sm w-auto d-inline" name="npm">
									<option selected disabled>-- Pilih Mahasiswa</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Rata-rata Nilai</td>
							<td id="td_rata2_permhs">: -</td>
						</tr>
						<tr class="d-none">
							<td>NPM</td>
							<td class="td_npm">: </td>
						</tr>
						<tr class="d-none">
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
								<th>Rata-rata Kelas</th>
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
							<div class="border-bottom border-gray mb-3"></div>
							<script type="text/javascript">
								var chart_data = { 
									SeluruhMateri: [], 
									SeluruhKelas: [], 
									SeluruhMahasiswa: [], 
									SeluruhSoal: []
								};
							</script>
							<table class="table table-bordered" id="tableSeluruhMateri">
								<thead>
									<tr>
										<th>No.</th>
										<th>Materi</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Rata-rata Seluruh Materi</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$i = 1; $rata_rata = $r = 0;
									foreach($seluruhMateri as $m){
										if($m->rata_rata != null){
											$rata_rata += $m->rata_rata;
											$r++;
										}
									}
									$rata_rata /= $r;
									$rata_rata = round($rata_rata, 2);
								?>
								@foreach($seluruhMateri as $m)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>{{ $m->judul_materi }}</td>
										<td align="center">
											@if($m->rata_rata != null)
												{{ round($m->rata_rata, 2) }}
											@else
												-
											@endif
										</td>
										<td>
											{{ $rata_rata }}
										</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhMateri.push({{ $m->rata_rata == null ? "0" : $m->rata_rata  }})
											</script>
										@if($m->rata_rata == null)
											-
										@elseif($m->rata_rata > $pemahaman[2])
											Mudah dipahami
										@elseif($m->rata_rata > $pemahaman[1])
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
							<canvas id="canvasSeluruhKelas" class="w-100"></canvas>
						</div>
						<div class="col-12 mb-3">
							<div class="border-bottom border-gray mb-3"></div>
							<table class="table table-bordered" id="tableSeluruhKelas">
								<thead>
									<tr> 
										<th>No.</th>
										<th>Kelas</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Rata-Rata Seluruh Kelas</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$i = 1; $rata_rata = $r = 0;
									foreach($seluruhKelas as $k){
										if($k->rata_rata != null){
											$rata_rata += $k->rata_rata;
											$r++;
										}
									}
									$rata_rata /= $r;
									$rata_rata = round($rata_rata, 2);
								?>
								@foreach($seluruhKelas as $k)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>{{ $k->kelas }}</td>
										<td align="center">
											@if($k->rata_rata != null)
												{{ round($k->rata_rata, 2) }}
											@else
												-
											@endif
										</td>
										<td>
											{{ $rata_rata }}
										</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhKelas.push({{ $k->rata_rata == null ? "0" : $k->rata_rata  }})
											</script>
										@if($k->rata_rata == null)
											-
										@elseif($k->rata_rata > $pemahaman[2])
											Mudah dipahami
										@elseif($k->rata_rata > $pemahaman[1])
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
						<div class="col-12">
							<div class="border-bottom border-gray mb-3"></div>
							<table class="table table-bordered" id="tableSeluruhMahasiswa">
								<thead>
									<tr> 
										<th>No.</th>
										<th>NPM</th>
										<th>Nama</th>
										<th>Kelas</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Rata-Rata Seluruh Mhs.</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody><?php $i = 1; ?>
								@foreach($seluruhMahasiswa as $sm)
									<tr>
										<td align="center">{{ $i++ }}.</td>
										<td>{{ $sm->npm }}</td>
										<td>{{ $sm->nama_mhs }}</td>
										<td>{{ $sm->kelas }}</td>
										<td align="center">
											@if($sm->rata_rata != null)
												{{ round($sm->rata_rata, 2) }}
											@else
												-
											@endif
										</td>
										<td>
											{{ $rata_rata }}
										</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhMahasiswa.push({{ $sm->rata_rata == null ? "0" : $sm->rata_rata  }})
											</script>
										@if($sm->rata_rata == null)
											-
										@elseif($sm->rata_rata > $pemahaman[2])
											Mudah dipahami
										@elseif($sm->rata_rata > $pemahaman[1])
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
							<div class="border-bottom border-gray mb-3"></div>
							<table class="table table-bordered" id="tableSeluruhSoal">
								<thead>
									<tr> 
										<th>No. Soal</th>
										<th>Materi</th>
										<th>Soal</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Rata-Rata Seluruh Soal</th>
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
										<td align="center">
											@if($s->rata_rata != null)
												{{ round($s->rata_rata, 2) }}
											@else
												-
											@endif
										</td>
										<td>
											{{ $rata_rata }}
										</td>
										<td>
											<script type="text/javascript">
												chart_data.SeluruhSoal.push({{ $s->rata_rata == null ? "0" : $s->rata_rata }})
											</script>
										@if($s->rata_rata == null)
											-
										@elseif($s->rata_rata > $pemahaman[2])
											Mudah dipahami
										@elseif($s->rata_rata > $pemahaman[1])
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
						<td class="py-1 text-start">Rata-Rata</td>
						<td class="py-1 text-start">--RATA_RATA--</td>
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
	var tableSeluruhKelas = $('#tableSeluruhKelas');
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
								if( v.nilai_akhir > {{ $pemahaman[2] }} )
									diagnosis = "Mudah Dipahami";
								else if(v.nilai_akhir > {{ $pemahaman[1] }})
									diagnosis = "Cukup Dipahami";
								else 
									diagnosis = "Kurang Dipahami";
								data_temp = [(i+1) + ".", v.npm, v.nama_mhs, v.nilai_akhir, rata_rata, diagnosis];
								tb.push(data_temp);
							});
							table_draw(tablePerMateri, tb);
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
						data_temp += '<option value="'+v.npm+'">'+v.npm+'/'+v.nama_mhs+'</option>';
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
			var data = $('#tabPerMahasiswa [name="npm"] option:selected').html().split('/');
			// $('#tabPerMahasiswa .td_npm').html(": " + data[0]);
			// $('#tabPerMahasiswa .td_namaMhs').html(": " + data[1]);
			$.ajax({
				url: "/api/diagnostics/permahasiswa/" + $('#tabPerMahasiswa [name="kelas"]').val() +"/"+ data[0],
				type: "GET",
				success: function(msg){
					if(msg == false) return;
					$.each(msg.materi, function(i, v){
						rata_rata += v.nilai_akhir;
					});
					rata_rata /= msg.materi.length;
					$.each(msg.materi, function(i, v){
						var rata_kelas = msg.rata_rata_kelas[i].rata_rata;
						var diagnosis;
						if( v.nilai_akhir > {{ $pemahaman[2] }} )
							diagnosis = "Mudah Dipahami";
						else if(v.nilai_akhir > {{ $pemahaman[1] }})
							diagnosis = "Cukup Dipahami";
						else 
							diagnosis = "Kurang Dipahami";
						data_temp = [v.pertemuan, v.judul_materi, v.nilai_akhir, msg.rata_rata_kelas[i].rata_rata, diagnosis];
						tb.push(data_temp);
					});
					$('#td_rata2_permhs').html(": " + rata_rata);
					table_draw(tablePerMahasiswa, tb);
				}
			})
			.fail(function(jqXHR, textStatus) {
			  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
			});
		});

		// Seluruh Materi --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		tableSeluruhMateri = tableSeluruhMateri.DataTable(dataTable_opt_temp);

		// Seluruh Kelas --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		tableSeluruhKelas = tableSeluruhKelas.DataTable(dataTable_opt_temp);

		// Seluruh Mahasiswa --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		tableSeluruhMahasiswa = tableSeluruhMahasiswa.DataTable(dataTable_opt_temp);

		// Seluruh Soal --------------------------------------------------------------
		var dataTable_opt_temp = dataTable_opt;
		tableSeluruhSoal = tableSeluruhSoal.DataTable(dataTable_opt_temp);

		function table_draw(table, data){
			table.clear();
		    table.rows.add(data);
		    table.draw();
		}

		// Action Chart
		const canvasSeluruhMateri = $('#canvasSeluruhMateri');
		const canvasSeluruhKelas = $('#canvasSeluruhKelas');
		const canvasSeluruhSoal = $('#canvasSeluruhSoal');
		createChart(canvasSeluruhMateri, [
        	@foreach($materi as $m)
        	'{{ $m->judul_materi }}',
        	@endforeach
        ], chart_data.SeluruhMateri);
		createChart(canvasSeluruhKelas, [
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
				        	mode: 'datasets'
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