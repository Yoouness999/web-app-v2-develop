import {$, debug} from '../bootstrap';
import * as maps from '../shared/maps';
import order from '../routes/order';

export default {
    load() {
        debug.bench('business:load');

        // @note Run another module/route
        order.load();

        // init business merchandise Carousel
        $('#businessCarousel').carousel();

        $('.testimonies-carousel').owlCarousel({
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 2],
            itemsTablet: [768, 1],
            itemsMobile: [479, 1],
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            pagination: false,
        });

        $('.carousel-partners').owlCarousel({
            autoPlay: 2500,
            items: 6,
            itemsDesktop: [1199, 6],
            itemsDesktopSmall: [979, 4],
            itemsTablet: [768, 3],
            itemsTabletSmall: [768, 2],
            itemsMobile: [479, 2],
            navigation: false,
            pagination: false,
        });

        const params = {
            key: 'AIzaSyBVGlR_JWv2dL4hTDgBihUg0unUBEc4das',
            libraries: [],
            language: 'fr',
            sensor: false,
        };
        maps.load(params, function (google) {
            let map = null;
            let initialized = null;

            $('#modal-coverage-map').on('show.bs.modal', function () {
                //const $this = $(this);

                if (!initialized) {
                    const options = {
                        center: new google.maps.LatLng(50.815358, 4.3720161),
                        zoom: 8,
                        scrollwheel: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map = new google.maps.Map(document.getElementById('coverage-map'), options);

                    //$this.find('.modal-body').addClass('loading');

                    const cities = window.__app.cities || [];
                    const promises = cities.map(function (city) {
                        return maps.getPolygons(city).then(function (response) {
                            response.data.map(function (data) {
                                const options = {};

                                if (!data.coordinates.length) {
                                    console.log(`No coordinates for [${data.city}]!`);
                                }

                                data.coordinates.map((coordinates) => maps.drawPolygon(coordinates, options).setMap(map));
                            });
                        });
                    });

                    /*Promise.all(promises).then(function (responses) {
                        // responses.map(callback);

                        $this.find('.modal-body').removeClass('loading');
                    });*/

                    initialized = true;
                }
            });
        });
    },
};