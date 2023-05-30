import {$, debug} from '../bootstrap';

export default {
    load() {
        debug.bench('jobs:load');

        // init Owl Carousel
        console.log('Listen GTM');

        /* jshint ignore:start */
        $('a.accordion-header').on('click', function () {
            window.dataLayer.push({
                'event':  'Job',
                'action': 'Click',
                'label':  $(this).attr('href')
            });
            console.log('Track', $(this).attr('href'));
        });
        /* jshint ignore:end */
    },
};