@extends('layouts.profile')

<?php
/**
 * @var $user \App\User
 */

if ($defaultPayment) {
    $body['attributes']['class'] .= ' locked';
}
?>

@section('footer')
    @parent

    @if ($defaultPayment)
        <div class="notification notification--danger">
            <div class="container">
                <div class="notification__title">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <?= lg('account.notification.title') ?>
                </div>
                <div class="notification__description">
                    <?= lg('account.notification.description') ?>
                </div>
            </div>
        </div>
    @endif
@stop



@section('js')
    @parent

    @if ($userNotActive)
		@if ($lastOrderConfirmed)
			<div class="modal fade" id="modal-verification" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<img class="center-block" src="<?= asset(lg('account.modal.image')) ?>" alt="<?= lg('account.modal.title') ?>">

							<h4><?= lg('account.modal.title') ?></h4>

							<p><?= lg('account.modal.description') ?></p>

							<form action="/profile/validation" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<button class="btn btn-primary" type="submit">
									<?= lg('account.modal.send_validation') ?>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<script>
				jQuery(document).ready(function () {
					jQuery('#modal-verification').modal('show');
				});
			</script>
		@endif
    @endif
@stop


@section('subcontent')
    @include('parts.cards-test')

    <section class="section section--account">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__header">
                    <h1><?= lg('account.title') ?></h1>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><?= $error ?></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($successMessage)
                    <div class="alert alert-success">
                        <?= $successMessage ?>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8">

                        <ul class="profile-nav">
                            <li class="active">
                                <a href="#informations" data-toggle="tab">
                                    <?= lg('account.tabs.informations') ?>
                                </a>
                            </li>
                            <li>
                                <a href="#billing" data-toggle="tab">
                                    <?= lg('account.tabs.billing') ?>
                                </a>
                            </li>
                            <li>
                                <a href="#invoice" data-toggle="tab">
                                    <?= lg('account.tabs.invoice') ?>
                                </a>
                            </li>
                            <li>
                                <a href="#password" data-toggle="tab">
                                    <?= lg('account.tabs.password') ?>
                                </a>
                            </li>
                        </ul>


                        <div class="divider divider--hidden divider--x2" aria-hidden="true"></div>

                        <div class="tab-content">
                            <div class="tab-pane active" id="informations">
                                <form class="form-horizontal" action="" method="post" autocomplete="off">
                                    <input type="hidden" name="form_name" value="informations">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <label for="first_name" class="col-sm-4"><?= lg('account.informations.first_name.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="first_name" type="text" name="first_name" value="{{ $user->first_name }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name" class="col-sm-4"><?= lg('account.informations.last_name.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="last_name" type="text" name="last_name" value="{{ $user->last_name }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="col-sm-4"><?= lg('account.informations.phone.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control required phone" id="phone" type="text" name="phone" placeholder="<?= lg('account.informations.phone.placeholder') ?>" value="{{ $user->phone }}" data-mask="+00 0000000009">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-4"><?= lg('account.informations.email.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="email" type="email" name="email" placeholder="<?= lg('account.informations.email.placeholder') ?>" value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-4"><?= lg('account.informations.address') ?></label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="form-group col-md-7">
                                                    <input class="form-control required maps-autocomplete" id="address" type="text" name="address_route" placeholder="<?= lg('account.informations.route.placeholder') ?>" value="{{ $user->street }}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control required" type="text" name="address_street_number" placeholder="<?= lg('account.informations.street_number.placeholder') ?>" value="{{ $user->number }}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" type="text" name="address_box" placeholder="<?= lg('account.informations.box.placeholder') ?>" value="{{ $user->box }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <input class="form-control required" type="text" name="address_postal_code" placeholder="<?= lg('account.informations.postal_code.placeholder') ?>" value="{{ $user->postalcode }}">
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <input class="form-control required" type="text" name="address_locality" placeholder="<?= lg('account.informations.locality.placeholder') ?>" value="{{ $user->city }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <input class="form-control required" type="text" name="country" placeholder="<?= lg('account.informations.country.placeholder') ?>" value="{{ $user->country }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="divider divider--hidden" aria-hidden="true"></div>

                                    <div class="other-address">
                                        <input type="hidden" name="business" value="<?= !isset($user->business) || $user->business == 0 ? 0 : 1 ?>">

                                        <div class="text-center">
                                            <div class="btn-group">
                                                <button class="btn<?= $user->business == 0 ? ' active' : '' ?>" type="button" data-target="#billing_address-part" data-name="business" data-value="0">
                                                    <?= lg('account.informations.is_billing_address') ?>
                                                </button>
                                                <button class="btn<?= $user->business == 1 ? ' active' : '' ?>" type="button" data-target="#company_address-part" data-name="business" data-value="1">
                                                    <?= lg('account.informations.is_company_address') ?>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="divider divider--hidden" aria-hidden="true"></div>

                                        <div class="other-address__part<?= !isset($user->business) || $user->business != 0 ? ' hide' : '' ?>" id="billing_address-part">
                                            <div class="form-group">
                                                <label for="address" class="col-sm-4"><?= lg('account.informations.billing_address') ?></label>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <input class="form-control maps-autocomplete" type="text" name="billing_street" placeholder="<?= lg('account.informations.route.placeholder') ?>" value="{{ $user->billing_street }}"
                                                                   data-street_number="[name='billing_number']"
                                                                   data-route="[name='billing_street']"
                                                                   data-postal_code="[name='billing_postalcode']"
                                                                   data-locality="[name='billing_city']"
                                                                   data-country="[name='billing_country']"
                                                            >
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <input class="form-control" type="text" name="billing_number" placeholder="<?= lg('account.informations.street_number.placeholder') ?>" value="{{ $user->billing_number }}">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <input class="form-control" type="text" name="billing_box" placeholder="<?= lg('account.informations.box.placeholder') ?>" value="{{ $user->billing_box }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" type="text" name="billing_postalcode" placeholder="<?= lg('account.informations.postal_code.placeholder') ?>" value="{{ $user->billing_postalcode }}">
                                                        </div>
                                                        <div class="form-group col-md-8">
                                                            <input class="form-control" type="text" name="billing_city" placeholder="<?= lg('account.informations.locality.placeholder') ?>" value="{{ $user->billing_city }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <input class="form-control" type="text" name="billing_country" placeholder="<?= lg('account.informations.country.placeholder') ?>" value="{{ $user->billing_country }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="other-address__part<?= !isset($user->business) || $user->business != 1 ? ' hide' : '' ?>" id="company_address-part">
                                            <div class="form-group">
                                                <label for="company_name" class="col-sm-4"><?= lg('account.informations.company_name.label') ?></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="company_name" placeholder="<?= lg('account.informations.company_name.placeholder') ?>" value="{{ $user->company_name }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="company_vat_number" class="col-sm-4"><?= lg('account.informations.company_vat.label') ?></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="company_vat_number" placeholder="<?= lg('account.informations.company_vat.placeholder') ?>" value="{{ $user->company_vat_number }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="address" class="col-sm-4"><?= lg('account.informations.company_address') ?></label>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <input class="form-control maps-autocomplete" type="text" name="company_address_route" placeholder="<?= lg('account.informations.route.placeholder') ?>" value="{{ $user->company_address_route }}"
                                                                data-street_number="[name='company_address_street_number']"
                                                                data-route="[name='company_address_route']"
                                                                data-postal_code="[name='company_address_postal_code']"
                                                                data-locality="[name='company_address_locality']"
                                                                data-country="[name='company_address_country']"
                                                            >
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <input class="form-control" type="text" name="company_address_street_number" placeholder="<?= lg('account.informations.street_number.placeholder') ?>" value="{{ $user->company_address_street_number }}">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <input class="form-control" type="text" name="company_address_box" placeholder="<?= lg('account.informations.box.placeholder') ?>" value="{{ $user->company_address_box }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" type="text" name="company_address_postal_code" placeholder="<?= lg('account.informations.postal_code.placeholder') ?>" value="{{ $user->company_address_postal_code }}">
                                                        </div>
                                                        <div class="form-group col-md-8">
                                                            <input class="form-control" type="text" name="company_address_locality" placeholder="<?= lg('account.informations.locality.placeholder') ?>" value="{{ $user->company_address_locality }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <select class="form-control" name="company_address_country">
                                                                <option class="placeholder" disabled @if (!$user->company_address_country) selected @endif>
                                                                    <?= lg('account.informations.country.placeholder') ?>
                                                                </option>
                                                                @foreach ($countries as $option => $label)
                                                                    <option value="{{ $label['slug'] }}" data-code="{{ strtolower($label['slug']) }}" data-vat="{{ $label['tax'] }}" @if ($user->company_address_country == $label['slug']) selected @endif>
                                                                        {{ $label['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="divider divider--hidden" aria-hidden="true"></div>

                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            <?= lg('account.informations.submit') ?>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="billing">
                                <fieldset>
                                    <legend><?= lg('account.billing.infos.title') ?></legend>
                                    @if($balance)
                                        <dl class="dl-horizontal">
                                            <dt><?= lg('account.billing.infos.next_billing') ?></dt>
                                            <dd><?= date('d/m/Y', strtotime('first day of next month')) ?></dd>

                                            <dt><?= lg('account.billing.infos.next_billing_balance') ?></dt>
                                            <dd><?= $balance ?>€</dd>
                                        </dl>
                                    @else
                                        <p><?= lg('account.billing.infos.no_infos') ?></p>
                                    @endif
                                </fieldset>

                                <fieldset>
                                    <legend><?= lg('account.billing.form.title') ?></legend>

                                    <div class="row">
                                        <div class="col-sm-8">

                                            <form class="users-billing-form" action="" method="post" ng-submit="submitForm(userForm.$valid)" novalidate>
                                                <input type="hidden" name="form_name" value="billing">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="adyen_client_encryption_public_key" value="{{ Config::get('adyen.client_encryption_public_key') }}">
                                                <input type="hidden" id="adyen_generationtime" value="{{ date('c') }}">
                                                <input type="hidden" name="adyen_card_encrypted_json">
                                                <input type="hidden" name="card_number_part">

                                                @if($user)
                                                    @if ($user && $user->billing_card || $user->billing_iban)
                                                        <input type="hidden" name="keep_payment">
                                                    @endif
                                                @endif

                                                <input type="radio" name="payment_type" id="payment_type_sepa" value="sepa"
                                                    @if($user->isIban())
                                                        checked="checked"
                                                    @endif
                                                >
                                                <input type="radio" name="payment_type" id="payment_type_credit-card" value="credit_card"
                                                    @if(!$user->isIban())
                                                        checked="checked"
                                                    @endif
                                                >

                                                @if (session('error'))
                                                    <div class="alert alert-danger">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif

                                                <div class="label-payment-type">
                                                    <label for="payment_type_sepa"><?= lg('common.payment-type-sepa') ?></label>
                                                    <label for="payment_type_credit-card"><?= lg('common.payment-type-credit-card') ?></label>
                                                </div>

                                                <div class="payment-type-sepa">
                                                    <div class="form-group">
                                                        <label for="iban"><?= lg('common.iban') ?></label>
                                                        <input class="form-control required" id="iban" type="text" name="iban" value="{{ $paymentInfo['iban'] }}" placeholder="<?= lg('common.iban') ?>" data-mask="AAAA AAAA AAAA AAAA ZZZZ ZZZZ ZZZ" data-mask-uppercase="true" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="iban_owner"><?= lg('common.iban-owner-name') ?></label>
                                                        <input class="form-control required" id="iban_owner" type="text" name="iban_owner" value="{{ $paymentInfo['iban_owner'] }}" placeholder="<?= lg('common.iban-owner-name') ?>" />
                                                    </div>
                                                </div>

                                                <div class="payment-type-credit-card">
                                                    <div class="form-group">
                                                        <label for="card_number"><?= lg('common.Card number') ?></label>
                                                        <input class="form-control required" id="card_number" type="text" name="card_number" value="<?= e($paymentInfo['card_number']); ?>" placeholder="<?= lg('common.Card number') ?>" maxlength="19" autocomplete="off" data-mask="0000 0000 0000 0000 999" data-old-value="<?= e($paymentInfo['card_number']); ?>" />
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="expiration_month"><?= lg('common.Expiration') ?></label>
                                                            <span class="input-group">
                                                                <select class="form-control required" id="expiration_month" name="expiration_month" data-old-value="<?= e($paymentInfo['card_expiration_month']); ?>">
                                                                    <option class="placeholder" disabled @if (!$paymentInfo['card_expiration_month']) selected @endif>
                                                                        <?= lg('order.billing.expiration-month.placeholder') ?>
                                                                    </option>
                                                                    @foreach (lg('order.billing.expiration-month.options') as $option => $label)
                                                                        <option value="{{ $option }}" @if ($paymentInfo['card_expiration_month'] == $option) selected @endif>
                                                                            {{ $label }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="input-group-btn" style="width:0px;"></span>
                                                                <select class="form-control required" id="expiration_year" name="expiration_year" data-old-value="<?= e($paymentInfo['card_expiration_year']); ?>">
                                                                    <option class="placeholder" disabled @if (!$paymentInfo['card_expiration_year']) selected @endif>
                                                                        <?= lg('order.billing.expiration-year.placeholder') ?>
                                                                    </option>
                                                                    @foreach (lg('order.billing.expiration-year.options') as $option => $label)
                                                                        <option value="{{ $option }}" @if ($paymentInfo['card_expiration_year'] == $option) selected @endif>
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
                                                            <input class="form-control required" id="security_code" type="text" name="security_code" placeholder="<?= lg('order.billing.security-code.placeholder') ?>" maxlength="3" autocomplete="off" data-mask="000" data-old-value="" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="card_name"><?= lg('common.Cardholder name') ?></label>
                                                        <input class="form-control required" id="card_name" type="text" name="card_name" @if ($paymentInfo['card_name']) value="{{ $paymentInfo['card_name'] }}" @endif placeholder="<?= lg('common.Cardholder name') ?>" />
                                                    </div>
                                                </div>

                                                <p class="notabene text-center">
                                                    <img src="{{ asset('assets/img/order/billing/picto-lock.svg') }}" alt="" />
                                                    <?= lg('order.billing.notabene') ?>
                                                </p>

                                                <div class="form-group text-center">
                                                    <button class="btn btn-primary" type="submit">
                                                        <?= lg("common.Submit") ?>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </fieldset>

                            </div>

                            <div class="tab-pane" id="invoice">
                                @if(!count($invoices))
                                    <?= lg("You don't have any invoice") ?>
                                @else
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?= lg('account.invoice.table.ref') ?></th>
                                                <th><?= lg('account.invoice.table.date') ?></th>
                                                <th><?= lg('account.invoice.table.amount') ?></th>
                                                <th><?= lg('account.invoice.table.status') ?></th>
                                                <th><?= lg('account.invoice.table.download') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoices as $invoice)
                                                <tr>
                                                    <td><?= $invoice['id'] ?></td>
                                                    <td><?= $invoice['date'] ?></td>
                                                    <td><?= $invoice['amount'] ?><?= $invoice['devise'] ?></td>
                                                    <td>
                                                        <span class="status-<?= $invoice['status'] ?>">
                                                            <?= lg('account.invoice.statuses.' . $invoice['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-link" href="<?= $invoice['invoice_url'] ?>" target="_blank">
                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="tab-pane" id="password">
                                <form class="form-horizontal" action="" method="post">
                                    <input type="hidden" name="form_name" value="password">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <label for="password_current" class="col-sm-4"><?= lg('account.password.current_password.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="password_current" type="password" name="password_current" value="" placeholder="<?= lg('account.password.current_password.placeholder') ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-4"><?= lg('account.password.new_password.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="password" type="password" name="password" value="" placeholder="<?= lg('account.password.new_password.placeholder') ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirm" class="col-sm-4"><?= lg('account.password.confirm_password.label') ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="password_confirm" type="password" name="password_confirmation" value="" placeholder="<?= lg('account.password.confirm_password.placeholder') ?>" required>
                                        </div>
                                    </div>

                                    <div class="divider divider--hidden" aria-hidden="true"></div>

                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            <?= lg('account.password.submit') ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (App::getLocale() == 'fr') {
        $lang = 'fr';
    } else {
        $lang = 'en-US';
    }
    ?>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=places&language=<?= $lang; ?>&key=AIzaSyCIjc3NxG65UPljS1GZXAl83XyZWf1HGKg"></script>
@stop

@section('footer')
    @parent
@stop
