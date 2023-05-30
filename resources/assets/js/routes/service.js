import {$, config, debug} from '../bootstrap';
import {apiGetPlans} from "../components/order/utils";

export default {
    load() {
        debug.bench('service:load');

               // init Owl Carousel
               $('.owl-carousel').owlCarousel({
                items:             4,
                itemsDesktop:      [1199, 3],
                itemsDesktopSmall: [979, 3],
                navigation:        true,
                navigationText:    ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                pagination:        false,
            });
    
            $('.testimonies-carousel').owlCarousel({
                items:             3,
                itemsDesktop:      3,
                itemsDesktopSmall: 2,
                itemsTablet:       3,
                itemsTabletSmall:  2,
                itemsMobile:       2,
                navigation:        true,
                navigationText:    ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                pagination:        false,
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
                },
                onfocusout(element) {
                    $(element).valid();
                },
                unhighlight(element/*, errorClass, validClass*/) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                submitHandler:  function (form) {
                    let data = {};

                    $this.serializeArray().map((field) => {
                        data[field.name] = field.value;
                    });

                    apiGetPlans(data)
                        .catch(function (response) {
                            config.deferred_errors = 'Error';
                            $this.valid();

                            // reset
                            $this.find('input[name="postal_code"]').one('keyup', function () {
                                config.deferred_errors = null;
                                $this.valid();
                            });
                        })
                        .then(function (response) {
                            //console.log('-> success', response, status, xhr);
                            if (!response.data || response.errors) {
                                config.deferred_errors = response.errors || 'Error';
                                $this.valid();

                                // reset
                                $this.find('input[name="postal_code"]').one('keyup', function () {
                                    config.deferred_errors = null;
                                    $this.valid();
                                });
                            } else if (response.data) {
                                config.deferred_errors = null;
                                config.postal_code = data.postal_code;

                                form.submit();
                            }
                        });
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

            $this.validate(options);

            $this.find('[type="submit"]').on('click', function () {
                // reset
                config.deferred_errors = null;
            });
        });
    },
};
