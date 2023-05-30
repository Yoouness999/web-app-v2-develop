@extends('layouts.default')

@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 content-wrapper">

                @yield('subcontent')

            </div>
        </div>
    </div>
@stop
