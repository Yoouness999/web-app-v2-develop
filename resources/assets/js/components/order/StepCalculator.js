import {getFloat, getInt, formatPrice} from './utils';
import {LocalStorage} from '../../shared/utils/web-storage';
import {$, config} from "../../bootstrap";

/**
 * Step 1 (bis) : Calculator
 */
export default function orderCalculator() {
    const $form = $('.order-calculator-form');
    if (!$form.length) {
        return;
    }

    /**
     * Used with config.deferred_errors
     */
    // $.validator.addMethod('deferred_errors', function (value, element, params) {
    //     if (config.deferred_errors && Object.keys(config.deferred_errors).indexOf(element.name) > -1) {
    //         $.validator.messages['deferred_errors'] = config.deferred_errors[element.name];
    //         return false;
    //     }
    //
    //     return true;
    // }, '');
    //
    // $('.postal_code-form:not(.initialized)').each(function () {
    //     const $this = $(this).addClass('initialized');
    //     const $wrapper = $this.parents('.section-calculator-wrapper');
    //     const options = $.extend({
    //         errorPlacement: function (error, element) {
    //             if (element.parent().hasClass('input-group')) {
    //                 error.insertAfter(element.parent());
    //             } else {
    //                 error.insertAfter(element);
    //             }
    //         },
    //         highlight(element/*, errorClass, validClass*/) {
    //             $(element).closest('.form-group').addClass('has-error');
    //
    //             // reset plans
    //             $('.plan').each(function () {
    //                 const $plan = $(this);
    //
    //                 $plan.find('.price, .price-discount').find('.value').text('--');
    //             });
    //
    //             // disable button calculator
    //             updateButtonCalculator({});
    //
    //             $('.section-storage').addClass('blocked');
    //         },
    //         onfocusout(element) {
    //             $(element).valid();
    //         },
    //         unhighlight(element/*, errorClass, validClass*/) {
    //             $(element).closest('.form-group').removeClass('has-error');
    //         },
    //         submitHandler:  function (form) {
    //             let data = {};
    //
    //             $this.serializeArray().map((field) => {
    //                 data[field.name] = field.value;
    //             });
    //
    //             // synchronize all postal_code fields
    //             $('.postal_code-form').find('[name="postal_code"]').val(data.postal_code);
    //         },
    //         rules: {
    //             'postal_code': {
    //                 // Validate a Belgium postal code
    //                 // @see https://rgxdb.com/r/316F0I2N
    //                 pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
    //                 deferred_errors: true,
    //             },
    //         },
    //     }, $this.data());
    //
    //     /**
    //      * Bind the postal_code value of the first form into the second form
    //      */
    //     $this.find('input[name="postal_code"]').change(function(){
    //         $('#js-postal_code').val($(this).val());
    //     });
    //
    //     $this.validate(options);
    //
    //     $this.find('[type="submit"]').on('click', function () {
    //         // reset
    //         config.deferred_errors = null;
    //     });
    //
    //     if ($this.find('input[name="postal_code"]').val()) {
    //         config.noScroll = true;
    //         $this.submit();
    //     }
    // });

    // @note Prefill from LocalStorage
    const date = LocalStorage.get.item('calculator_timeout');
    const values = LocalStorage.get.item('calculator');

    // if value and timeout less than 10 days
    if (date + (10 * 24 * 60 * 60 * 1000) > new Date().getTime() && values) {
        $form.populateWith(values);
    }

    // Prevent user to submit form by hitting "enter"
    $form.bind('keypress', function (e) {
        // "enter" key
        if (e.keyCode === 13) {
            return false;
        }
    });

    // When an increment is updated -> update calculator
    $form.find('.increment-wrapper')
        .change(function () {
            refreshCalculatorQuantities($form);
        })
        .first().trigger('change');

    $form.find('.section-calculator-total').each(function () {
        /* Find the plan fitting the volume */
        $(this).find('button.btn')
            .click(function () {
                // Hide total volume section
                $form.find('.section-calculator-total').fadeOut('fast');
    
                // Get the price and resume section
                $.ajax({
                    type: "POST",
                    url: $form.find('[name="find_price_url"]').val(),
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                    $form.append(data);
                    $form.find('.section-storage-confirmation')
                        .fadeIn('fast')
                        .find('.close')
                        .click(function () {
                            $(this).parents('.section-storage-confirmation').remove();
                            $form.find('.section-calculator-total').fadeIn('fast');
                            return false;
                        });

                    $form.find('.section-storage-confirmation')
                        .find('button[type="submit"]')
                        .one('click', function (e) {
                            // @note Empty stored values from LocalStorage
                            LocalStorage.remove('calculator');
                            LocalStorage.remove('calculator_timeout');
                        });
                    }
                });
    
                return false;
            });
        
        $(this).find('.plan').each(function () {
            const $plan = $(this);
            const options = $plan.data();

            $plan.find('button.close').click(function () {
                $plan.addClass('loading');

                // update session
                $.post(options.url, {_token: $('html > head > meta[name="csrf-token"]').attr('content')}, function (response) {
                    if (response && response.data && response.data.success) {
                        $plan.removeClass('loading');
                        $form.find('input[name="volume_current"]').val(0);
                        refreshCalculatorQuantities($form);
                        $plan.remove();
                    }
                });
            });
        });
    });

    /* Hide plan section when clicking outside */
    $(document).on('click', function (event) {
        const $confirmation = $('.section-storage-confirmation');
        const $total = $('.section-calculator-total');

        if (!$(event.target).parents('.section-storage-confirmation').length) {
            $confirmation.fadeOut('fast', function () {
                $confirmation.remove();

                if ($total.length) {
                    $total.fadeIn('fast');
                }
            });
        }
    });
}

/**
 * Calculate total items by category and total order volume
 * @param $form
 */
function refreshCalculatorQuantities($form) {
    let volumeTotal = parseInt($form.find('input[name="volume_current"]').val(), 10);

    $form.find('.storage-supplies .item').each(function () {
        const $this = $(this);
        const $inputVal = $this.find('input[name^="items"]');
        const $inputVolume = $this.find('input[name^="volumes"]');

        let val = getInt($inputVal.val());
        let volume = getFloat($inputVolume.val());

        volumeTotal += volume * val;
    });

    $form.find('.section-calculator-categories .category').each(function () {
        let count = 0;

        const $category = $(this);
        const $items = $($category.attr('href'));

        $items.find('.item').each(function () {
            const $this = $(this);
            const $inputVal = $this.find('input[name^="items"]');
            const $inputVolume = $this.find('input[name^="volumes"]');

            let val = getInt($inputVal.val());
            let volume = getFloat($inputVolume.val());

            count += val;

            if ($category.hasClass('category-for-volume')) {
                volumeTotal += volume * val;
            }
        });

        $category.find('.count').text(count).toggleClass('active', count > 0);
    });

    $form.find('.section-calculator-total button.btn').prop('disabled', volumeTotal <= 0);
    $form.find('input[name="volume"]').val(volumeTotal);

    volumeTotal = formatPrice(volumeTotal);

    $form.find('.section-calculator-total .calculator-total').text(volumeTotal);
    $form.find('.section-calculator-total').fadeIn('fast');


    // @note Store values in LocalStorage
    let unallowed = ['find_price_url', 'volume', 'volume_current', '_token'];
    let values = $form.serializeObject();
    values = Object.keys(values)
        .filter((key) => unallowed.indexOf(key) === -1)
        .reduce((acc, key) => {
            acc[key] = values[key];
            return acc;
        }, {});

    LocalStorage.set('calculator', values);
    LocalStorage.set('calculator_timeout', new Date().getTime());
}
