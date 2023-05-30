@extends('layouts.profile')

@section('subcontent')

<h2 class="h4">Information</h2>
<hr>

<form action="#" class="form-horizontal" method="post">

	<div class="form-group">
		<label for="first_name" class="col-sm-4"><?= ucfirst(lg("common.first_name")) ?></label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}">
		</div>
	</div>

	<div class="form-group">
		<label for="last_name" class="col-sm-4"><?= ucfirst(lg("common.last_name")) ?></label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}">
		</div>
	</div>

	<div class="form-group">
		<label for="phone" class="col-sm-4"><?= ucfirst(lg("common.phone")) ?></label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
		</div>
	</div>

	<div class="form-group">
		<label for="email" class="col-sm-4"><?= ucfirst(lg("common.email")) ?></label>
		<div class="col-sm-8">
			<input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">
		</div>
	</div>

	<hr>

	<button class="btn btn-primary" name="submit" type="submit"><?= lg("common.Submit") ?></button>

</form>

@include('parts.errors')

@stop
