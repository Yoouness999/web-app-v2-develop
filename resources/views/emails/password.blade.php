@extends('emails.layout')

@section('content')
    <p><?= lg("emails.Click here to reset your password") ?>:</p> <br>
    <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>
@stop
