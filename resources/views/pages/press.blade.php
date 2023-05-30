@extends('layouts.default')

@section('content')
	<section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
		<img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">

		<div class="page-banner-content">
			<h1><?= $title; ?></h1>
			<a class="btn btn-primary @if(Request::segment(2) == 'about') active @else @endif" href="/page/about"><?= lg("common.Team") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'partners') active @else @endif" href="/page/partners"><?= lg("common.Partners") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'press') active @else @endif" href="/page/press"><?= lg("common.Press") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'jobs') active @else @endif" href="/page/jobs"><?= lg("common.Jobs") ?></a>
		</div>
	</section><!-- /.page-banner -->

	<!-- section-action -->
	<section class="section-action section">
		<div class="container">
			<?= $content; ?>
		</div>
	</section><!-- / section-action -->
@stop
