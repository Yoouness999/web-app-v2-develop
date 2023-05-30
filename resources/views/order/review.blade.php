@extends('layouts.default')

<?php
/**
 * @see \App\Http\Controllers\OrderController::getReview()
 * @var $hasInvitationCoupon boolean
 * @var $order \App\Order
 */

use App\Api;
?>

@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
        @stop

        @section('js')
            @parent
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('app.google.places') }}&libraries=places"></script>
        @stop

        @section('content')
            <form class="order-review-form" action="{{ url('/order/review') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="price_per_month" value="{{ $order->getPricePerMonth() }}">

                @include('order.breadcrumb', ['step' => 5])

                <section class="section section-review bg-gray-lighter-ultra">
                    <div class="container">
                        <h1 class="text-center"><?= lg('order.review.title') ?></h1>

                        <div class="row order-content-table">
                            <div class="col-md-9 order-content-wrapper">
                                <div class="part account-part">
                                    @if (auth()->guest())
                                        <div class="tab-content">

                                            <div class="tab-pane @if (session('register.errors') || !session('login.errors')) active @endif" id="account-register">
                                                <p class="part-title"><?= lg('order.review.account.register.title') ?></p>

                                                @if (session('register.errors'))
                                                    <div class="alert alert-danger">
                                                        <ul class="list-unstyled">
                                                            @foreach (session('register.errors') as $error)
                                                                @if (is_array($error))
                                                                    @foreach ($error as $err)
                                                                        <li>{{ $err }}</li>
                                                                    @endforeach
                                                                @else
                                                                    <li>{{ $error }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="form-group col-md-6 @if (in_array('first_name', session('register.keys', []))) has-error @endif">
                                                        <input class="form-control required" type="text" name="register[first_name]" placeholder="<?= lg('order.review.account.first-name.placeholder') ?>" value="{{ old('register.first_name') }}">
                                                    </div>
                                                    <div class="form-group col-md-6 @if (in_array('last_name', session('register.keys', []))) has-error @endif">
                                                        <input class="form-control required" type="text" name="register[last_name]" placeholder="<?= lg('order.review.account.last-name.placeholder') ?>" value="{{ old('register.last_name') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 @if (in_array('phone', session('register.keys', []))) has-error @endif">
                                                        <input class="form-control required phone" type="text" name="register[phone]" placeholder="<?= lg('order.review.account.phone.placeholder') ?>" value="{{ old('register.phone') }}" data-mask="+00 0000000009">
                                                    </div>
                                                    <div class="form-group col-md-6 @if (in_array('email', session('register.keys', []))) has-error @endif">
                                                        <input class="form-control required email" type="email" name="register[email]" placeholder="<?= lg('order.review.account.email.placeholder') ?>" value="{{ old('register.email') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <input class="form-control required password" type="password" name="register[password]" placeholder="<?= lg('order.review.account.password.placeholder') ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input class="form-control required password_confirmation" type="password" name="register[password_confirmation]" placeholder="<?= lg('order.review.account.password_confirmation.placeholder') ?>">
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary btn-block" type="submit" name="process" value="register"><?= lg('order.review.account.register.button') ?></button>

                                                <div class="divider divider--hidden" aria-hidden="true"></div>

                                                <p>
                                                    @lang('order.review.account.register.link', ['beforeLink' => '<a href="#account-login" data-toggle="tab">', 'afterLink' => '</a>'])
                                                </p>
                                            </div>

                                            <div class="tab-pane @if (session('login.errors')) active @endif" id="account-login">
                                                <p class="part-title"><?= lg('order.review.account.login.title') ?></p>

                                                @if (session('login.errors'))
                                                    <div class="alert alert-danger">
                                                        <ul class="list-unstyled">
                                                            @foreach (session('login.errors') as $error)
                                                                @if (is_array($error))
                                                                    @foreach ($error as $err)
                                                                        <li>{{ $err }}</li>
                                                                    @endforeach
                                                                @else
                                                                    <li>{{ $error }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <input class="form-control required email" type="email" name="login[email]" placeholder="<?= lg('order.review.account.email.placeholder') ?>" value="{{ old('register.email') }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input class="form-control required password" type="password" name="login[password]" placeholder="<?= lg('order.review.account.password.placeholder') ?>">
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary btn-block" type="submit" name="process" value="login"><?= lg('order.review.account.login.button') ?></button>

                                                <div class="divider divider--hidden" aria-hidden="true"></div>

                                                <p>
                                                    <?= shortcode(lg('order.review.account.login.link'), ['beforeLink' => '<a href="#account-register" data-toggle="tab">', 'afterLink' => '</a>']) ?>
                                                </p>

                                                <p>
                                                    <?= shortcode(lg('order.review.account.forgot.link'), ['beforeLink' => '<a href="/password/email">', 'afterLink' => '</a>']) ?>
                                                </p>
                                            </div>

                                        </div>
                                    @else
                                        <div class="account-update">
                                            <p class="part-title"><?= lg('order.review.account.update.title') ?></p>

                                            @if (session('common.errors'))
                                                <div class="alert alert-danger">
                                                    <ul class="list-unstyled">
                                                        @foreach (session('common.errors') as $error)
                                                            @if (is_array($error))
                                                                @foreach ($error as $err)
                                                                    <li>{{ $err }}</li>
                                                                @endforeach
                                                            @else
                                                                <li>{{ $error }}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input class="form-control required" type="text" name="first_name" placeholder="<?= lg('order.review.account.first-name.placeholder') ?>" @if ($user) value="{{ $user->first_name }}" @endif >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control required" type="text" name="last_name" placeholder="<?= lg('order.review.account.last-name.placeholder') ?>" @if ($user) value="{{ $user->last_name }}" @endif >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input class="form-control required phone" type="text" name="phone" placeholder="<?= lg('order.review.account.phone.placeholder') ?>" @if ($user) value="{{ $user->phone }}" @endif data-mask="+00 0000000009" >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control required email" type="email" name="email" placeholder="<?= lg('order.review.account.email.placeholder') ?>" @if ($user) value="{{ $user->email }}" @endif >
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="part booking-overview-part">
                                    <p class="part-title"><?= lg('order.review.booking-overview.title') ?></p>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="plan">
                                                <p class="image">
                                                    <img src="{{ asset($order->plan->image) }}" alt="{{ $order->plan->name }}">
                                                </p>
                                                <p class="name">{{ $order->plan->name }}</p>
                                                <p class="price">@lang('order.review.booking-overview.price', ['price' => $order->plan->price_per_month])</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7 storage-supplies">
                                            <p class="introduction"><?= lg('order.review.booking-overview.storage-supplies') ?></p>

                                            @foreach ($storageSuppliesCategory->items()->get() as $item)
                                                <p class="item">
                                            <span class="increment-wrapper">
                                                <span class="form-control-static <?= $order->getItem($item->slug) ? 'active' : '' ?>"><?= $order->getItem($item->slug) ? $order->getItem($item->slug)['quantity'] : '0' ?></span>
                                            </span>
                                                    <label for="item-{{ $item->slug }}">
                                                        @include('order.svg.items.' . $item->slug)
                                                        <?= $item->name ?>
                                                    </label>
                                                </p>
                                            @endforeach

                                            <div class="divider divider--hidden" aria-hidden="true"></div>

                                            <p class="text-help"><?= lg('order.review.booking-overview.help') ?></p>

                                            <div class="divider divider--hidden divider--x2" aria-hidden="true"></div>

                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/calculator"><?= lg('order.review.storage.edit') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="part assurance-part">
                                    <p class="part-title"><?= lg('order.review.assurance.title') ?></p>

                                    <div class="assurance-inputs @if(!$order->assurance) untouched @endif">
                                        <div class="row">
                                            @foreach ($assurances as $assurance)
                                                <div class="col-sm-6 col-lg-3">
                                                    <input id="{{ $assurance->slug }}" type="radio" name="assurance" value="{{ $assurance->id }}" required data-price-per-month="{{ $assurance->price_per_month }}"
                                                           @if (($order->assurance && $order->assurance->slug == $assurance->slug))
                                                           checked="checked"
                                                           @endif
                                                           @if ($user && $user->insurance && $user->insurance->id > $assurance->id)
                                                           disabled="disabled"
                                                        @endif
                                                    >
                                                    <label for="{{ $assurance->slug }}"
                                                           @if ($user && $user->insurance && $user->insurance->id > $assurance->id)
                                                           class="disabled"
                                                        @endif
                                                    >
                                                        <div class="card-heading">
                                                            <strong><?= lg('order.review.assurance.' . strtolower($assurance->slug) . '.title') ?></strong>
                                                            <strong><?= shortcode(lg('order.review.assurance.' . strtolower($assurance->slug) . '.price'), ['price' => $assurance->price_per_month]) ?></strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <?= lg('order.review.assurance.' . strtolower($assurance->slug) . '.description') ?>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="part appointment-part">
                                    <p class="part-title"><?= lg('order.review.appointment.title') ?></p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            @if ($order->dropoff_date_from)
                                                <div class="appointment-block dropoff">
                                                    <p class="label">
                                                        <?= lg('order.review.appointment.dropoff') ?>
                                                        <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/appointment"><?= lg('order.review.appointment.edit') ?></button>
                                                    </p>
                                                    <p class="date">{{ $order->dropoff_date_from->format('l, F, j, Y') }}</p>
                                                    <p class="time">{{ $order->dropoff_date_from->format('H:i') . ' - ' . $order->dropoff_date_to->format('H:i') }}</p>
                                                </div>
                                            @endif

                                            @if (!$order->wait_fill_boxes)
                                                <div class="appointment-block pickup">
                                                    <p class="label">
                                                        <?= lg('order.review.appointment.pickup') ?>
                                                        <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/appointment"><?= lg('order.review.appointment.edit') ?></button>
                                                    </p>
                                                    @if ($order->pickup_date_from)
                                                        <p class="date">{{ $order->pickup_date_from->format('l, F, j, Y') }}</p>
                                                        <p class="time">{{ $order->pickup_date_from->format('H:i') . ' - ' . $order->pickup_date_to->format('H:i') }}</p>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="appointment-block address">
                                                <p class="label">
                                                    <?= lg('order.review.appointment.address') ?>
                                                    <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/appointment"><?= lg('order.review.appointment.edit') ?></button>
                                                </p>
                                                <p class="route">
                                                    {{ $order->address_route }}
                                                    {{ $order->address_street_number }}
                                                </p>
                                                <p class="city">
                                                    {{ $order->address_locality }},
                                                    {{ $order->address_postal_code }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="comments">
                                                <div class="form-group">
                                                    <label for="comments"><?= lg('order.review.appointment.comments.label') ?></label>
                                                    <textarea class="form-control" id="comments" name="comments" placeholder="<?= lg('order.review.appointment.comments.placeholder') ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="other-address">
                                        <input type="hidden" name="business" value="<?= !isset($order->business) || $order->business == 0 ? 0 : 1 ?>">

                                        <div class="btn-group">
                                            <button class="btn<?= is_integer($order->business) && $order->business == 0 ? ' active' : '' ?>" type="button" data-target="#billing_address-part" data-name="business" data-value="0">
                                                <?= lg('order.review.appointment.billing_address') ?>
                                            </button>
                                            <button class="btn<?= is_integer($order->business) && $order->business == 1 ? ' active' : '' ?>" type="button" data-target="#company_address-part" data-name="business" data-value="1">
                                                <?= lg('order.review.appointment.company_address') ?>
                                            </button>
                                        </div>

                                        <div class="divider divider--hidden" aria-hidden="true"></div>

                                        <div class="other-addresslgpart<?= !is_integer($order->business) || $order->business != 0 ? ' hide' : '' ?>" id="billing_address-part">
                                            <p class="part-title"><?= lg('order.review.billing.title') ?></p>

                                            <div class="row">
                                                <div class="form-group col-md-7">
                                                    <input class="form-control maps-autocomplete" type="text" name="billing_address_route" placeholder="<?= lg('order.review.billing.address.placeholder') ?>" value="{{ $order->billing_address_route }}"
                                                           data-street_number="[name='billing_address_street_number']"
                                                           data-route="[name='billing_address_route']"
                                                           data-postal_code="[name='billing_address_postal_code']"
                                                           data-locality="[name='billing_address_locality']"
                                                           data-country="[name='billing_address_country']"
                                                    >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" type="text" name="billing_address_street_number" placeholder="<?= lg('order.review.billing.street_number.placeholder') ?>" value="{{ $order->billing_address_street_number }}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" type="text" name="billing_address_box" placeholder="<?= lg('order.review.billing.box.placeholder') ?>" value="{{ $order->billing_address_box }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" type="text" name="billing_address_postal_code" placeholder="<?= lg('order.review.billing.postal_code.placeholder') ?>" value="{{ $order->billing_address_postal_code }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" type="text" name="billing_address_locality" placeholder="<?= lg('order.review.billing.locality.placeholder') ?>" value="{{ $order->billing_address_locality }}">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <input class="form-control" type="text" name="billing_address_country" placeholder="<?= lg('order.review.billing.country.placeholder') ?>" value="{{ $order->billing_address_country }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="other-addresslgpart<?= !is_integer($order->business) || $order->business != 1 ? ' hide' : '' ?>" id="company_address-part">
                                            <p class="part-title"><?= lg('order.review.company.title') ?></p>

                                            <div class="row">
                                                <div class="form-group col-md-7">
                                                    <input class="form-control maps-autocomplete" type="text" name="company_address_route" placeholder="<?= lg('order.review.company.address.placeholder') ?>" value="{{ $order->company_address_route }}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" type="text" name="company_address_street_number" placeholder="<?= lg('order.review.company.street_number.placeholder') ?>" value="{{ $order->company_address_street_number }}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" type="text" name="company_address_box" placeholder="<?= lg('order.review.company.box.placeholder') ?>" value="{{ $order->company_address_box }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" type="text" name="company_address_postal_code" placeholder="<?= lg('order.review.company.postal_code.placeholder') ?>" value="{{ $order->company_address_postal_code }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" type="text" name="company_address_locality" placeholder="<?= lg('order.review.company.locality.placeholder') ?>" value="{{ $order->company_address_locality }}">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <select class="form-control" name="company_address_country">
                                                        <option class="placeholder" disabled @if (!$order->company_address_country) selected @endif>
                                                            <?= lg('order.review.company.country.placeholder') ?>
                                                        </option>
                                                        @foreach ($countries as $option => $label)
                                                            <option value="{{ $label['slug'] }}" data-code="{{ strtolower($label['slug']) }}" data-vat="{{ $label['tax'] }}" @if ($order->company_address_country == $label['slug']) selected @endif>
                                                                {{ $label['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="divider divider--hidden" aria-hidden="true"></div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input class="form-control" type="text" name="company_name" placeholder="<?= lg('order.review.company.name.placeholder') ?>" value="{{ $order->company_name }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control" type="text" name="company_vat_number" placeholder="<?= lg('order.review.company.vat-number.placeholder') ?>" value="{{ $order->company_vat_number }}">
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary hide" type="submit"><?= lg('order.review.submit') ?></button>
                                    </div>
                                </div>
                            <!--<div class="part company-part">
                            <p class="part-title"><?= lg('order.review.company.title') ?></p>
                        </div>-->


                                <div class="part billing-part">
                                    <p class="part-title"><?= lg('order.review.billing.title') ?></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if ($order->card_number)
                                                <p class="card-number">
                                                    <img src="{{ asset('assets/img/order/review/card.svg') }}" alt="Card" />
                                                    {{ $order->card_number }}
                                                    <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/billing"><?= lg('order.review.billing.edit') ?></button>
                                                </p>
                                            @elseif ($order->iban)
                                                <p class="iban">
                                                    {{ $order->iban }}
                                                    <button class="btn btn-link btn-xs" type="submit" name="redirect" value="/order/billing"><?= lg('order.review.billing.edit') ?></button>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                @if($hasInvitationCoupon)
                                                    <p><?= lg("order.resume.invitation-applied") ?></p>
                                                @else
                                                    <input class="form-control" id="coupon" type="text" name="coupon" value="<?= ($order->promo_code ?: '') ?>" placeholder="<?= lg('order.review.billing.coupon.placeholder') ?>">
                                                    <span class="loader"></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="part how-did-your-hear-about-us-part">
                                    <p class="part-title"><?= lg('order.review.how-did-your-hear-about-us.title') ?></p>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <select class="form-control" name="how_did_your_hear_about_us">
                                                <option class="placeholder" disabled @if (!$order->how_did_your_hear_about_us) selected @endif><?= lg('order.review.how-did-your-hear-about-us.placeholder') ?></option>
                                                @foreach (array_get(Label::extract('order'), 'review.how-did-your-hear-about-us.options') as $option => $label)
                                                    <option value="{{ $option }}" @if ($order->how_did_your_hear_about_us == $label || (!in_array($order->how_did_your_hear_about_us, array_values(lg('order.review.how-did-your-hear-about-us.options'))) && $option == 'Other')) selected="selected" @endif>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input class="form-control @if (in_array($order->how_did_your_hear_about_us, array_values(lg('order.review.how-did-your-hear-about-us.options'))) || $order->how_did_your_hear_about_us != 'Other') hide @endif" type="text" name="how_did_your_hear_about_us_comment" placeholder="<?= lg('order.review.how-did-your-hear-about-us.comment.placeholder') ?>" @if (!in_array($order->how_did_your_hear_about_us, array_values(lg('order.review.how-did-your-hear-about-us.options')))) value="{{ $order->how_did_your_hear_about_us }}" @endif >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <input id="input-gdpr" name="gdpr" type="checkbox" required>
                                        <label for="input-gdpr"><?= lg('order.review.terms') ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"><?= lg('order.review.submit') ?></button>
                                </div>
                            </div>

                            <div class="col-md-3 text-right order-resume-wrapper">
                                <div class="order-resume following">
                                    <p class="title"><?= lg('order.resume.title') ?></p>
                                    <p class="plan"><span class="value"><?= $order->getPriceFormatedPerMonth() ?></span>€</p>

                                    <?php
                                    // Show Prorata total
                                    ?>
                                    <p class="appointment-title">
                                        <?= shortcode(lg('order.resume.prorata-title'), [
                                            'from' => $order->pickup_date_from->format('d/m/Y'),
                                            'to' => $order->pickup_date_from->format('t/m/Y')
                                        ]) ?>
                                    </p>
                                    <p class="appointment"><span class="value"><?= $order->getPriceProratedPerMonth() ?></span>€</p>

                                    @if($hasInvitationCoupon)
                                        <p class="appointment-title"><?= lg('order.resume.invitation-discount-title') ?></p>
                                        <p class="appointment"><span class="value"><?= $invitationDiscount ?></span>€</p>
                                    @endif
                                    <p class="appointment-title"><?= lg('order.resume.appointment') ?></p>
                                    <p class="appointment"><span class="value"><?= $order->getAppointment() ?></span>€</p>
                                    <p class="notice"><?= lg('order.resume.notice') ?></p>
                                    <div class="resume-row services-title">
                                        <p>
                                            <?= lg('order.resume.services-title') ?>

                                            @if(!empty(lg('order.tooltips.resume.services')))
                                                <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?= lg('order.tooltips.resume.services') ?>"></i>
                                            @endif
                                        </p>
                                        @if ($order->getServicesAppointment() == 0)
                                            <p><span class="value"><?= lg('order.services.appointment.free') ?></span></p>
                                        @else
                                            <p><?= $order->getServicesAppointment() ?>€</p>
                                        @endif                                      
                                    </div>
                                    <div class="services">                                    
                                        @foreach ($order->services as $service)
                                            <div>
                                                <p class="service-label"><?= lg('order.resume.services.' . $service['Answer']->slug) ?></p>
                                                <p class="service-appointment"></p>
                                            </div>
                                        @endforeach                                    
                                    </div>
                                    @if($order->storingDuration->month > 5)
                                        <div class="resume-row">
                                            <p><?= lg('order.resume.storing-duration') ?></p>
                                            <p><?= lg('order.storing-duration.' . $order->storingDuration->slug) ?></p>
                                        </div>
                                    @endif
                                    <div class="resume-row assurance">
                                        <p><?= lg('order.resume.assurance') ?></p>
                                        <p>
                                    <span class="price">
                                        <span class="value">0</span>€/mo
                                    </span>
                                            <span class="empty">
                                        <?= lg('order.services.appointment.free') ?>
                                    </span>
                                        </p>
                                    </div>
                                    <p class="assets-title"><?= lg('order.resume.assets-title') ?></p>
                                    @foreach ($order->plan->assets as $asset)
                                        <div class="asset">
                                            <p><?= $asset->name ?></p>
                                            <p><?= lg('order.resume.assets-price') ?></p>
                                        </div>
                                    @endforeach
                                    <div class="resume-row discount hide">
                                        <p><?= ucfirst(lg('common.discount')) ?></p>
                                        <p class="discount"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
@stop
