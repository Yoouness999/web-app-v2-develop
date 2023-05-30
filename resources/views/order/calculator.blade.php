<?php
/**
 * @var $currentPlan \App\OrderPlan
 * @var $order \App\Order
 */
?>
@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top  no-transition">
@stop

@section('content')
    <div class="section-calculator-wrapper<?php /* blocked*/ ?>">
        <?php /*<form class="postal_code-form" action="<?= url('/order') ?>" method="post">
            <div>
                <h4><?= lg('pages/home.order_form.zip_code_title') ?></h4>

                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" type="text" name="postal_code" placeholder="<?= lg('pages/home.order_form.zip_code_placeholder') ?>" value="<?= @$postalCode ?>" required data-msg-pattern="<?= lg('validation.custom.postal_code') ?>" >
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                <?= lg('pages/home.order_form.submit') ?>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>*/ ?>

        <form class="order-calculator-form" action="<?= url('/order/calculator') ?>" method="post">
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="find_price_url" value="<?= url('/order/storage/find-price') ?>">
            <input type="hidden" name="volume" value="0">
            <input type="hidden" name="volume_current" value="<?= strval($currentVolume) ?>">
            <input id="js-postal_code" type="hidden" name="postal_code" value="<?= strval($postalCode) ?>">

            <section class="section-calculator section text-center bg-gray-lighter-ultra">
                <div class="container">
                    <h1><?= lg('order.calculator.title') ?></h1>
                    <p class="subtitle"><?= lg('order.calculator.subtitle') ?></p>
                    <ul class="toggle storing-duration">
                        @foreach ($storingDurations as $item)
                            <li>
                                <input type="radio" name="storing_duration" id="<?= $item->slug ?>" value="<?= $item->id ?>" data-discount-percentage="<?= $item->discount_percentage ?>" @if ($storingDuration && $storingDuration->id == $item->id || !$storingDuration && $item->slug == '-3_months') checked="checked" @endif />
                                <label for="<?= $item->slug ?>">
                                    <?= lg('order.storing-duration.' . $item->slug) ?>
                                    @if(!empty(lg('order.tooltips.' . $item->slug)))
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?= lg('order.tooltips.' . $item->slug) ?>"></i>
                                    @endif
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <div class="storage-supplies">
                        <p class="title"><?= lg('order.calculator.storage-supplies.title') ?></p>
                        @foreach ($storageSuppliesCategory->items()->get() as $item)
                            <p class="item">
                                <input type="hidden" name="volumes[<?= $item->id ?>]" value="<?= $item->volume_m3 ?>" />
                                <span class="increment-wrapper" data-max="50">
                                    <input type="text" name="items[<?= $item->id ?>]" id="item-<?= $item->slug ?>" @if ($order && $orderItem = $order->getItem($item->slug)) class="active" value="<?= $orderItem['quantity'] ?>" @else value="0" @endif autocomplete="off" data-default-value="0" />
                                    <span class="increment-buttons">
                                        <button type="button" class="increment-add">+</button>
                                        <button type="button" class="increment-remove">-</button>
                                    </span>
                                </span>
                                <label for="item-{{ $item->slug }}">
                                    @include('order.svg.items.' . $item->slug)
                                    <?= $item->name ?>
                                </label>
                            </p>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="section-calculator-categories panel-group section bg-gray-lighter-ultra" id="categories">
                @foreach ($categories as $c => $category)
                    <div class="panel category-wrapper">
                        <div class="container text-center">
                            @if ($c % 4 == 0)
                                <div class="row hidden-xs">
                                    @foreach ($categories as $d => $desktopCategory)
                                        @if ($d >= $c && $d < $c + 4)
                                            <div class="col-category col-sm-4 col-md-3">
                                                <a class="category @if ($d != 0) collapsed @endif" href="#items-<?= $d ?>" data-toggle="collapse" data-parent="#categories">
                                                    <p class="image">
                                                        @include('order.svg.categories.' . $desktopCategory->slug)
                                                    </p>
                                                    <p class="title">
                                                        <?= $desktopCategory->name ?>
                                                        <span class="count"></span>
                                                    </p>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <div class="visible-xs">
                                <a class="category category-for-volume @if ($c != 0) collapsed @endif" href="#items-<?= $c ?>" data-toggle="collapse" data-parent="#categories">
                                    <p class="image">
                                        @include('order.svg.categories.' . $category->slug)
                                    </p>
                                    <p class="title">
                                        <?= $category->name ?>
                                        <span class="count"></span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div id="items-{{ $c }}" class="items panel-collapse collapse @if ($c == 0) in @endif">
                            <div class="container">
                                <div class="row">
                                    @foreach ($category->items()->get() as $item)
                                        <div class="item col-xs-12 col-sm-4 col-md-3">
                                            <input type="hidden" name="volumes[<?= $item->id ?>]" value="<?= $item->volume_m3 ?>" />
                                            <span class="increment-wrapper" data-max="50">
                                                <input type="text" name="items[<?= $item->id ?>]" id="item-<?= $item->slug ?>" @if ($order && $orderItem = $order->getItem($item->slug)) class="active" value="<?= $orderItem['quantity'] ?>" @else value="0" @endif autocomplete="off" data-default-value="0" />
                                                <span class="increment-buttons">
                                                    <button type="button" class="increment-add">+</button>
                                                    <button type="button" class="increment-remove">-</button>
                                                </span>
                                            </span>
                                            <label for="item-{{ $item->slug }}">
                                                <?= $item->name ?>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="section-calculator-total section text-center">
                <div class="container">
                    @if($order && $order->plan)
                        <div class="plan" data-url="/order/storage/remove-plan-from-session">
                            <p class="label"><?= lg('order.calculator.current_plan') ?></p>
                            <p class="name"><?= $order->plan->name ?: $order->plan->slug ?></p>
                            <button class="close" type="button">&times;</button>
                            <span class="loader"></span>
                        </div>
                    @endif
                    <p class="total-label"><?= lg('order.calculator.total') ?></p>
                    <p class="total-value"><span class="calculator-total">0</span>m<sup>3</sup></p>
                    <p class="button-wrapper">
                        <button class="btn btn-primary" type="button" disabled>
                            <?= lg('order.calculator.find') ?>
                        </button>
                    </p>
                </div>
            </section>
        </form>

    </div>
@stop
