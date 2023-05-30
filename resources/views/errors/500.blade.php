@extends('layouts.default')

@section('content')
<section class="page-banner" style="background-image: url(<?= asset('assets/img/bg-404.jpg') ?>); height: 647px;">
	<img class="sr-only" src="<?= asset('assets/img/bg-404.jpg') ?>" alt="Banner">
	<div class="page-banner-content">
		<br><br><br><br><br><br><br><br><br>
		<h1>Oops, an error occured in our platform. Our team are working on it.</h1><br><br>
		<a href="/" class="btn btn-primary">Go to the homepage</a>
	</div>
</section><!-- / page-banner -->
@stop