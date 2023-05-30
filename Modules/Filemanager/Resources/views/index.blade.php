@extends('arxmin::layouts.admin')

@section('css')
@parent
		<!-- jQuery and jQuery UI (REQUIRED) -->
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<!-- elFinder CSS (REQUIRED) -->
<link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/elfinder.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/theme.css') ?>">
@stop

@section('js')
@parent
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>
<?php if($locale){ ?>
		<!-- elFinder translation (OPTIONAL) -->
<script src="<?= asset($dir."/js/i18n/elfinder.$locale.js") ?>"></script>
<?php } ?>
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$('#elfinder').elfinder({
			<?php if($locale){ ?>
                lang: '<?= $locale ?>', // locale
			<?php } ?>
            customData: {
				_token: '<?= csrf_token() ?>'
			},
			url : '<?= action('\Barryvdh\Elfinder\ElfinderController@showConnector') ?>'  // connector URL
		});
	});
</script>
@stop

@section('content')
<div class="container-fluid" style="height: 100vh">
	<div id="elfinder"></div>
</div>
@stop