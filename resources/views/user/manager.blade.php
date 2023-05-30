@extends('layouts.default')

@section('content')

	{{--@include('parts/invite-friend-bar')--}}

	<div class="app-container" ui-view></div>
@stop

@section('head')
	@parent
	<?php
	if (App::getLocale() == 'fr') {
		$lang = 'fr';
	} else {
		$lang = 'en-US';
	}
	?>
	<script type="text/javascript"
			src="//maps.google.com/maps/api/js?sensor=false&libraries=places&language=<?= $lang; ?>"></script>
@stop


