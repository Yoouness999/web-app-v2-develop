@extends('layouts.default')

@section('content')

	<!-- section-signup -->
	<section class="section-signup" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

					<div class="panel panel-default">

						<div class="panel-heading"><?= lg("auth.Create an account") ?></div>

						<div class="panel-body">
							@if($errors->any())
								<div class="form-error">
									<p>
										<strong><?= lg("auth.These fields are mandatory") ?></strong><br><br>
									</p>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form role="form" method="POST" action="/auth/register">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								@if(request()->get('error') !== 'oauth_email_missing')
								<div class="form-group">
									<a href="/oauth/connect/facebook" class="btn btn-facebook btn-outline-inverse btn-block">
										<i class="fa fa-facebook" aria-hidden="true"></i> <?= lg("auth.Signup with Facebook") ?>
									</a>
								</div>
								<div class="divider divider--horizontal"><?= lg("common.or") ?></div>
								@else
									<div class="alert alert-warning"><?= lg("auth.We cannot find your email address from your Facebook Account, please signup here.") ?></div>
								@endif


								<div class="form-group row">
									<div class="col-sm-6">
										<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="<?= lg("First Name") ?>" required>
									</div>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="<?= lg("auth.Last Name") ?>" required>
									</div>
								</div>

								<div class="form-group">
									<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="<?= lg("auth.Email Address") ?>" required>
								</div>

								<div class="form-group">
									<input type="password" class="form-control" name="password" placeholder="<?= lg("auth.Password") ?>" required>
								</div>

								<div class="form-group">
									<input type="password" class="form-control" name="password_confirmation" placeholder="<?= lg("auth.Password confirmation") ?>" required>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block"><?= lg("auth.Continue") ?></button>
								</div>

								<div class="form-group">
									<a href="/login"><?= lg("auth.Already registered ? Log In") ?></a>
								</div>
							</form>
						</div>

					</div>

				</div>
			</div>
		</div>

	</section><!-- / section-signup -->

@stop
