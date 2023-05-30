@extends('layouts.default')

@section('content')
    <section class="page-banner" style="background-image: url(<?= asset('assets/img/bg-404.jpg') ?>); height: 647px;">
        <img class="sr-only" src="{{ asset('assets/img/bg-404.jpg') }}" alt="Banner">
        <div class="page-banner-content">
            <br><br><br><br><br><br><br><br><br>
            <h1>We will be right back soon !</h1><br><br>
        </div>
    </section><!-- / page-banner -->
@stop