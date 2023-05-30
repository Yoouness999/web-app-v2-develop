@extends('layouts.default')

@section('content')

	<!-- page-banner -->
	<section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
	   	<img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">
	   	<div class="page-banner-content">
	   		<h1><?= $title; ?></h1>
	   		<h2><?= $subtitle; ?></h2>
			@include('parts.btn-get-started')
	   	</div>
	</section><!-- / page-banner -->

	<!-- section-contact -->
	<section class="section-contact section">
		<div class="container">
			<div class="row">

				<div class="col-sm-6">
					<?= $content_left; ?>
				</div>

				<div class="col-sm-6">

					@if(isset($result) && $result)
						<div class="alert alert-success">
							<?= lg("common.Your message was successfully delivered to the Boxify's Team.") ?>
						</div>
						<script>
							dataLayer.push({
								'event':'Contact',
								'action':'Send',
								'label':'<?= e(request()->get('subject')); ?>'
							});
						</script>
					@endif

                        <!-- form-contact -->
					<form class="form-contact" action="#" method="post">

						<input type="hidden" name="_token" value="<?= csrf_token(); ?>" />

						<div class="form-group">
							<label for="subject" class="sr-only"><?= lg("Subject") ?> *</label>
							<select name="subject" id="subject" class="form-control" required>
								<option value="" disabled selected><?= lg("common.Subject") ?></option>
								@foreach($form['subjects'] as $key => $item)
									@if(isset($item['title']))
									<option value="<?= $key; ?>" <?php if(request()->get('subject') == $key): echo 'selected="selected"'; endif; ?>><?= $item['title']; ?></option>
									@endif
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="email" class="sr-only"><?= lg("common.Email") ?></label>
							<input type="email" class="form-control" name="email" id="email" placeholder="<?= lg("common.Email") ?> *" required>
						</div>

						<div class="form-group">
							<textarea class="form-control" name="message" id="message" placeholder="<?= lg("common.Your message") ?> *" required></textarea>
						</div>

						<div class="form-group text-center">
							<button class="btn btn-primary btn-block" type="submit"><?= lg("common.Submit") ?></button>
						</div>

					</form><!-- / form-contact -->

				</div>

			</div>

		</div>
	</section><!-- / section-contact -->

@stop

@section('js')
    @parent
@stop











