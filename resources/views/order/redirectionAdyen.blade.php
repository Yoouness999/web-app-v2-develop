<script type="text/javascript">
	window.onload=function(){
		document.getElementById("valButton").click();
	}
</script>
<style>
	.padd{
		padding-top: 100px;
	}
</style>

@extends('layouts.default')
@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
	<form method="POST" action="{{$redirectTo}}" id="3dschallenge" target="{{$target}}">
		<div class="padd">
			<input type="hidden" name="creq" value={{$encodedcReq}} />
			<input type="hidden" name="PaReq" value="{{$PaReq}}" />
			<input type="hidden" name="MD" value="{{$MD}}" />
			<input type="hidden" name="TermUrl" value="{{$TermUrl}}" />
			<input type="hidden" name="threeDSMethodData" value="{{$encodedJSON}}" />


	  		<p class="p-lg"><?=lg("common.redirection")?> <button class="btn btn-primary" id="valButton">cliquez ici</button></p>
		</div>
	</form>

	<iframe style="visibility: hidden" name="iframename" id="iframename"></iframe>
@stop
