@extends('layouts.default')

@section('body')
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-68547961-1', 'auto');
    ga('send', 'pageview');
</script>
@section('header')
    <div class="navbar navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo.png" alt="Boxify">
                </a>
            </div>
        </div>
    </div>
@show
<div class="page-landing">
    <div class="landing-holder">
        <h2>You box it. We store it.</h2>
        <h3>Coming soon, get notified when we launch</h3>

        <form action="/api/v1/beta-subscribe" data-ajax class="form">
            <div class="input-group">
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>" />
                <input class="form-control" type="email" name="email" required="required" placeholder="Leave your email...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" data-ajax-undefined>Send</button>
                    <button class="btn btn-default hide"  data-ajax-success  type="button" disabled="disabled"><i class="fa fa-check" aria-hidden="true"></i></button>
                    <button class="btn btn-default hide" data-ajax-progress  type="button"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i></button>
                    <button class="btn btn-error hide" data-ajax-error type="submit">Re-Send</button>
                </span>
            </div>
            <div class="alert hide" data-ajax-error>
                Your email is already registered.
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
    @parent
@stop
