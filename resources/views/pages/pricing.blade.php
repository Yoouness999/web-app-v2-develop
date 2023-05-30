@extends('layouts.default')

@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
    <section class="section-pricing-title section text-center">
        <div class="container">
            <h1 class="h2"><?= lg("Pricing") ?></h1>
        </div>
    </section>

    <!-- section-pricing-storage -->
    @include('order.storage-content', ['categories' => $categories, 'assets' => $assets, 'from' => 'pricing', 'categoryBySlide' => 2])
    <!-- / section-pricing-storage -->

    <!-- section-pricing-delivery -->
    <section class="section-pricing-delivery section text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <p class="image">
                        <img src="<?= asset('assets/img/pricing-storage-pickup.svg') ?>" alt="<?= lg('pages/pricing.delivery.storage-pickup.title') ?>" />
                    </p>
                    <p class="title">
                        <?= lg('pages/pricing.delivery.storage-pickup.title') ?>
                    </p>
                    <p class="subtitle">
                        <?= lg('pages/pricing.delivery.storage-pickup.subtitle') ?>
                    </p>
                    <p class="content">
                        <?= lg('pages/pricing.delivery.storage-pickup.content') ?>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="image">
                        <img src="{{ asset('assets/img/pricing-delivery.svg') }}" alt="<?= lg('pages/pricing.delivery.delivery.title') ?>" />
                    </p>
                    <p class="title">
                        <?= lg('pages/pricing.delivery.delivery.title') ?>
                    </p>
                    <p class="subtitle">
                        <?= lg('pages/pricing.delivery.delivery.subtitle') ?>
                    </p>
                    <p class="content">
                        <?= lg('pages/pricing.delivery.delivery.content') ?>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="image">
                        <img src="{{ asset('assets/img/pricing-billing.svg') }}" alt="<?= lg('pages/pricing.delivery.billing.title') ?>" />
                    </p>
                    <p class="title">
                        <?= lg('pages/pricing.delivery.billing.title') ?>
                    </p>
                    <p class="subtitle">
                        <?= lg('pages/pricing.delivery.billing.subtitle') ?>
                    </p>
                    <p class="content">
                        <?= lg('pages/pricing.delivery.billing.content') ?>
                    </p>
                </div>
            </div>
        </div>
    </section><!-- / section-pricing-delivery -->

    <!-- section-billing -->
    <section class="section-billing section text-center">
        <div class="container">
            <h2><?= $bottom['title']; ?></h2>
            <div class="well col-sm-10 col-sm-offset-1 text-left">
                <?php
                # Divide items in 2
                $items = array_chunk($bottom['items'], 2);
                ?>
                @foreach($items as $key => $row)
                    <div class="row">
                        @foreach($row as $item)
                            <div class="col-md-6">
                                <p>
                                    <span class="icon-wrapper"><i class="fa fa-check" aria-hidden="true"></i></span>
                                    <?= $item ?>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- / section-billing -->

    <!-- section-pricing-calendar -->
    <section class="section-pricing-calendar text-center bg-gray-lighter-ultra">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p class="image-car">
                        <img src="{{ asset('assets/img/pricing-calendar-car.png') }}" alt="<?= lg('pages/pricing.calendar.car') ?>" />
                    </p>
                    <p class="title title1">
                        <?= lg('pages/pricing.calendar.title1') ?>
                    </p>
                    <p class="content content1">
                        <?= lg('pages/pricing.calendar.content1') ?>
                    </p>
                    <p class="title title2">
                        <?= lg('pages/pricing.calendar.title2') ?>
                    </p>
                    <p class="content content2">
                        <?= lg('pages/pricing.calendar.content2') ?>
                    </p>
                    <p class="title title3">
                        <?= lg('pages/pricing.calendar.title3') ?>
                    </p>
                    <p class="content content3">
                        <?= lg('pages/pricing.calendar.content3') ?>
                    </p>
                </div>
            </div>
            <div class="row calendar">
                <div class="col-md-9">
                    <img class="center-block" src="{{ asset('assets/img/pricing-calendar.svg') }}" alt="<?= lg('pages/pricing.calendar.calendar') ?>" />
                </div>
                <div class="col-sm-3 col-md-3 regular-days text-left">
                    <div class="regular-days text-left">
                        <p class="title">
                            <?= lg('pages/pricing.calendar.regular-days.title') ?>
                        </p>
                    </div>
                    <div class="busy-days text-left">
                        <p class="title" @if(!empty(lg('pages/pricing.calendar.busy-days.help'))) data-toggle="tooltip" title="<?= lg('pages/pricing.calendar.busy-days.help') ?>" @endif>
                            <?= lg('pages/pricing.calendar.busy-days.title') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- / section-pricing-calendar -->

    <!-- section-pricing-schedule -->
    <section class="section-pricing-schedule text-center bg-primary">
        <div class="container">
            <p class="image-car">
                <img src="{{ asset('assets/img/pricing-calendar-car.png') }}" alt="<?= lg('pages/pricing.schedule.car') ?>" />
            </p>
            <p class="title">
                <?= lg('pages/pricing.schedule.title') ?>
            </p>
            <form class="order-form postal_code-form" action="<?= url('/order') ?>" method="post">
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
                    <div class="col-sm-12 contact">
                        <?= lg('pages/home.order_form.text') ?>
                    </div>
                </div>
            </form>
        </div>
    </section><!-- / section-pricing-calendar -->
@stop

@section('js')
    @parent
@stop











