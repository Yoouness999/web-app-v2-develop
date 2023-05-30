@extends('emails.layout')

@section('content')
    @if(isset($content))
        <?= $content ?>
    @endif
@stop