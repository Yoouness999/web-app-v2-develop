@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
	@include('order.breadcrumb', ['step' => 1])
	@include('order.storage-content', ['categories' => $categories, 'assets' => $assets, 'from' => 'storage', 'categoryBySlide' => 1])
@stop