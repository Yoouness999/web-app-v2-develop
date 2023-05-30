@extends('layouts.arx_starter')

@section('css')
<?php
# Example of using CSS Loader
echo \Arx\classes\Load::css([
    url('assets/css/main.css'),
]);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
@stop

@section('head')
<meta name="DC.title" lang="en" content="Boxify - You Box it. We store it." />
@parent
<script>
    window.__app = <?php echo json_encode(javascript()->get('__app', [])); ?>;
</script>
<!--[if lt IE 8]>
<script src="<?php echo url('assets/js/plugins/modernizr/modernizr.js'); ?>"></script>
<![endif]-->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="<?= Request::isSecure() ? 'https://ws.sharethis.com/button/buttons.js' : 'http://w.sharethis.com/button/buttons.js'; ?>"></script>
<script type="text/javascript">stLight.options({publisher: "c1744979-60e9-4c8b-bf7a-55b1a3fd551f", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
@stop

@section('js')
<?php
# Example of using JS Loader
echo \Arx\classes\Load::js([
    'assets/js/plugins.js',
    'assets/js/main.js'
]);
?>
@stop

@section('body')
@if(env('APP_ENV') == 'production')
	<script>
	    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	    ga('create', 'UA-68547961-1', 'auto');
	    ga('send', 'pageview');

	</script>
@endif
<div class="container page-wrapper">
    @section('content')
    <?php
    if (isset($content)):
        echo $content;
    else:
        ?>
        <div class="starter-template">
            <h1>Bootstrap starter template</h1>

            <p class="lead">Define a $content var to change this content or override the content section.</p>
        </div>
    <?php
    endif;
    ?>
    @show
</div> <!-- /container -->
    @include('parts.intercom')
@stop
