import {apiGetPlans, getFloat, parseUrl, promise} from './utils';
import platform from '../../lib/platform';
import {$, config} from '../../bootstrap';

/**
 * Step 1 : Storage
 */
export default function orderStorage() {
    const $form = $('.order-storage-form');
    if (!$form.length) {
        return;
    }

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

            if ($('input[name="plan"]').val() > 0) {
                $('input[name="volumes[106]"], input[name="volumes[107]"], input[name="items[106]"], input[name="items[107]"]').prop('disabled', true);
            }

            form.submit();
        },
    };

    $.validator.addMethod('boxes', function (value, element, params) {
        if ($('input[name="plan"][value="1"]:checked').length) {
            if ($('input[name="items[106]"]').val() > 0 || $('input[name="items[107]"]').val() > 0) {
                return true;
            }

            hidePlan();
            return false;
        }

        return true;
    }, 'Boxes plan need at least one box.');

    let options = $.extend(validations, {
        rules:         {
            'items[106]': {
                boxes: true,
            },
            'items[107]': {
                boxes: true,
            },
        },
    });

    $form.validate(options);


    const $plans = $form.find('.plan');

    $form.find('input[name="storing_duration"]').change(updatePrice).trigger('change');
    $form.find('input[name="plan"]').change(function () {
        const $this = $(this);
        $this.parent().find('.btn').addClass('btn-loading');
        $this.closest('.plan').addClass('active');

        if ($this.val() === '1') {
            $('html, body').animate({
                scrollTop: $storage.offset().top - ($('.section-breadcrumb').length ? 180 : 130),
            }, 200);
        }

        getPlanDetails($form.serialize())
            .then(function (data) {
                $form.append(data);
                $form.find('.section-storage-confirmation')
                    .fadeIn('fast')
                    .find('.close')
                    .click(function () {
                        $(this).parents('.section-storage-confirmation').remove();
                        return false;
                    });

                $this.parent().find('.btn').removeClass('btn-loading');
            });
    });

    $(document).on('click', function (e) {
        if (e.target && !$(e.target).parents('.section-storage-confirmation').length) {
            hidePlan();
        }
    });

    // @see http://www.landmarkmlp.com/js-plugin/owl.carousel/
    $('.carousel-plans').each(function () {
        const $this = $(this).addClass('loading');
        const $nav = $this.find('.carousel-nav');
        const $content = $this.find('.carousel-content');
        const optionsNav = $.extend({
            addClassActive: true,
            afterInit($carousel) {
                const $items = $carousel.find('.item');
                $items.on('click', function (e) {
                    e.preventDefault();

                    const index = $items.index(this);
                    navGoTo(index);

                    const $target = $content.find($(this).data('target')).first();
                    const index2 = $content.find('.item').index($target[0]);
                    contentGoTo(index2);
                });
                $this.removeClass('loading');
            },
            afterMove($carousel) {
                const $items = $carousel.find('.item').removeClass('active');
                const $item = $items.eq(this.currentItem).addClass('active');
                const $target = $content.find($item.data('target')).first();
                const index = $content.find('.item').index($target[0]);
                contentGoTo(index);
            },
            items: 4,
            itemsMobile: [479, 1],
            itemsTablet: [768, 1],
            navigation: true,
            navigationText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            pagination: false,
        }, $nav.data());
        const optionsContent = $.extend({
            afterMove($carousel) {
                const $items = $carousel.find('.item');
                const $item = $items.eq(this.currentItem);
                const target = $item.attr('class').replace(/item|active/gi, '').split(' ').join('');
                const $target = $nav.find('.item[data-target=".' + target + '"]');
                const index = $nav.find('.item').index($target[0]);
                navGoTo(index);
            },
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],
            itemsMobile: [479, 1],
            itemsTablet: [768, 1],
            navigation: true,
            navigationText: ['', ''],
            pagination: false,
        }, $content.data());

        if (optionsContent.items !== 3) {
            $.extend(optionsContent, {
                itemsDesktop: [1199, optionsContent.items],
                itemsDesktopSmall: [979, optionsContent.items],
            });
        }

        $nav.owlCarousel(optionsNav);
        $content.owlCarousel(optionsContent);

        /**
         * Move .carousel-nav to the selected one
         * @param index
         */
        function navGoTo(index) {
            const $items = $nav.find('.item').removeClass('active');
            $items.eq(index).addClass('active');

            if (platform.is.mobile) {
                $nav.data('owlCarousel').jumpTo(index);
            } else {
                $nav.data('owlCarousel').goTo(index);
            }
        }

        /**
         * Move .carousel-content to the first item of the selected "plan type"
         * @param index
         */
        function contentGoTo(index) {
            const $items = $content.find('.item').removeClass('active');
            $items.eq(index).addClass('active');

            if (platform.is.mobile) {
                $content.data('owlCarousel').jumpTo(index);
            } else {
                $content.data('owlCarousel').goTo(index);
            }
        }
    });


    /**
     * Used with config.deferred_errors
     */
    $.validator.addMethod('deferred_errors', function (value, element, params) {
        if (config.deferred_errors && Object.keys(config.deferred_errors).indexOf(element.name) > -1) {
            $.validator.messages['deferred_errors'] = config.deferred_errors[element.name];
            return false;
        }

        return true;
    }, '');

    /**
     * Form used to fill prices of all plans from given postal code
     */
    $('.postal_code-form:not(.initialized)').each(function () {
        const $this = $(this).addClass('initialized');
        const options = $.extend({
            errorPlacement: function (error, element) {
                if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight(element/*, errorClass, validClass*/) {
                $(element).closest('.form-group').addClass('has-error');

                // reset plans
                $('.plan').each(function () {
                    const $plan = $(this);

                    $plan.find('.price, .price-discount').find('.value').text('--');
                });

                // disable button calculator
                updateButtonCalculator({});

                $('.section-storage').addClass('blocked');
            },
            onfocusout(element) {
                $(element).valid();
            },
            unhighlight(element/*, errorClass, validClass*/) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            submitHandler:  function (form) {
                if (!$this.find('button[type="submit"]').hasClass('btn-loading')) {
                    $this.find('button[type="submit"]').addClass('btn-loading');

                    let data = {};

                    $this.serializeArray().map((field) => {
                        data[field.name] = field.value;
                    });

                    // synchronize all postal_code fields
                    $('.postal_code-form').find('[name="postal_code"]').val(data.postal_code);

                    apiGetPlans(data)
                        .catch(function (response) {
                            config.deferred_errors = 'Error';
                            $this.valid();

                            $('.section-storage').addClass('blocked');
                            $this.find('button[type="submit"]').removeClass('btn-loading');

                            // reset
                            $this.find('input[name="postal_code"]').one('keyup', function () {
                                config.deferred_errors = null;
                                $this.valid();
                            });
                        })
                        .then(function (response) {
                            if (!response || !response.data || response.errors) {
                                config.deferred_errors = response && response.errors ? response.errors : 'Error';
                                $this.valid();

                                $('.section-storage').addClass('blocked');

                                // reset
                                $this.find('input[name="postal_code"]').one('keyup', function () {
                                    config.deferred_errors = null;
                                    $this.valid();
                                });
                            } else if (response.data) {
                                config.deferred_errors = null;
                                config.postal_code = data.postal_code;

                                response.data.map((item) => {
                                    const $plan = $(`#plan-${item.id}`);

                                    // update price references
                                    $plan.find('.plan').attr('data-price', item.price_per_month).data('price', item.price_per_month);
                                    $plan.find('.price .value').text(item.price_per_month);
                                });

                                setTimeout(function () {
                                    $('.carousel-content').find('.plan__body').sameHeight();
                                }, 0);

                                $('.section-storage').removeClass('blocked');

                                updateButtonCalculator({postal_code: data.postal_code});

                                if (!config.noScroll) {
                                    setTimeout(function () {
                                        let $content = $('#carousel-plans').find('.carousel-content');

                                        if (!$content.length) {
                                            // @note Used on pricing page
                                            $content = $('#grid-plans');
                                        }

                                        $('html, body').animate({
                                            scrollTop: $content.offset().top - ($('.navbar-default').height() + 50),
                                        }, 150);
                                    }, 0);
                                }

                                // reset noScroll flag
                                config.noScroll = false;
                            }

                            $this.find('button[type="submit"]').removeClass('btn-loading');
                        });
                }
            },
            rules: {
                'postal_code': {
                    // Validate a Belgium postal code
                    // @see https://rgxdb.com/r/316F0I2N
                    pattern: /^(?:(?:[1-9])(?:\d{3}))$/,
                    deferred_errors: true,
                },
            },
        }, $this.data());

        /**
         * Bind the postal_code value of the first form into the second form
         */
        $this.find('input[name="postal_code"]').change(function(){
            $('#js-postal_code').val($(this).val());
        });

        $this.validate(options);

        $this.find('[type="submit"]').on('click', function () {
            // reset
            config.deferred_errors = null;
        });

        if ($this.find('input[name="postal_code"]').val()) {
            config.noScroll = true;
            $this.submit();
        }
    });

    /**
     * Get the related plan
     * @param data
     */
    function getPlanDetails(data) {
        data += `&${$.param({postal_code: config.postal_code})}`;

        return promise(function (resolve, reject) {
            $.ajax({
                data,
                error: reject,
                success: resolve,
                type: 'POST',
                url: $form.find('[name="find_price_url"]').val(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        });
    }

    /**
     * Hide plan section when clicking outside
     */
    function hidePlan() {
        const $confirmation = $('.section-storage-confirmation');

        if ($confirmation.is(':visible')) {
            $confirmation.fadeOut('fast', function () {
                $plans.removeClass('active');
                $confirmation.remove();

                setTimeout(function () {
                    $('input[name="plan"]').prop('checked', false);
                }, 100);
            });
        }
    }

    /**
     * Update price when storing duration change
     */
    function updatePrice() {
        const $selected = $form.find('[name="storing_duration"]').filter(':checked');
        const discountPercentage = getFloat($selected.data('discount-percentage'), true);
        let $plans = $form.find('#carousel-plans .plan');

        if (!$plans.length) {
            // @note Used with pricing page
            $plans = $form.find('#grid-plans .plan');
        }

        $plans.each(function () {
            let planPricePerMonth = getFloat($(this).data('price'));
            // ex. 100 * (1 - (15 / 100)) === 100 * 0.15 === 85
            let price = planPricePerMonth * (1 - (discountPercentage / 100));
            let hasDiscount = planPricePerMonth !== price;
            //console.log('))', planPricePerMonth, discountPercentage + '%', price);

            price = price.toFixed(2).replace('.', ',');

            $(this).toggleClass('discount', hasDiscount);
            $(this).find('.price-discount .value').text(price);
        });

        setTimeout(function () {
            $('.carousel-content').find('.plan__body').sameHeight();
        }, 0);

        // update calculator query strings
        updateButtonCalculator({storing_duration: $selected.val(), postal_code: config.postal_code});
    }

    /**
     * Add query string to Calculator button and activate button if there is a postal_code param
     * @param params
     */
    function updateButtonCalculator(params = {}) {
        const $btn = $('.calculator').find('.btn');
        const url = parseUrl($btn.attr('href'));

        url.params = params;

        if (Object.keys(params).length) {
            url.params = $.extend({}, url.params, params);
        }

        $btn.attr('href', url.toString());
    }
}
