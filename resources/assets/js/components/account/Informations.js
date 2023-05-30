import jsvat from "jsvat";
import {config} from "../../bootstrap";


export default function profileInformations() {
    const $form = $('#informations form');
    if (!$form.length) {
        return;
    }

    if (config.locked && config.locked === 'informations') {
        $(`.tab-pane#${config.locked}`).find('button, input, select, textarea').addClass('disabled').prop('disabled', true);
        $(`.tab-pane#${config.locked}`).find('a').addClass('disabled');
    }

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

    // @see http://jqueryvalidation.org
    let validations = {
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
            if ($(element).is(':input')) {
                $(element).valid();
            }
        },
        unhighlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        submitHandler:  function (form) {
            form.submit();
        },
    };

    function isCompanyAddress() {
        return $('button[data-target="#company_address-part"]').hasClass('active');
    }

    function isOtherAddress() {
        return $('button[data-target="#billing_address-part"]').hasClass('active');
    }

    $form.validate($.extend(validations, {
        rules: {
            'phone': {
                intlTelInput: true,
            },
            'address_postal_code': {
                // Validate a Belgium postal code
                // @see https://rgxdb.com/r/316F0I2N
                pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
            },
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
                pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
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
                pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
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
        },
    }));

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
            });

            setTimeout(function () {
                $this.valid();
            }, 0);
        }

        $this.intlTelInput(options);

        setTimeout(function () {
            // @fix Phone is re-formatted inproperly
            $this.val(value).trigger('blur');
        }, 0);
    });

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
            street_number: '[name="address_street_number"]',
            route:         '[name="address_route"]',
            postal_code:   '[name="address_postal_code"]',
            locality:      '[name="address_locality"]',
            country:       '[name="address_country"]',
        }, $this.data());

        const google = window.google;
        const autocomplete = new google.maps.places.Autocomplete(this, {types: ['address']});

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
                    let value = place.address_components[i].long_name;

                    if (addressType === 'country') {
                        if ($(fields[addressType]).is('select')) {
                            value = $(fields[addressType]).find('[data-code="' + place.address_components[i].short_name.toLowerCase() + '"]').prop('selected', true).val();
                        }
                    }

                    if ($(fields[addressType]).length) {
                        $(fields[addressType]).val(value).trigger('change');

                        setTimeout(function () {
                            $(fields[addressType]).valid();
                        }, 0);
                    }
                }
            }, 100);
        });
    });
}