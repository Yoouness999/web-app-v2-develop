@extends('layouts.profile')
<?php
$lang = Lang::getLocale() ?: 'en';
?>
@section('head')
    @parent

    <?php /* Required by angular-ui-router for HTML5Mode */ ?>
    <base href="/profile/manage/">

    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&libraries=places&language=<?= $lang ?>&key=AIzaSyCIjc3NxG65UPljS1GZXAl83XyZWf1HGKg"></script>
@stop

@section('subcontent')
    <div class="app-container" ui-view></div>
@stop