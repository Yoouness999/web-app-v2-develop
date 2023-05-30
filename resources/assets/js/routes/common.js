import {$, angular, debug} from '../bootstrap';
import config from '../config';
import debounce from '../shared/utils/debounce';

// shared dependencies
config.dependencies = [];

export default {
    load() {
        debug.bench('common:load');

        $(document.body).addClass('loading');

        $.cookieBar({
            acceptText: config.labels.cookiebar_button,
            bottom:     true,
            fixed:      true,
            message:    config.labels.cookiebar_message,
            policyURL:  '/page/policy/'
        });


        // inform Google Analytics of the change
        if (typeof window.ga !== 'undefined') {
            let tracked = document.location.href.replace(document.location.origin, '');
            window.ga('send', 'pageview', tracked);
        }

        // Sticky header
        $('html, body').on('scroll mousewheel touchmove', debounce(function () {
            $('.main-header .navbar').toggleClass('sticky', $(window).scrollTop() > 0);
        }));

        $('.navbar-header .navbar-toggle').click(function () {
            $(this).parents('.navbar').toggleClass('open', $(this).hasClass('collapsed'));
        });

        $('[data-toggle="tooltip"]').each(function () {
            const $this = $(this);
            const options = $.extend({
                container: 'body',
                placement: 'top',
                trigger: 'manual',
            }, $this.data());

            $this
                .on('mouseenter', function () {
                    $this.tooltip('show');
                })
                .on('mouseleave', function () {
                    $this.tooltip('hide');
                })
                .on('touch', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    $this.tooltip('toggle');
                });

            $this.tooltip(options);
        });

        // valid zip coderder_form_cities = [];
        //         // $.get('/api/v1/cities', function (data) {
        //         //     config.home_order_form_cities = data.data;
        //         // });
        // config.home_o

        // $.validator.addMethod('zipcodeavailable', function (value, element) {
        //     const isValid = config.home_order_form_cities[value] !== undefined;
        //     $(element).parents('form').find('.zip-code-error').toggleClass('hidden', isValid);
        //     return isValid;
        // }, $.validator.messages.remote);

        // Form asking zip code
        // $('.order-form').each(function () {
        //     $(this).validate({
        //         rules: {
        //             zip_code: {
        //                 zipcodeavailable: true
        //             },
        //         },
        //     });
        // });
    },
    finalize() {
        angular.module('app', config.dependencies)
            // @note share window.__app in angular apps
            .value('globals', config);

        // bootstrap the app (async)
        angular.bootstrap(document, ['app']);

        setTimeout(function () {
            // Tooltip
            $('[data-toggle="tooltip"]').tooltip({container: 'body'});

            $(window).on('load', function () {
                $(window).trigger('scroll');
                $('html, body').trigger('scroll');
            });

            $(document.body).removeClass('loading');
        }, 0);

        debug.bench('common:finalize', true);
    },
};
