@extends('layouts.default')

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
            src="//maps.google.com/maps/api/js?libraries=places&language=<?= $lang; ?>&key=AIzaSyCIjc3NxG65UPljS1GZXAl83XyZWf1HGKg"></script>
@stop

@section('content')
    @include('parts.coupon-applied-bar')
    <div class="app-container" ui-view></div>
@stop