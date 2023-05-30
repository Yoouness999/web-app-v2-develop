@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
	<form class="order-appointment-form" action="{{ url('/order/appointment') }}" method="post" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="plan_id" value="{{ $order->plan->id }}">
		<input type="hidden" name="plan_price_per_month" value="{{ $order->plan->price_per_month }}">
		<input type="hidden" name="appointment" value="{{ $order->getServicesAppointment() }}">
		<input type="hidden" name="time_slots_url" value="{{ url('/order/time-slots') }}">

		@include('order.breadcrumb', ['step' => 3])

		<section class="section section-appointment bg-gray-lighter-ultra">
			<div class="container">
				<h1 class="text-center">{{ lg('order.appointment.title') }}</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

				<div class="row order-content-table">
					<div class="col-md-9 order-content-wrapper">
						<div class="row">
							<div class="col-md-12">
								<label>{{ lg('order.appointment.address.label') }}</label>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-6">
								<input class="form-control required maps-autocomplete" type="text" name="address_route" placeholder="{{ lg('order.appointment.address.route.placeholder') }}" value="{{ $order->address_route }}" autocomplete="off" />
							</div>
                            <div class="form-group col-md-3">
                                <input class="form-control required" type="text" name="address_street_number" placeholder="{{ lg('order.appointment.address.street_number.placeholder') }}" value="{{ $order->address_street_number }}" autocomplete="off" />
                            </div>
							<div class="form-group col-md-2">
								<input class="form-control" type="text" name="address_box" placeholder="{{ lg('order.appointment.address.box.placeholder') }}" value="{{ $order->address_box }}" autocomplete="off" />
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-3">
								<input class="form-control required" type="text" name="address_postal_code" placeholder="{{ lg('order.appointment.address.postal_code.placeholder') }}" value="{{ $order->address_postal_code }}" autocomplete="off" />
							</div>
							<div class="form-group col-md-4">
								<input class="form-control required" type="text" name="address_locality" placeholder="{{ lg('order.appointment.address.locality.placeholder') }}" value="{{ $order->address_locality }}" autocomplete="off" />
							</div>
                            <input type="hidden" name="address_country" value="BE">
							<?php /*<div class="form-group col-md-4 align-bottom">
								<select class="form-control" name="address_country">
                                    <option class="placeholder" disabled>{{ lang('order.appointment.address.country.placeholder') }}</option>
								</select>
							</div>*/ ?>
						</div>

						<div class="row">
                            @if ($showDropOff)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dropoff-date">{{ lg('order.appointment.dropoff.label') }}</label>
                                        <div class="input-group dropoff-date-input-group col-md-8">
                                            <input class="form-control required datepicker" id="dropoff-date" type="text" name="dropoff_date" value="{{ $order->getDropoffDate() }}" placeholder="{{ lg('order.appointment.dropoff.placeholder') }}" readonly />
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    <span class="fa fa-calendar" aria-hidden="true"></span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group dropoff-time-input-group col-md-7 @if (!$order->getDropoffTime()) disabled @endif">
                                            <select class="form-control required" id="dropoff-time" name="dropoff_time" @if (!$order->getDropoffTime()) disabled="disabled" @endif>
                                                <option></option>
                                                @foreach ($dropoffTimeSlots as $timeSlot)
                                                    @php
                                                        $time = $timeSlot['from']->format('Y-m-d H:i:s') . '_' . $timeSlot['to']->format('Y-m-d H:i:s');
                                                    @endphp
                                                    <option class="time" value="{{ $time }}" @if ($order->getDropoffTime() == $time) selected="selected" @endif>
                                                        {{ $timeSlot['from']->format('H:i') . ' - ' . $timeSlot['to']->format('H:i') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    <span class="fa fa-clock-o" aria-hidden="true"></span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="divider divider--hidden visible-xs" aria-hidden="true"></div>
                                </div>
                            @endif
							<div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickup-date">{{ lg('order.appointment.pickup.label') }}</label>
                                    <div class="input-group pickup-date-input-group col-md-8 @if ($order->wait_fill_boxes) disabled @endif">
                                        <input class="form-control required datepicker" id="pickup-date" type="text" name="pickup_date" value="{{ $order->getPickupDate() }}" placeholder="{{ lg('order.appointment.pickup.placeholder') }}" @if ($order->wait_fill_boxes) disabled="disabled" @endif readonly />
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary">
                                                <span class="fa fa-calendar" aria-hidden="true"></span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group pickup-time-input-group col-md-7 @if (!$order->getPickupTime() || $order->wait_fill_boxes) disabled @endif">
                                        <select class="form-control required" id="pickup-time" name="pickup_time" @if (!$order->getPickupTime() || $order->wait_fill_boxes) disabled="disabled" @endif>
                                            <option></option>
                                            @foreach ($pickupTimeSlots as $timeSlot)
                                                @php
                                                    $time = $timeSlot['from']->format('Y-m-d H:i:s') . '_' . $timeSlot['to']->format('Y-m-d H:i:s');
                                                @endphp
                                                <option class="time" value="{{ $time }}" @if ($order->getPickupTime() == $time) selected="selected" @endif>
                                                    {{ $timeSlot['from']->format('H:i') . ' - ' . $timeSlot['to']->format('H:i') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary">
                                                <span class="fa fa-clock-o" aria-hidden="true"></span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
							</div>
						</div>

                        @if ($showDropOff)
                            <div class="checkbox wait-fill-boxes-checkbox">
                                <input type="checkbox" name="wait_fill_boxes" id="wait_fill_boxes" value="yes" @if ($order->wait_fill_boxes) checked="checked" @endif />
                                <label for="wait_fill_boxes">{{ lg('order.appointment.wait-fill-boxes.label') }}</label>
                            </div>
                        @endif

                        <div class="divider divider--hidden" aria-hidden="true"></div>

						<div class="storing-duration">
							<p>
								<label class="storing-duration-label">{{ lg('order.appointment.storing-duration.label') }}</label>
							</p>
							<div class="storing-duration-inputs">
								@foreach ($storingDurations as $storingDuration)
									<input
                                        @if ($user && $user->storing_duration)
                                            @if ($user->storing_duration->month > $storingDuration->month)
                                                disabled="disabled"
                                            @elseif ($user->storing_duration->month == $storingDuration->month)
                                                checked="checked"
                                            @endif
                                        @elseif ($order->storingDuration && $order->storingDuration->id == $storingDuration->id || !$order->storingDuration && $storingDuration->slug == '-3_months')
                                            checked="checked"
                                        @endif
                                        data-discount-percentage="{{ $storingDuration->discount_percentage }}"
                                        id="{{ $storingDuration->slug }}"
                                        name="storing_duration"
                                        type="radio"
                                        value="{{ $storingDuration->id }}"
                                    />
									<label
                                        @if ($user && $user->storing_duration && $user->storing_duration->month > $storingDuration->month)
                                            class="radio-inline disabled"
                                        @else
                                            class="radio-inline"
                                        @endif
                                        for="{{ $storingDuration->slug }}"
                                    >
                                        {{ lg('order.appointment.storing-duration.' . $storingDuration->slug) }}
                                        @if(!empty(lg('order.tooltips.' . $storingDuration->slug)))
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-title="{{ lg('order.tooltips.' . $storingDuration->slug) }}"></i>
                                        @endif
                                    </label>
								@endforeach
							</div>
						</div>

						<div class="form-group">
							<button class="btn btn-primary" type="submit">{{ lg('order.appointment.submit') }}</button>
						</div>
					</div>
					<div class="col-md-3 text-right order-resume-wrapper">
						<div class="order-resume following loading--overlay">
                            <div class="loader"></div>
							<p class="title">{{ lg('order.resume.title') }}</p>
							<p class="plan"><span class="value">{{ $order->getPriceFormatedPerMonth() }}</span>€</p>
							<p class="appointment-title">{{ lg('order.resume.appointment') }}</p>
							<p class="appointment"><span class="value">{{ number_format($order->getServicesAppointment(), 2, ',', '.') }}</span>€</p>
							<p class="notice">{{ lg('order.resume.notice') }}</p>
							<p class="services-title">{{ lg('order.resume.services-title') }}</p>
							<div class="services">
                                @if ($order->getServicesAppointment() == 0)
                                    <div>
                                        <p class="service-label"><?= lg('order.services.appointment.free') ?></p>
                                    </div>
                                @else
                                    @foreach ($order->services as $service)
                                        @if ($service['price'] > 0)
                                            <div>
                                                @if (!$service['Answer']->value_boolean)
                                                    <p class="service-label">{{ strtr(lg('order.resume.services.' . $service['Answer']->slug), ['{floor}' => $service['value']]) }}</p>
                                                @else
                                                    <p class="service-label">{{ lg('order.resume.services.' . $service['Answer']->slug) }}</p>
                                                @endif
                                                <p><span class="service-appointment">&nbsp;</span></p>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<section class="section bg-gray-lighter-ultra">
			<div class="container">
                @include('order.faq', ['faqs' => array_slice(Label::extract('order')['faq'], 3, 2)])
			</div>
		</section>
	</form>

    @php
        if (App::getLocale() == 'fr') {
            $lang = 'fr';
        } else {
            $lang = 'en-US';
        }
    @endphp
    <script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=places&language={{ $lang }}&key=AIzaSyCIjc3NxG65UPljS1GZXAl83XyZWf1HGKg"></script>
@stop
