@extends('layouts.default')

@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
    <form class="order-billing-form" action="{{ url('/order/billing') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="adyen_client_encryption_public_key" type="hidden" value="{{ Config::get('adyen.client_encryption_public_key') }}">
        <input id="adyen_generationtime" type="hidden" value="{{ date('c') }}">
        <input type="hidden" name="adyen_card_encrypted_json">
        <input type="hidden" name="card_number_part">

        @if($user)
            @if ($user && $user->billing_card || $user->billing_iban)
                <input type="hidden" name="keep_payment">
            @endif
        @endif

        @include('order.breadcrumb', ['step' => 4])

        <section class="section section-billing bg-gray-lighter-ultra">
            <div class="container">
                <h1 class="text-center"><?= lg('order.billing.title') ?></h1>
                <p class="subtitle"><?= lg('order.billing.subtitle') ?></p>

                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <input id="payment_type_sepa" type="radio" name="payment_type" value="sepa"
                            @if($order && $order->iban || ($user && $user->billing_iban))
                                checked="checked"
                            @endif
                        >
                        <input id="payment_type_credit-card" type="radio" name="payment_type" value="credit_card"
                            @if($user)
                                @if(!$user->isIban())
                                    checked="checked"
                                @endif
                            @endif
                        >

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="label-payment-type">
                            <label for="payment_type_sepa"><?= lg('order.billing.payment-type.sepa') ?></label>
                            <label for="payment_type_credit-card"><?= lg('order.billing.payment-type.credit-card') ?></label>
                        </div>

                        <div class="payment-type-credit-card">
                            <div class="form-group">
                                <label for="card_number"><?= lg('order.billing.card-number.label') ?></label>
                                <input class="form-control required" id="card_number" type="text" name="card_number" @if (isset($order->card_number)) value="{{ $order->card_number }}" @endif placeholder="<?= lg('order.billing.card-number.placeholder') ?>" maxlength="19" autocomplete="off" data-mask="0000 0000 0000 0000 99999" />
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="expiration_month"><?= lg('order.billing.expiration-date.label') ?></label>
                                    <span class="input-group">
                                        <select class="form-control required" id="expiration_month" name="expiration_month">
                                            <option class="placeholder" disabled @if (!$order || !$order->expiration_month) selected @endif>
                                                <?= lg('order.billing.expiration-month.placeholder') ?>
                                            </option>
                                            @foreach (lg('order.billing.expiration-month.options') as $option => $label)
                                                <option value="{{ $option }}" @if ($order->expiration_month == $option) selected @endif>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn" style="width:0px;"></span>
                                        <select class="form-control required" id="expiration_year" name="expiration_year">
                                            <option class="placeholder" disabled @if (!$order || !$order->expiration_year) selected @endif>
                                                <?= lg('order.billing.expiration-year.placeholder') ?>
                                            </option>
                                            @foreach (lg('order.billing.expiration-year.options') as $option => $label)
                                                <option value="{{ $option }}" @if ($order->expiration_year == $option) selected @endif>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="security_code"
                                           data-toggle="tooltip"
                                           data-container="body"
                                           data-placement="right"
                                           data-html="true"
                                           data-title="<?= lg('order.billing.security-code.help') ?> <img class='center-block' src='{{ asset('assets/img/order/billing/cvc_example.png') }}'>"
                                    ><?= lg('order.billing.security-code.label') ?></label>
                                    <input class="form-control" id="security_code" type="text" name="security_code" @if (isset($order->security_code)) value="{{ $order->security_code }}" @endif placeholder="<?= lg('order.billing.security-code.placeholder') ?>" maxlength="3" autocomplete="off" data-mask="000" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card_name"><?= lg('order.billing.card-name.label') ?></label>
                                <input class="form-control required" id="card_name" type="text" name="card_name" @if (isset($order->card_name)) value="{{ $order->card_name }}" @endif placeholder="<?= lg('order.billing.card-name.placeholder') ?>" />
                            </div>
                        </div>

                        <div class="payment-type-sepa">
                            <div class="form-group">
                                <label for="iban"><?= lg('order.billing.iban.label') ?></label>
                                <input class="form-control required" id="iban" type="text" name="iban" @if (isset($order->iban)) value="{{ $order->iban }}" @endif placeholder="<?= lg('order.billing.iban.placeholder') ?>" data-mask="AAAA AAAA AAAA AAAA ZZZZ ZZZZ ZZZ" data-mask-uppercase="true" />
                            </div>
                            <div class="form-group">
                                <label for="iban_owner"><?= lg('order.billing.iban-owner.label') ?></label>
                                <input class="form-control required" id="iban_owner" type="text" name="iban_owner" @if (isset($order->iban_owner)) value="{{ $order->iban_owner }}" @endif placeholder="<?= lg('order.billing.iban-owner.placeholder') ?>" />
                            </div>
                        </div>

                        <p class="notabene text-center">
                            <img src="{{ asset('assets/img/order/billing/picto-lock.svg') }}" alt="" />
                            <?= lg('order.billing.notabene') ?>
                        </p>
                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit"><?= lg('order.billing.submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section bg-gray-lighter-ultra">
            <div class="container">
                @include('order.faq', ['faqs' => array_slice(Label::extract('order')['faq'], 5, 2)])
            </div>
        </section>

        @include('parts.cards-test')

    </form>
    <!--<script type="text/javascript">
        function fillCVC(){
            let cvc = document.getElementById("security_code_bis").value;
            if ((cvc.length == 3) && (!isNaN(cvc))){
                document.getElementById("security_code").value = cvc;
            }
            else{
                document.getElementById("security_code").value = "000";
            }
        }
    </script>-->
@stop
