@extends('layouts.default')

@section('content')
	<!-- page-banner -->
	<section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
	   	<img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">
	   	<div class="page-banner-content">
			<div class="page-banner-content">
				<h1><?= $title; ?></h1>
				<?= $subtitle; ?>
				@include('parts.btn-get-started')
			</div>
	   	</div>
	</section><!-- / page-banner -->

	<!-- section-action -->
	<section class="section-action section">
		<div class="container">
			<?= $content; ?>
		</div>
	</section><!-- / section-action -->
@stop











