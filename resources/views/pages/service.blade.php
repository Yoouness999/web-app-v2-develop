@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
	<!-- section-service -->
	<section class="section-service section text-center">
		<div class="container">
			<h1><?= $content; ?></h1>
			<?php
			# Divide items in 2 pairs
			$items = array_chunk($items, 2);
			?>
			@foreach($items as $key => $row)
			<div class="row">
				@foreach($row as $item)
				<div class="@if(count($row) == 1)col-sm-6 col-sm-offset-3 @else col-sm-6 @endif">
					<div style="margin:0 auto;width: 297px;height: 224px;vertical-align: middle;text-align: center;white-space: nowrap;">
						<span style="height: 100%;display: inline-block;vertical-align: middle;"></span>
						<img src="<?= $item['image']; ?>" alt="Free boxes" style="margin:0 auto;display:inline; vertical-align: middle;max-height: 224px;max-width: 297px;">
					</div>
					<h4><?= $item['title']; ?></h4>
					<p class="p-sm"><?= $item['description']; ?></p>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
	</section><!-- / section-service -->

	<!-- section-home-testimonies -->
    <section class="section-home-testimonies text-center bg-gray-lighter-ultra">
        <div class="container">
			<h2><?= lg('pages/home.testimonials-title') ?></h2>
            <div class="testimonies-carousel">
                @foreach($testimonials as $item)
                    <div class="item">
                        <div class="testimony">
							<p class="testimony-note">
								@for ($i = 1; $i <= @$item['note']; $i++)
									<i class="fa fa-star" aria-hidden="true"></i>
								@endfor
							</p>
                            <p class="testimony-content">“{{ @$item['text'] }}”</p>
                            <div class="testimony-author">
                                @if(@$item['thumb'])
                                    <img src="{{ $item['thumb'] }}" alt="{{ $item['author'] }}">
                                @endif
                                <p>
                                    {{ @$item['author'] }}<br />
                                    <span class="text-muted">{{ @$item['location'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- / section-home-testimonies -->

	<!-- section-fits -->
	<section class="section-fits section text-center">
		<div class="container">

			<h3><?= $bottom['title']; ?></h3>
			<p class="p-lg"><?= $bottom['description']; ?></p>
			<br>
			<div class="row">
				<div class="col-sm-6">
					<img class="center-block" src="{{ asset( $bottom['image'] ) }}" alt="">
				</div>
				<div class="col-sm-6">
					<img class="center-block" src="{{ asset( $bottom['image2'] ) }}" alt="{{ $bottom['image2_alt'] }}">
				</div>
			</div>
		</div>
	</section><!-- / section-fits -->

	<!-- section-pricing-schedule -->
    <section class="section-pricing-schedule text-center bg-primary">
        <div class="container">
			<p class="image-car">
				<img src="{{ asset('assets/img/pricing-calendar-car.png') }}" alt="<?= lg('pages/pricing.schedule.car') ?>" />
			</p>
			<p class="title">
				<?= lg('pages/pricing.schedule.title') ?>
			</p>
			<form class="order-form postal_code-form" action="<?= url('/order/calculator') ?>" method="get">
				<div class="form-group">
                    <div class="input-group">
                        <input class="form-control" type="text" name="postal_code" placeholder="<?= lg('pages/home.order_form.zip_code_placeholder') ?>" required data-msg-pattern="<?= lg('validation.custom.postal_code') ?>" value="<?= @$postalCode; ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" onclick="dataLayer.push({'event':'zipSearch'});">
                                <?= lg('pages/home.order_form.submit') ?>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="zip-code-error alert alert-warning hidden col-sm-2 col-sm-offset-5">
                        <?= lg('pickup.This area is not available') ?>
                    </div>
                </div>
				<div class="row">
					<div class="col-sm-12">
						<?= lg('pages/home.order_form.text') ?>
					</div>
				</div>
			</form>
		</div>
	</section><!-- / section-pricing-calendar -->

@stop











