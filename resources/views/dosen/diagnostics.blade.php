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
<!-- ChartJS -->
<script src="/vendor/chartjs/dist/chart.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="my-4">Hasil Diagnostics</h1>
	<div class="card shadow">
		<div class="card-body">
			<!-- <h3>Diagnosis Per Materi</h3> -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link active" id="tabPerMateri-tab" data-bs-toggle="tab" data-bs-target="#tabPerMateri" type="button" role="tab" aria-controls="tabPerMateri" aria-selected="true">Diagnosis Per Materi</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabPerMahasiswa-tab" data-bs-toggle="tab" data-bs-target="#tabPerMahasiswa" type="button" role="tab" aria-controls="tabPerMahasiswa" aria-selected="false">Diagnosis Per Mahasiswa</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabSeluruhMateri-tab" data-bs-toggle="tab" data-bs-target="#tabSeluruhMateri" type="button" role="tab" aria-controls="tabSeluruhMateri" aria-selected="false">Diagnosis Seluruh Materi</button>
			  	</li>
			  	<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="tabSeluruhMahasiswa-tab" data-bs-toggle="tab" data-bs-target="#tabSeluruhMahasiswa" type="button" role="tab" aria-controls="tabSeluruhMahasiswa" aria-selected="false">Diagnosis Seluruh Mahasiswa</button>
			  	</li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  	<div class="tab-pane fade show active" id="tabPerMateri" role="tabpanel" aria-labelledby="tabPerMateri-tab">
			  		<table class="table table-borderless table-header w-auto">
						<tr>
							<td>Nama Dosen</td>
							<td>: </td>
						</tr>
						<tr>
							<td>Materi</td>
							<td>: </td>
						</tr>
						<tr>
							<td>Pertemuan</td>
							<td>: </td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>: </td>
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
			  	<div class="tab-pane fade" id="tabPerMahasiswa" role="tabpanel" aria-labelledby="tabPerMahasiswa-tab">
			  		<table class="table table-borderless table-header w-auto">
						<tr>
							<td>NPM</td>
							<td>: </td>
						</tr>
						<tr>
							<td>Nama Mahasiswa</td>
							<td>: </td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>: </td>
						</tr>
					</table>
						
					<table class="table table-bordered" id="tablePerMahasiswa">
						<thead>
							<tr>
								<th>No.</th>
								<th>NPM</th>
								<th>Nama</th>
								<th>Hasil Tes</th>
								<th>Hasil Diagnosis</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
			  	</div>
			  	<div class="tab-pane fade" id="tabSeluruhMateri" role="tabpanel" aria-labelledby="tabSeluruhMateri-tab">
					<div class="row">
						<div class="col-12 col-md-5">
							<canvas id="canvasSeluruhMateri" class="w-100 h-100"></canvas>
						</div>
						<div class="col-12 col-md-7">
							<table class="table table-bordered" id="tableSeluruhMateri">
								<thead>
									<tr>
										<th>No.</th>
										<th>Materi</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody>
								
								</tbody>
							</table>
						</div>
					</div>
			  	</div>
			  	<div class="tab-pane fade" id="tabSeluruhMahasiswa" role="tabpanel" aria-labelledby="tabSeluruhMahasiswa-tab">
					<div class="row">
						<div class="col-12 col-md-5">
							<canvas id="canvasSeluruhMahasiswa" class="w-100 h-100"></canvas>
						</div>
						<div class="col-12 col-md-7">
							<table class="table table-bordered" id="tableSeluruhMahasiswa">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kelas</th>
										<th>Rata-Rata Hasil Tes</th>
										<th>Hasil Diagnosis</th>
									</tr>
								</thead>
								<tbody>
								
								</tbody>
							</table>
						</div>
					</div>
			  	</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var tablePerMateri = $('#tablePerMateri');
	var tablePerMahasiswa = $('#tablePerMahasiswa');
	var tableSeluruhMateri = $('#tableSeluruhMateri');
	var tableSeluruhMahasiswa = $('#tableSeluruhMahasiswa');

	$(document).ready(function(){
		var dataTable_opt = {
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  }
		};

		table = tablePerMateri.DataTable(dataTable_opt);
		table = tablePerMahasiswa.DataTable(dataTable_opt);
		table = tableSeluruhMateri.DataTable(dataTable_opt);
		table = tableSeluruhMahasiswa.DataTable(dataTable_opt);


		const ctx = $('#canvasSeluruhMateri');
		const cty = $('#canvasSeluruhMahasiswa');
		const chartX = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		        datasets: [{
		            label: '# of Votes',
		            data: [12, 19, 3, 5, 2, 3],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            y: {
		                beginAtZero: true
		            }
		        }
		    }
		});
		const chartY = new Chart(cty, {
		    type: 'bar',
		    data: {
		        labels: ['Green', 'Purple', 'Red', 'Blue', 'Yellow', 'Orange'],
		        datasets: [{
		            label: '# of Votes',
		            data: [12, 19, 3, 5, 2, 3],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            y: {
		                beginAtZero: true
		            }
		        }
		    }
		});
	});
</script>

@endsection