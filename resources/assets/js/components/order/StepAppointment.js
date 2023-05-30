import {apiGetPlans, getFloat, promise} from './utils';
import {config, $, moment} from "../../bootstrap";

/**
 * Step 3 : Appointment
 */
export default function orderAppointment() {
    const $form = $('.order-appointment-form');
    if (!$form.length) {
        return;
    }

    if (config.lang) {
        moment.locale(config.lang);
    }

    // @see http://jqueryvalidation.org
    let validations = {
        errorPlacement: function (error, $element) {
            if (['pickup_time', 'dropoff_time'].indexOf($element.attr('name')) > -1) {
                $element.closest('.input-group').addClass('has-error');
            }

            if ($element.parent().hasClass('input-group')) {
                error.insertAfter($element.parent());
            } else {
                error.insertAfter($element);
            }
        },
        highlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').addClass('has-error');

            if (['pickup_time', 'dropoff_time'].indexOf($(element).attr('name')) > -1) {
                $(element).closest('.input-group').addClass('has-error');
            }
        },
        onfocusout(element) {
            $(element).valid();
        },
        unhighlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').removeClass('has-error');

            if (['pickup_time', 'dropoff_time'].indexOf($(element).attr('name')) > -1) {
                $(element).closest('.input-group').removeClass('has-error');
            }
        },
        invalidHandler: function (form, validator) {
            $(form).find('button[type="submit"]').removeClass('btn-loading');
        },
        submitHandler:  function (form) {
            // @note - Prevent multiple submit
            $(form).find('button[type="submit"]').addClass('btn-loading');

            form.submit();
        },
    };

    $form.validate($.extend(validations, {
        rules: {
            'address_postal_code': {
                // Validate a Belgium postal code
                // @see https://rgxdb.com/r/316F0I2N
                pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
            },
        },
    }));

    /**
     * Get Plans prices when updating postal_code
     */
    $form.find('input[name="address_postal_code"]')
        .on('change keyup', function () {
            const $this = $(this);

            if ($this.data('__timeout')) {
                clearTimeout($this.data('__timeout'));
            }

            // @note Debounce apiGetPlans queries
            $this.data('__timeout', setTimeout(function () {
                if ($this.valid() && $this.val() !== $this.data('__value')) {
                    const $resume = $form.find('.order-resume').addClass('loading');

                    // @note Store current value to prevent a new query with the same value
                    $this.data('__value', $this.val());

                    apiGetPlans({postal_code: $this.val()})
                        .then(function (response) {
                            if (response.errors) {
                                $form.find('input[name="address_postal_code"]').parent().addClass('has-error');

                                // $form.find('input[name="address_postal_code"]').one('keyup', function () {
                                //     $(this).removeClass('has-error');
                                // });
                            } else if (response.data) {
                                const plan = response.data.find((item) => item.id === parseInt($form.find('input[name="plan_id"]').val(), 10));

                                if (plan) {
                                    $form.find('input[name="plan_price_per_month"]').val(plan.price_per_month);
                                    $form.find('.order-resume .plan .value').text(calculPrice());
                                } else {
                                    $form.find('input[name="plan_price_per_month"]').parent().addClass('has-error');
                                }
                            }

                            $resume.removeClass('loading');
                        });
                }
            }, 400));
        });

    // @see https://bootstrap-datepicker.readthedocs.io/en/latest/
    const datepickerOptions = {
        autoclose: true,
        // @see App/Http/Controllers/OrderController
        // @see https://github.com/uxsolutions/bootstrap-datepicker/issues/1658#issuecomment-154097794
        beforeShowDay(date) {
            const current = moment(date).format('YYYY-MM-DD');

            for (let i = 0, len = config.unavailableDates.length; i < len; i++) {
                let disabled = moment(config.unavailableDates[i], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD');

                if (disabled === current) {
                    return false;
                }
            }

            return true;
        },
        datesDisabled: config.unavailableDates.map((date) => moment(date, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD')),
        format: {
            toDisplay(date/*, format, language*/) {
                return moment(date).format('MMM D, YYYY');
            },
            toValue(date/*, format, language*/) {
                if (!isNaN(moment(date, 'MMM D, YYYY').toDate())) {
                    return moment(date, 'YYYY-MM-DD HH:mm:ss').toDate();
                }

                return moment(date, 'MMM D, YYYY').toDate();
            },
        },
        language: config.lang,
        startDate: new Date(),
        weekStart: 1,
        daysOfWeekDisabled: "0,6"
    };

    if (config.startDate) {
        datepickerOptions.startDate = moment(config.startDate, 'YYYY-MM-DD HH:mm:ss').toDate();
    }

    $('.datepicker').datepicker(datepickerOptions);

    /* Dropoff rules :
     * - Pickup can't be before dropoff
     * - Pricing delivery
     */
    $('#dropoff-date').on('changeDate', function (e) {
        const $this = $(this);
        const $pickup = $('#pickup-date');

        $pickup.datepicker('destroy');
        $pickup.datepicker($.extend({}, datepickerOptions, {
            startDate: moment($this.val(), 'MMM D, YYYY').format('YYYY-MM-DD'),
        }));

        /* Update time slots */
        const $time = $('#dropoff-time');
        $time.prop('disabled', true)
            .parents('.input-group').addClass('disabled').removeClass('has-error')
            .find('option.time').remove();

        getTimeSlots(moment($this.datepicker('getDate')).format('YYYY-MM-DD'))
            .then(function (options) {
                if (options.length) {
                    options = options.map(function (item) {
                        return $('<option>').addClass('time')
                            .text(item.label).attr('value', item.value);
                    });
                } else {
                    $time.empty().parents('.input-group').addClass('has-error');
                }
                $time.append(options).prop('disabled', false)
                        .parents('.input-group').removeClass('disabled');
            });
    });

    $('#pickup-date').on('changeDate', function (e) {
        const $this = $(this);
        const $dropoff = $('#dropoff-date');
        $this.val(moment($this.datepicker('getDate')).format('YYYY-MM-DD'));
        $this.valid();
        $dropoff.datepicker('destroy');
        $dropoff.datepicker($.extend({}, datepickerOptions, {
            endDate:   moment($this.val(), 'MMM D, YYYY').add(1, 'day').format('YYYY-MM-DD'),
            startDate: moment().format('YYYY-MM-DD'),
        }));

        /* Update time slots */
        const $time = $('#pickup-time');
        $time.prop('disabled', true)
            .parents('.input-group').addClass('disabled').removeClass('has-error')
            .find('option.time').remove();

        getTimeSlots(moment($this.datepicker('getDate')).format('YYYY-MM-DD'))
            .then(function (options) {
                if (options.length) {
                    options = options.map(function (item) {
                        return $('<option>').addClass('time')
                            .text(item.label).attr('value', item.value);
                    });
                    if ($dropoff.is(':visible') && !$('#dropoff-time').val()) {
                        $time.prop('disabled', true);
                    }
                } else {
                    let $pickpErrorEle = $('#pickup-time-error');
                    let $forGroupEle = $time.parents('.input-group').parent();
                    if($pickpErrorEle.length > 0) {
                        $pickpErrorEle.text('No timeslot available for selected date. Please select another date');
                    } else {
                        $forGroupEle.append($('<label id="pickup-time-error" class="error" for="pickup-time">No timeslot available for selected date. Please select another date</label>'));
                    }
                    $forGroupEle.addClass('has-error');
                }
                $time.append(options).parents('.input-group').removeClass('disabled');
                $time.prop('disabled', false);

                $time.trigger('change');
            });
    });

    $('#dropoff-time').on('change', function () {
        if ($(this).val() && $('#pickup-date').val()) {
            $('#pickup-time').prop('disabled', false)
                .parents('.input-group').removeClass('disabled');
        }
    });
    $('#pickup-time, #dropoff-time').on('change', updateTimeRangeLimitation);

    function updateTimeRangeLimitation() {
        const $pickup = $('#pickup-date');
        const $dropoff = $('#dropoff-date');
        const $time = $('#dropoff-time');

        if ($pickup.val() === $dropoff.val() && $time.val()) {
            const dropoffStart = moment($time.val().split('_')[0], 'YYYY-MM-DD HH:mm:ss');

            $('#pickup-time').find('option').each(function () {
                const $option = $(this);
                const pickupStart = moment($option.val().split('_')[0], 'YYYY-MM-DD HH:mm:ss');

                if (dropoffStart > pickupStart) {
                    $option.prop('disabled', true);
                }
            });

            /*options = options.map(function (item) {
                item.disabled = false;

                const dropoffStart = moment($time.val().split('_')[0], 'YYYY-MM-DD HH:mm:ss');
                const pickupStart = moment(item.value.split('_')[0], 'YYYY-MM-DD HH:mm:ss');

                if (dropoffStart > pickupStart) {
                    item.disabled = true;
                }

                return item;
            });*/
        }
    }

    /**
     * Get time slots options used in select
     * @param date
     * @return {promise}
     */
    function getTimeSlots(date) {
        return promise(function (resolve, reject) {
            $.ajax({
                data: {date: date},
                error: reject,
                success: function (data) {
                    resolve(data);
                },
                type: 'GET',
                url: $form.find('input[name="time_slots_url"]').val(),
            });
        });
    }

    // $('.datepicker + .input-group-btn').click(function (event) {
    //     event.preventDefault();
    //     $(this).prev('.datepicker').focus();
    // });

    /* Wait fill boxes */
    $('#wait_fill_boxes').change(function () {
        const $date = $('#pickup-date');
        const $time = $('#pickup-time');

        if ($(this).is(':checked')) {
            $date.val('').prop('disabled', true)
                .parents('.input-group').addClass('disabled');

            $time.prop('disabled', true)
                .parents('.input-group').addClass('disabled');
        } else {
            $date.prop('disabled', false)
                .parents('.input-group').removeClass('disabled');

            if ($date.val()) {
                $time.prop('disabled', false)
                    .parents('.input-group').removeClass('disabled');
            }
        }
    });

    $('#dropoff-date').change(function () {
        if ($('.pickup-date-input-group').hasClass('disabled')) {
            $('#pickup-date').val($(this).val());
        }
    });

    /* Storing duration discount */
    $form.find('input[name="storing_duration"]').change(function () {
        $form.find('.order-resume .plan .value').text(calculPrice());
    });

    function calculPrice() {
        let planPricePerMonth = getFloat($form.find('input[name="plan_price_per_month"]').val());
        let discountPercentage = getFloat($form.find('input[name="storing_duration"]').filter(':checked').data('discount-percentage'), true);
        return Math.round(planPricePerMonth * (1 - discountPercentage / 100) * 100) / 100;
    }

    /* Google autocomplete */
    $('.maps-autocomplete').each(function () {
        const $this = $(this);
        const options = $.extend({
            street_number: '[name="address_street_number"]',
            route:         '[name="address_route"]',
            postal_code:   '[name="address_postal_code"]',
            locality:      '[name="address_locality"]',
            country:       '[name="address_country"]',
        }, $this.data());

        const google = window.google;
        const autocomplete = new google.maps.places.Autocomplete(this, {types: ['address']});

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            const place = autocomplete.getPlace();

            setTimeout(function () {
                for (let i = 0, max = place.address_components.length; i < max; i++) {
                    let addressType = place.address_components[i].types[0];

                    if (options[addressType]) {
                        $(options[addressType])
                            .val(place.address_components[i].long_name)
                            .trigger('change')
                            .valid();
                    }
                }
            }, 100);
        });
    });
}
