import {$, debug} from '../bootstrap';

export default {
    load() {
        debug.bench('faq:load');

        // init Owl Carousel
        console.log('Listen GTM');

        /* jshint ignore:start */
        $('a.accordion-header').on('click', function () {
            window.dataLayer.push({
                'event':  'FAQ',
                'action': 'Click',
                'label':  $(this).attr('href')
            });
        });
        /* jshint ignore:end */

        $('.accordion-group').each(function () {
            const $this = $(this);
            const $button = $this.find('.accordion-header');

            $button.on('click', function (e) {
                if (history.pushState) {
                    history.pushState(null, null, e.target.hash);
                } else {
                    document.location.hash = e.target.hash;
                }

                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: $('.accordion').find(e.target.hash).offset().top - ($('.navbar-default').height() + 50),
                    }, 200);
                }, 0);
            });
        });

        $(window).on('load', function () {
            // @note Allow to open a specific tab by givin the hash
            if (document.location.hash) {
                $('.accordion').find('a[href="' + document.location.hash + '"]').trigger('click');
            }
        });
    },
};