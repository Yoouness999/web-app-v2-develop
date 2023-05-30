import {$, debug} from '../bootstrap';

export default {
    load() {
        debug.bench('billing:load');

        $('#card_number').on('keyup', function () {
            $(this).val(function (index, value) {
                value = value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');

                if (value.charAt(value.length - 1) === ' ') {
                    return value.slice(0, -1);
                }

                return value;
            });

            $('.card-type').removeClass('selected');
            $('.card-type.' + getCardType($(this).val())).addClass('selected');
        });

        $('.users-billing-form').submit(function () {
            $('.card-encryption-error').addClass('hidden');

            if ($('#payment_type_credit-card').is(':checked')) {
                const result = getAdyenCardValidation({
                    key:    $('#adyen_client_encryption_public_key').val(),
                    number: $('#card_number').val(),
                    cvc:    $('#card_cvv').val(),
                    month:  $('[name="card_expiration_month"]').val(),
                    year:   $('[name="card_expiration_year"]').val()
                });

                if (!result.valid) {
                    $('.card-encryption-error').removeClass('hidden');
                    return false;
                }

                /* Encrypt payment data for adyen */
                const postData = getAdyenCardEncryptedJson({
                    key:            $('#adyen_client_encryption_public_key').val(),
                    number:         $('#card_number').val(),
                    cvc:            $('#card_cvv').val(),
                    holderName:     $('#cardholder').val(),
                    expiryMonth:    $('[name="card_expiration_month"]').val(),
                    expiryYear:     $('[name="card_expiration_year"]').val(),
                    generationtime: $('#adyen_generationtime').val()
                });

                console.log('pay');
                console.log(postData);

                $('[name="adyen_card_encrypted_json"]').val(postData);
            }

            return true;
        });
    },
};


function getCardType(number) {
    // visa
    let re = new RegExp("^4");
    if (number.match(re) !== null) {
        return "visa";
    }

    // Mastercard
    re = new RegExp("^5[1-5]");
    if (number.match(re) !== null) {
        return "mastercard";
    }

    return 'other';
}

/* Adyen */

function getAdyenCardValidation(args) {
    const adyen = window.adyen;
    const options = {};

    const cseInstance = adyen.encrypt.createEncryption(args.key, options);

    return cseInstance.validate({
        number: args.number,
        cvc:    args.cvc,
        month:  args.month,
        year:   args.year
    });
}

function getAdyenCardEncryptedJson(args) {
    const adyen = window.adyen;
    const options = {};

    const cseInstance = adyen.encrypt.createEncryption(args.key, options);

    const postData = {
        'adyen-encrypted-data': cseInstance.encrypt({
            number:         args.number,
            cvc:            args.cvc,
            holderName:     args.holderName,
            expiryMonth:    args.expiryMonth,
            expiryYear:     args.expiryYear,
            generationtime: args.generationtime,
        })
    };

    return JSON.stringify(postData);
}