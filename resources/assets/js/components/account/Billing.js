import {getAdyenCardValidation, getAdyenCardEncryptedJson} from "../order/utils";

export default function profileBilling() {
    const $form = $('#billing form');
    if (!$form.length) {
        return;
    }

    // @see https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html
    $('input[data-mask], textarea[data-mask]').each(function () {
        const $this = $(this);
        const options = {
            translation: {
                '0': {pattern: /\d|\*/},
                '9': {pattern: /\d/, optional: true},
                '#': {pattern: /\d/, recursive: true},
                'A': {pattern: /[a-zA-Z0-9]/},
                'S': {pattern: /[a-zA-Z]/},
                'Z': {pattern: /[a-zA-Z0-9]/, optional:  true},
            },
        };

        // @note jQueryMaskPlugin override .data('mask') so we use the attr('data-mask') value
        const mask = $this.attr('data-mask');

        if ($this.data('maskUppercase')) {
            options.onKeyPress = function (value, e) {
                e.currentTarget.value = value.toUpperCase();
            };
        }

        $this.unmask().mask(mask, options);

        setTimeout(function () {
            $this.val($this.attr('value'));
        }, 0);
    });

    // @see http://jqueryvalidation.org
    let validations = {
        focusInvalid: false,
        errorPlacement: function (error, element) {
            /*if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }*/
        },
        highlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').addClass('has-error');
        },
        onfocusout(element) {
            $(element).valid();
        },
        unhighlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        invalidHandler: function (form, validator) {
            if (!validator.numberOfInvalids()) {
                return;
            }

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 250,
            }, 200);
        },
        submitHandler:  function (form) {
            form.submit();
        },
    };

    /**
     * Check if given date is "in the futur" from the current date (= now).
     * This validation is specific to this form and depend to #expiration_month and #expiration_year
     */
    $.validator.addMethod('inthefutur', function (value, element) {
        let expiryMonth, expiryYear;

        if (element.name === 'expiration_month') {
            expiryMonth = value;
            expiryYear = $('#expiration_year').val();
        } else if (element.name === 'expiration_year') {
            expiryMonth = $('#expiration_month').val();
            expiryYear = value;
        }

        const date = new Date('20' + expiryYear, expiryMonth);
        const now = new Date();

        return date > now;
    }, $.validator.messages.date);

    /**
     * Check billing informations for Adyen
     */
    $.validator.addMethod('adyen', function (value, element) {
        if ($('#card_number').val().indexOf('*') > -1) {
            return true;
        }

        const $el = $(element);
        const name = $el.attr('name');
        const expiryMonth = $('#expiration_month').val();
        const expiryYear = $('#expiration_year').val();
        const result = getAdyenCardValidation({
            key:    $('#adyen_client_encryption_public_key').val(),
            number: $('#card_number').val(),
            cvc:    $('#security_code').val(),
            month:  expiryMonth,
            year:   '20' + expiryYear,
        });

        if (name === 'card_number') {
            return result.number && result.luhn;
        }

        if (name === 'expiration_month' || name === 'expiration_year') {
            return result.month && result.year && result.expiryMonth && result.expiryYear;
        }

        if (name === 'security_code') {
            return result.cvc;
        }

        return result.valid;
    }, $.validator.messages.remote);

    $form.validate($.extend(validations, {
        rules:         {
            'iban': {
                minlength: 16,
                iban: true,
            },
            'card_number':     {
                minlength: 16,
                adyen:     true,
            },
            'expiration_month': {
                inthefutur: function () {
                    return $('input[name="card_number"]').val().indexOf('*') === -1;
                },
                adyen:     true,
            },
            'expiration_year': {
                inthefutur: function () {
                    return $('input[name="card_number"]').val().indexOf('*') === -1;
                },
                adyen:     true,
            },
            'security_code':   {
                minlength: 3,
                adyen:     true,
            },
        },
        submitHandler: function (form) {
            if ($('#payment_type_credit-card').is(':checked')) {
                $('#error-adyen').remove();

                if (
					$('input[name="card_number"]').val() == $('input[name="card_number"]').data('old-value')
					&& $('input[name="expiration_month"]').val() == $('input[expiration_month="card_number"]').data('old-value')
					&& $('input[name="expiration_year"]').val() == $('input[name="expiration_year"]').data('old-value')
					&& $('input[name="security_code"]').val() == $('input[name="security_code"]').data('old-value')
				) {
                    $('input[name="keep_payment"]').val(true);
                } else {
                    const expiryMonth = $('#expiration_month').val();
                    const expiryYear = $('#expiration_year').val();

                    /* Encrypt payment data for adyen */
                    const postData = getAdyenCardEncryptedJson({
                        key:            $('#adyen_client_encryption_public_key').val(),
                        number:         $('#card_number').val(),
                        cvc:            $('#security_code').val(),
                        holderName:     $('#card_name').val(),
                        expiryMonth,
                        expiryYear:     '20' + expiryYear,
                        generationtime: $('#adyen_generationtime').val(),
                    });

                    if (postData) {
                        $('input[name="adyen_card_encrypted_json"]').val(postData);
                    } else {
                        $('input[name="adyen_card_encrypted_json"]').after(`<div class="alert alert-danger" id="error-adyen">${config.labels.adyen_error}</div>`);
                    }
                }

                /* Keep last part of payment data */
                const card_number = $('#card_number').val();
                $('[name="card_number_part"]').val(card_number.substr(card_number.length - 4, 4));

                $('#card_number/*, #security_code, #expiration_month, #expiration_year, #card_name*/').prop('disabled', true);
            }

            form.submit();
        },
    }));
}