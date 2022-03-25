@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<div class="container-fluid px-4">
	<h1 class="my-4">Materi</h1>
	<div class="row">
		@foreach($data as $materi)
		<a href="/mahasiswa/materi/{{ $materi->id_materi }}" class="col-12 col-md-4 mb-3">
			<div class="card card-body menu-materi">
				<div class="row">
					<div class="col-4 text-end">
						<span style="font-size: 4rem;font-weight: bolder;">{{ $materi->pertemuan }}</span>
					</div>
					<div class="col-8 my-auto">
						Materi
						@if($materi->id_jawaban != null)
						<span class="fas fa-check text-success"></span>
						@endif
						<hr class="m-0" />
						{{ $materi->judul_materi }}
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>

@endsection