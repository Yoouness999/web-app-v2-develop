@extends('layouts.profile')

@section('subcontent')

<h2 class="h4"><?= lg("common.Password") ?></h2>
<hr>

@if(isset($notification))
	<div class="alert alert-<?= $notification['type']; ?>">
		<?= $notification['msg']; ?>
	</div>
@endif

<form action="#" class="form-horizontal" method="post">

	<div class="form-group">
		<label for="password_current" class="col-sm-4"><?= lg("Current password") ?></label>
		<div class="col-sm-8">
			<input type="password" class="form-control" name="password_current" id="password_current" value="">
		</div>
	</div>

	<div class="form-group">
		<label for="password" class="col-sm-4"><?= lg("common.New password") ?></label>
		<div class="col-sm-8">
			<input type="password" class="form-control" name="password" id="password" value="">
		</div>
	</div>

	<div class="form-group">
		<label for="password_confirm" class="col-sm-4"><?= lg("common.Confirm password") ?></label>
		<div class="col-sm-8">
			<input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
		</div>
	</div>

	<hr>

	<button class="btn btn-primary" type="submit"><?= lg("common.Save new password") ?></button>

</form>


@stop
