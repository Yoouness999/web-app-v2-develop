@extends('layouts.profile')
<?php
/**
 * @see \App\Http\Controllers\Profile\ProfileController::getAccount();
 *
 */
?>

@section('subcontent')
    <h2 class="h4"><?= lg("common.Current Billing Information") ?></h2>
    <hr>

    @if($error)
        <div class="alert alert-danger"><?= $error; ?></div>
    @endif

    @if($user->hasBillingInfo())
        <p><strong><?= lg("common.Next billing") ?></strong> : <?= date('d/m/Y', strtotime('first day of next month')); ?></p>
        <p><strong><?= lg("common.Next billing balance") ?></strong> : <?= $balance; ?>€</p>
    @else
        <p><?= lg("common.You don't have any payment information") ?></p>
    @endif
    <br>

    <h2 class="h4"><?= lg("common.Update your payment method") ?></h2>
    <hr>

	<form action="#" class="form-horizontal users-billing-form" method="post" ng-submit="submitForm(userForm.$valid)" novalidate>
		<input type="hidden" id="adyen_client_encryption_public_key" value="{{ Config::get('adyen.client_encryption_public_key') }}" />
		<input type="hidden" id="adyen_generationtime" value="{{ date('c') }}" />
		<input type="hidden" name="adyen_card_encrypted_json" />
		<input type="radio" name="payment_type" id="payment_type_credit-card" value="credit_card" checked="checked" />
		<input type="radio" name="payment_type" id="payment_type_sepa" value="sepa" />

		<div class="label-payment-type">
			<label for="payment_type_credit-card"><?= lg('common.payment-type-credit-card') ?></label>
			<label for="payment_type_sepa"><?= lg('common.payment-type-sepa') ?></label>
		</div>

		<div class="payment-type-credit-card">
			<div class="alert alert-danger card-encryption-error hidden">
				<?= lg('common.card-encryption-error') ?>
			</div>
			<div class="form-group">
				<label for="cardholder" class="col-sm-12 col-md-4"><?= lg("common.Cardholder name") ?></label>
				<div class="col-md-8">
					<input type="text" class="form-control required" name="card_name" id="cardholder" value="<?= e($paymentInfo['card_name']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="card_number" class="col-md-4"><?= lg("common.Card number") ?></label>
				<div class="col-md-5">
					<input type="text" class="form-control" name="card_number" id="card_number"
						   value="<?= e($paymentInfo['card_number']); ?>" maxlength="19">
				</div>
				<div class="col-md-3">
					<img class="card-type visa" src="/assets/img/card-type-visa.png" alt="VISA" />
					<img class="card-type mastercard" src="/assets/img/card-type-mastercard.png" alt="MASTERCARD" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 col-lg-4"><?= lg("common.Expiration") ?></label>
				<div class="col-sm-6 col-lg-2">
					<input type="text" class="form-control" name="card_expiration_month" placeholder="MM" value="<?= e($paymentInfo['card_expiration_month']); ?>" maxlength="2" />
				</div>
				<div class="col-sm-6 col-lg-2">

					<input type="text" class="form-control" name="card_expiration_year" placeholder="YYYY" value="<?= e($paymentInfo['card_expiration_year']); ?>" maxlength="4">
				</div>
				<label for="expiration" class="col-lg-2 text-right"><?= lg("common.CVV") ?></label>
				<div class="col-lg-2">
					<input type="text" class="form-control" name="card_cvv" id="expiration" value="" placeholder="___" maxlength="3">
				</div>
			</div>
		</div>

		<div class="payment-type-sepa">
			<div class="form-group">
				<label for="iban" class="col-sm-12 col-md-4"><?= lg('common.iban') ?></label>
				<div class="col-md-8">
					<input type="text" class="form-control required" name="iban" id="iban" value="{{ $paymentInfo['iban'] }}" />
				</div>
			</div>
			<div class="form-group">
				<label for="iban_owner" class="col-sm-12 col-md-4"><?= lg('common.iban-owner-name') ?></label>
				<div class="col-md-8">
					<input type="text" class="form-control required" name="iban_owner" id="iban_owner" value="{{ $paymentInfo['iban_owner'] }}" />
				</div>
			</div>
		</div>

		<hr>

		<button class="btn btn-primary" type="submit"><?= lg("common.Submit") ?></button>

	</form>
@stop
