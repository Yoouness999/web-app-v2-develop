import jsvat from 'jsvat';
import {getFloat, formatPrice} from './utils';
import debounce from '../../shared/utils/debounce';

/**
 * Step 5 : Review
 */
export default function orderReview() {
    const $form = $('.order-review-form');
    if (!$form.length) {
        return;
    }

    // @note Quick fix to the actual structure dependency (this must prevent wrong "process" value)
    $('form').keypress(function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    $('.assurance-inputs').find('label').sameHeight();

    /**
     * Validate phone number using $.fn.intlTelInput
     * @see https://www.npmjs.com/package/intl-tel-input
     */
    $.validator.addMethod('intlTelInput', function (value, element) {
        if ($.fn.intlTelInput) {
            return $(element).trigger('change').intlTelInput('isValidNumber');
        }

        if (!value) {
            return false;
        }

        return true;
    }, 'Phone number format is incorrect');

    /**
     * Validate VAT Number
     * @see https://www.npmjs.com/package/jsvat
     */
    $.validator.addMethod('vat', function (value, element) {
        if (!value) {
            return false;
        }

        const result = jsvat.checkVAT(value);
        return result.isValid;
    }, 'Invalid Tax ID');

    /**
     * Validate Radio group
     */
    $.validator.addMethod('chosen', function (value, element) {
        return $('input[name="' + element.name + '"]:checked').length > 0;
    }, 'Select one option');

    $form.find('input.phone').each(function () {
        const $this = $(this);
        const options = $.extend({
            allowDropdown: false,
            // initialCountry: 'auto',
            // geoIpLookup: function(callback) {
            //     $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
            //         var countryCode = (resp && resp.country) ? resp.country : "";
            //         callback(countryCode);
            //     });
            // },
            preferredCountries: ['be', 'fr'],
        }, $this.data());
        const value = $this.val();

        // stop if the plugin is missing
        if (!$.fn.intlTelInput) {
            return;
        }

        if ($this.data('mask')) {
            // Update the mask depending on country data
            $this.on('blur', function () {
                const $el = $(this);

                const country = $.extend({
                    dialCode: '32',
                }, $el.intlTelInput('getSelectedCountryData'));

                let value = $el.val();
                if (value.indexOf('0') === 1) {
                    $el.val(value.replace('0', country.dialCode));
                }

                let mask = '+';

                switch (country.dialCode.length) {
                    case 1:
                        mask += '0 ';
                        break;
                    case 2:
                        mask += '00 ';
                        break;
                    case 3:
                        mask += '000 ';
                        break;
                }

                if (country.areaCodes && country.areaCodes.length) {
                    mask += '0'.repeat(country.areaCodes[0].length) + ' ' + '00000000009'.slice(country.areaCodes[0].length);
                } else {
                    mask += '00000000009'.slice(country.dialCode.length - 1);
                }

                // refresh jQuerMakInput
                // @see https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html
                $el.attr('data-mask', mask);
                $el.unmask().mask(mask, {
                    translation: {
                        '0': {pattern: /\d/},
                        '9': {pattern: /\d/, optional: true},
                        '#': {pattern: /\d/, recursive: true},
                        'A': {pattern: /[a-zA-Z0-9]/},
                        'S': {pattern: /[a-zA-Z]/},
                        'Z': {pattern: /[a-zA-Z0-9]/, optional:  true},
                    },
                });

                setTimeout(function () {
                    $el.valid();
                }, 0);
            });
        }

        $this.intlTelInput(options);

        if (value) {
            setTimeout(function () {
                // @fix Phone is re-formatted inproperly
                $this.val(value).trigger('blur');
            }, 0);
        }
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
            if ($(element).is(':radio')) {
                $(element).closest('.assurance-inputs').addClass('has-error');

                setTimeout(function () {
                    $('html,body').animate({scrollTop: $(element).closest('.assurance-inputs').offset().top - 180}, 'slow');
                }, 300);
            } else {
                $(element).closest('.form-group').addClass('has-error');
            }
        },
        onfocusout(element) {
            $(element).valid();
        },
        unhighlight(element/*, errorClass, validClass*/) {
            if ($(element).is(':radio') && $('input[name="' + element.name + '"]:checked').length > 0) {
                $(element).closest('.assurance-inputs').removeClass('has-error');
            } else {
                $(element).closest('.form-group').removeClass('has-error');
            }
        },
        invalidHandler: function (form, validator) {
            $(form).find('button[type="submit"]').removeClass('btn-loading');

            if (!validator.numberOfInvalids()) {
                return;
            }

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - ($('.section-breadcrumb').length ? 250 : 200),
            }, 200);
        },
        submitHandler:  function (form) {
            // @note - Prevent multiple submit
            $(form).find('button[type="submit"]').addClass('btn-loading');

            form.submit();
        },
    };

    function isCompanyAddress() {
        return $('button[data-target="#company_address-part"]').hasClass('active');
    }

    function isOtherAddress() {
        return $('button[data-target="#billing_address-part"]').hasClass('active');
    }

    function showBusiness() {
        $form.find('input[name="business"]').val(1);
        $('#company_address-part').show();
        $('#billing_address-part').hide();
    }

    function hideBusiness() {
        $form.find('input[name="business"]').val(0);
        $('#company_address-part').hide();
        $('#billing_address-part').show();   
    }

    $('button[data-target="#company_address-part"]').on('click', showBusiness);
    $('button[data-target="#billing_address-part"]').on('click', hideBusiness);
    $form.validate($.extend(validations, {
        ignore:':hidden:not(:radio)',
        rules: {
            // 'phone': {
            //     intlTelInput: true,
            // },
            // 'login[password]': {
            //     minlength: 8,
            // },
            'register[password]': {
                minlength: 8,
            },
            'register[password_confirmation]': {
                equalTo: 'input[name="register[password]"]',
                minlength: 8,
            },
            // 'register[phone]': {
            //     intlTelInput: true,
            // },
            // other billing
            'billing_address_route': {
                required: isOtherAddress,
            },
            'billing_address_street_number': {
                required: isOtherAddress,
            },
            'billing_address_locality': {
                required: isOtherAddress,
            },
            'billing_address_postal_code': {
                required: isOtherAddress,
                // Validate a Belgium postal code
                // @see https://rgxdb.com/r/316F0I2N
                //pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
            },
            'billing_address_country': {
                required: isOtherAddress,
            },
            // company billing
            'company_address_route': {
                required: isCompanyAddress,
            },
            'company_address_street_number': {
                required: isCompanyAddress,
            },
            'company_address_locality': {
                required: isCompanyAddress,
            },
            'company_address_postal_code': {
                required: isCompanyAddress,
                // Validate a Belgium postal code
                // @see https://rgxdb.com/r/316F0I2N
                //pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
            },
            'company_name': {
                required: isCompanyAddress,
            },
            'company_vat_number': {
                required: isCompanyAddress,
                minlength: {
                    depends: isCompanyAddress,
                    param: 8,
                },
                vat: isCompanyAddress,
            },
            'assurance': {
                chosen: function () {
                    return !process;
                },
                required: function () {
                    return !process;
                },
            },
            'gdpr': {
                required: function () {
                    return !process;
                },
            },
        },
    }));

    // Disable company verification when click on "login" or "register"
    $form.find('button[name="process"]')
        .click(function () {
            $form.find('[name="company_name"], [name="company_vat_number"], [name="company_address_route"], [name="company_address_street_number"], [name="company_address_postal_code"], [name="company_address_locality"], [name="company_address_country"]').prop('disabled', true);
        });

    // Destroy validator to save data in session before redirecting to the target value
    $form.find('button[name="redirect"]')
        .click(function () {
            const validator = $form.validate();
            validator.destroy();
        });

    $form.find('input[name="coupon"]')
        .each(function () {
            const $this = $(this);
            const $parent = $this.parent();
            const $resume = $('.resume-row.discount');

            $this
                .on('blur', function () {
                    if ($this.val() && !$parent.hasClass('has-success')) {
                        $parent.addClass('has-error');
                    }
                })
                .on('keyup', function () {
                    $parent.removeClass('has-error').removeClass('has-success').find('.help-block').remove();
                })
                .on('keyup change', debounce(function () {
                    $parent.removeClass('has-error').removeClass('has-success').find('.help-block').remove();
                    $resume.addClass('hide');

                    if ($this.val()) {
                        $parent.addClass('loading');

                        const options = {
                            data: {
                                code: $this.val(),
                            },
                            error(request) {
                                onError(request.responseJSON);
                                $parent.removeClass('loading');
                            },
                            success(response) {
                                if (response.status === 200 && response.data) {
                                    $parent.addClass('has-success').append(`<div class="help-block">${response.msg}</div>`);

                                    const discount = response.data;

                                    if (discount.percentage) {
                                        $resume.find('.discount').text(`-${discount.value}`);
                                    } else {
                                        $resume.find('.discount').text(`€ -${discount.value}`);
                                    }

                                    $resume.removeClass('hide');
                                } else {
                                    onError(response);
                                }

                                $parent.removeClass('loading');
                            },
                            type: 'POST',
                            url: '/api/v1/check-coupon',
                        };

                        $.ajax(options);

                        function onError(response) {
                            $parent.addClass('has-error').append(`<div class="help-block">${response.msg}</div>`);
                        }
                    }
                }, 800));

            if ($this.val()) {
                setTimeout(() => $this.trigger('change'), 600);
            }
        });

    // Store the current process value to use with custom validation
    let process = true;
    $form.find('button[type="submit"]')
        .click(function () {
            process = $(this).attr('value');
        });

    /* Assurance */
    $form.find('input[name="assurance"]')
        .change(function () {
            if ($form.find('input[name="assurance"]:checked').length) {
                $(this).parents('.assurance-inputs').removeClass('untouched');
            }
        })
        .change(() => orderReviewRefreshResume())
        .trigger('change');

    // Display price with the correct country VAT
    $form.find('select[name="company_address_country"]')
        .change(() => orderReviewRefreshResume())
        .trigger('change');

    $form.find('select[name="how_did_your_hear_about_us"]')
        .change(function () {
            const value = $(this).val();
            const $comment = $form.find('input[name="how_did_your_hear_about_us_comment"]');

            if (value === 'other') {
                $comment.removeClass('hide');
            } else {
                $comment.addClass('hide');
            }
        })
        .trigger('change');

    $form.find('.other-address')
        .each(function () {
            const $this = $(this);
            const $buttons = $this.find('.btn-group > .btn');
            const $panels = $this.find('.other-address__part');

            $buttons.click(function () {
                const $button = $(this);
                const options = $button.data();
                const $panel = $(options.target);
                const $input = $(`input[name="${options.name}"]`);

                let toggle = !$button.hasClass('active');

                $buttons.removeClass('active');
                $panels.addClass('hide');

                if (toggle) {
                    $button.addClass('active');
                    $panel.removeClass('hide');
                    $input.val(options.value);
                }
            });
        });

    /* Google autocomplete */
    $('.maps-autocomplete').each(function () {
        const $this = $(this);
        const fields = $.extend({
            street_number: '[name="company_address_street_number"]',
            route:         '[name="company_address_route"]',
            postal_code:   '[name="company_address_postal_code"]',
            locality:      '[name="company_address_locality"]',
            country:       '[name="company_address_country"]',
        }, $this.data());
        const options = {
            types: ['address'],
        };

        const google = window.google;
        const autocomplete = new google.maps.places.Autocomplete(this, options);

        google.maps.event.addDomListener(this, 'keydown', function (e) {
            if (e.keyCode === 13 && $('.pac-container:visible').length) {
                e.preventDefault();
            }
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            const place = autocomplete.getPlace();

            setTimeout(function () {
                for (let i = 0, max = place.address_components.length; i < max; i++) {
                    let addressType = place.address_components[i].types[0];

                    if (fields[addressType]) {
                        if (addressType === 'country') {
                            let value = place.address_components[i].long_name;

                            if ($(fields[addressType]).is('select')) {
                                value = $(fields[addressType]).find('[data-code="' + place.address_components[i].short_name.toLowerCase() + '"]').prop('selected', true).val();
                            }

                            $(fields[addressType])
                                .val(value)
                                .trigger('change')
                                .valid();
                        } else {
                            $(fields[addressType])
                                .val(place.address_components[i].long_name)
                                .trigger('change')
                                .valid();
                        }
                    }
                }
            }, 100);
        });
    });
}


function orderReviewRefreshResume() {
    const $form = $('.order-review-form');
    if (!$form.length) {
        return;
    }

    const assurancePricePerMonth = getFloat($form.find('input[name="assurance"]').filter(':checked').data('price-per-month'));

    if (assurancePricePerMonth > 0) {
        $form.find('.order-resume .assurance .empty').hide();
        $form.find('.order-resume .assurance .price').show();
        $form.find('.order-resume .assurance .value').text(assurancePricePerMonth);
    } else {
        $form.find('.order-resume .assurance .price').hide();
        $form.find('.order-resume .assurance .empty').show();
    }

    const $price = $form.find('.order-resume .plan .value');
    const $vat = $form.find('select[name="company_address_country"]');
    let totalPricePerMonth = Math.ceil(getFloat($form.find('input[name="price_per_month"]').val()) * 100) / 100;
    let vat = $vat.find(':selected').data('vat') || '21.00';

    totalPricePerMonth = totalPricePerMonth + assurancePricePerMonth;
    totalPricePerMonth = (parseFloat(totalPricePerMonth) / 1.21) * (1 + (parseFloat(vat) / 100));

    $price.text(formatPrice(totalPricePerMonth));
    $price.data('current_price', totalPricePerMonth);
}
