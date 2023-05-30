import {angular, moment, $} from '../../bootstrap';

export default class PickupController {
    /**
     * @ngInject
     */
    constructor($scope, $state, $filter, $http, $sce, ApiService, globals) {
        this.$state = $state;
        this.$scope = $scope;
        this.$filter = $filter;
        this.$http = $http;
        this.$sce = $sce;
        this.ApiService = ApiService;
        this.globals = globals;

        // Debug options
        this.isDebug = this.globals.debug;

        this.moment = moment();

        /**
         * Variables availables by default
         */
        this.withFakeData = false;// Add fakeData for testing
        this.formErrors = null;

        this.location = null;
        this.total = 0;
        this.currency = '€';
        this.minDate = this.globals.minPickupDate;
        this.billingInfo = this.globals.billingInfo;
        this.pickupDate = null;
        this.pickupTime = null;
        this.vatError = null;
        this.use_current_billing_info = false;
        this.adyen_card_encrypted_json = '';

        // Set default availableTimes for the time selectbox
        this.defaultAvailableTimes = {
            '08:00': '08:00 - 10:00',
            '10:00': '10:00 - 12:00',
            '12:00': '12:00 - 14:00',
            '14:00': '14:00 - 16:00',
            '16:00': '16:00 - 18:00',
        };

        this.availableTimes = angular.copy(this.defaultAvailableTimes);
        this.unavailableDates = [];
        this.disabledDates = [];

        /**
         * Prepare default formData values
         */
        this.formData = this.globals.formData ? this.globals.formData : {
            payment_type:  'credit_card',
            postalcode:    null,
            pickup_option: 'direct'
        };

        // If Debug populate with fake data for easier slicing testing
        if (this.withFakeData) {
            this.pickupDate = '2016-02-23';
            this.pickupTime = '08:00';

            this.formData = {
                agree:                 true,
                first_name:            'Daniel',
                last_name:             'Sum',
                phone:                 '0485662569',
                email:                 'daniel.sum86@gmail.com',
                postalcode:            1030,
                street:                'Rue des palais',
                number:                44,
                box:                   '5D',
                city:                  'Schaerbeek',
                add_infos:             'Test User',
                latitude:              50.8503396,
                longitude:             4.3517103,
                promo_code:            'invitation',
                promo_applied:         20,
                pickup_date:           '2016-02-23 08:00',
                card_name:             'Daniel Sum',
                card_number:           '5017670000006700',
                card_expiration_month: '12',
                card_expiration_year:  '2020',
                card_cvv:              '123',
                business:              true,
                billing_address:       true,
                billing_to:            'Cherry Pulp',
                billing_street:        'Rue des palais',
                billing_number:        '44',
                billing_box:           '5D',
                billing_postalcode:    1030,
                billing_city:          'Schaerbeek',
                billing_vat:           'BE0826543829',
                pickup_option:         'direct',
                payment_type:          'credit_card',
                iban:                  'NL13TEST0123456789',
                iban_owner:            'A. Klaassen'
            };
        }

        /**
         * Watchers
         */
        // Add listener on formData to sync formData between routes
        $scope.$watch('formData', () => {
            this.globals.formData = this.formData;
        });

        // Add listener on formData to sync between route
        $scope.$watch('pickup.pickupDate', () => {
            this.setDisabledHours();
        });

        /* jshint ignore:start */
        // Add listener on Location when Google Places Matches
        $scope.$watch('location', (place) => {
            if (typeof place !== 'undefined' && typeof place.geometry !== 'undefined') {
                this.formData.latitude = place.geometry.location.lat();
                this.formData.longitude = place.geometry.location.lng();

                // Reset form data
                this.formData.number = null;
                this.formData.city = null;
                this.formData.street = null;
                this.formData.postalcode = null;

                // try to retrieve info from adress
                Object.keys(place.address_components).map((key) => {
                    let item = place.address_components[key];
                    let types = item.types;

                    Object.keys(item.types).map((k) => {
                        if (types[k] === 'street_number') {
                            this.formData.number = item.long_name;
                        } else if (types[k] === 'route') {
                            this.formData.street = item.long_name;
                        } else if (types[k] === 'locality') {
                            this.formData.city = item.long_name;
                        } else if (types[k] === 'postal_code') {
                            this.formData.postalcode = item.long_name;
                        }
                    });
                });

                if (!this.formData.number || !this.formData.city || !this.formData.street || !this.formData.postalcode) {
                    $('#google_places_ac').addClass('ng-touched ng-invalid');
                } else {
                    $('#google_places_ac').removeClass('ng-invalid');
                    this.checkSchedules();
                }
            }
        });
        /* jshint ignore:end */

        /**
         * Variables loaded by promises
         */
        this.ApiService.getUser().then((data) => {
            this.user = data;

            // Get User Items from this.globals or define an empty one
            this.formData.items = typeof this.globals.formData.items !== 'undefined' ? this.globals.formData.items : {};

            // user default data if formData is empty
            var userDataToPopulate = [
                'first_name',
                'last_name',
                'email',
                'phone',
                'billing_city',
                'billing_postalcode',
                'billing_box',
                'billing_number',
                'billing_street',
                'billing_to',
                'billing_vat',
                'billing_address',
                'business',
            ];

            this.billing_status = data.billing_status;
            this.billing_id = data.billing_id;

            for (let i in userDataToPopulate) {
                let key = userDataToPopulate[i];
                if (!this.formData[key] && this.user[key]) {
                    this.formData[key] = this.user[key];
                }
            }

            if (this.billing_status === 'paid') {
                this.use_current_billing_info = true;
            }

            if (data.business) {
                this.formData.business = true;
            }

            if (data.billing_address) {
                this.formData.billing_address = true;
            }

            // Check Schedules after user logged in
            this.checkSchedules();
        });

        // Get availables cities postalcodes
        this.ApiService.getCities().then((data) => {
            this.cities = data;
        });

        // Get Items type infos
        this.ApiService.getTypes().then((data) => {
            this.types = data;

            // Dispatch types between box type and LargerTypes
            this.typesBox = {};
            this.typesBulk = {};

            for (let key in this.types) {
                let item = this.types[key];

                //item.name = this.$sce.trustAsHtml(item.name);
                //item.description = this.$sce.trustAsHtml(item.description);

                // Assign item in formData.items if not already defined
                if (typeof this.formData.items !== 'undefined' && typeof this.formData.items[key] === 'undefined') {
                    this.formData.items[key] = item;
                }

                // define a number if not already defined
                if (typeof this.formData.items !== 'undefined' && typeof this.formData.items[key].number === 'undefined') {
                    // If debug mode => auto assign 1 element for testing
                    this.formData.items[key].number = this.withFakeData ? 1 : 0;
                }

                if (!item.bulk_item) {
                    this.typesBox[key] = item;
                } else {
                    this.typesBulk[key] = item;
                }
            }

            // Update the cart
            this.updateCart();
        });


        // Add special window scroll events for total block
        $(window).scroll(this.onScroll);
        this.onScroll();

        // Check steps to prevent any error during the flow
        this.checkSteps();

        // Apply promocode if invitation is defined

        if ($.cookie && $.cookie('invitation_code')) {
            // Don't try to hack that => it's processed in the back-end side ;-)
            this.formData.promo_applied = 20;
            console.log('Invitation code applied');
        }
    }

    /**
     * Display a message in console when `isDebug` is true
     */
    debug() {
        this.isDebug && console.log.apply(console, arguments);
    }

    getCardType(number) {
        // visa
        let re = new RegExp("^4");
        if (number.match(re) !== null) {
            return "visa";
        }

        // Mastercard
        re = new RegExp("^5[1-5]");
        if (number.match(re) !== null) {
            return "mastercard";
        }

        return 'other';
    }

    checkCardNumber(event) {
        $('.card-type').removeClass('selected');
        $('.card-type.' + this.getCardType(event.target.value)).addClass('selected');
    }

    /**
     * Check Coupon code validity
     *
     * @param code
     */
    checkCoupon(code) {
        let data = {
            code: code ? code : this.formData.promo_code
        };

        this.promoError = null;
        this.formData.promo_applied = null;

        this.$http.post('/api/v1/check-coupon', data).then((response) => {
            if (response.data.data.valid) {
                this.formData.promo_applied = response.data.data.valid;
                this.promoError = null;
            } else {
                this.promoError = true;
            }
        }, (response) => {
            this.promoError = true;
        });
    }

    /**
     * Check if postal code is correctly defined
     *
     * @param code
     * @returns {boolean}
     */
    checkPostalcode(code) {
        this.postalErrors = false;

        if (typeof this.formData !== 'undefined' && typeof this.cities !== 'undefined') {
            let postalcode = code ? code : this.formData.postalcode;
            let result = typeof this.cities[postalcode] !== 'undefined';

            this.postalErrors = !result;

            return result;
        }

        return false;
    }

    checkSchedules() {
        // Check unaivalables dates
        this.ApiService.call('check-schedules', {
            postalcode: this.formData.postalcode,
            latitude:   this.formData.latitude,
            longitude:  this.formData.longitude
        }).then((data) => {
            this.setDisabledDates(data);
        });
    }

    /**
     * Check steps particular data to check
     */
    checkSteps() {
        if (this.$state.current.name === 'review') {
            if (!this.formData.pickup_date) {
                this.goStep1();
            }
        }
    }

    /**
     * Check TVA code
     *
     * @param nb
     */
    checkVat(nb) {
        let data = {
            number: nb ? nb : this.formData.billing_vat
        };

        this.vatError = null;

        this.$http.post('/api/v1/tva', data).then((response) => {
            if (response.data.data.valid) {
                this.vatError = null;
                console.log('Success', response);
            } else {
                console.log('Invalid');
                this.vatError = true;
            }
        }, () => {
            console.log('Error');
            this.vatError = true;
        });
    }

    /**
     * Update the formData and put a persistence in the window.global
     */
    formDataUpdate(key) {
        this.globals.formData = this.formData;
    }

    /**
     * Helpers to go to next step
     */
    goStep1() {
        window.dataLayer.push({
            'pageName': 'pickup/appointment',
        });

        if (typeof window.ga !== 'undefined') {
            window.ga('send', 'pageview', 'pickup/appointment');

            let metadata = {
                email:        this.formData.email,
                current_page: 'pickup/appointment',
            };

            window.Intercom('trackEvent', 'pickup-appointment', metadata);
        }

        this.$state.go('appointment');
    }

    /**
     * Check the step appointment and go to step 2
     */
    goStep2() {
        let valid = true;

        this.formErrors = null;

        //1. Check form validation
        $('form').submit();

        if (!this.formAppointment.$valid) {
            valid = false;
            this.setError('form', this.trans('Some fields are required'));
        }

        if (!this.formData.postalcode || !this.formData.street || !this.formData.number || !this.formData.city) {
            valid = false;
            this.setError('form', this.trans('Please enter a valid address'));
            $('#google_places_ac').addClass('ng-touched ng-invalid');
        } else {

        }

        if (!this.checkPostalcode(this.formData.postalcode)) {
            valid = false;
            this.setError('form', this.trans('The postal code is incorrect'));
            $('#postal_code').addClass('ng-touched');
        }

        this.updatePickupDate();
        if (!this.formData.pickup_date) {
            valid = false;
            this.setError('date', this.trans('Pickup date is invalid'));
            $('#pickup_hour').addClass('ng-touched');
            $('#pickup_date').addClass('ng-touched');
        }

        if (this.total === 0) {
            valid = false;
            this.setError('items', this.trans('You should choose at least one item'));
        }

        if (valid === true) {
            $('html, body').animate({scrollTop: 0}, '500');

            window.dataLayer.push({
                'pageName': 'pickup/review',
            });

            if (typeof window.ga !== 'undefined') {
                window.ga('send', 'pageview', 'pickup/review');
            }

            let metadata = {
                email:        this.formData.email,
                total:        this.total,
                current_page: 'pickup/review'
            };

            window.Intercom('trackEvent', 'pickup-review', metadata);

            this.$state.go('review');
        }
    }

    /**
     * Submit form then go to the step3
     */
    goStep3() {
        $('html, body').animate({scrollTop: 0}, '500');

        window.dataLayer.push({
            'pageName': 'pickup/confirmation',
        });

        if (typeof window.ga !== 'undefined') {
            window.ga('send', 'pageview', 'pickup/confirmation');

            let metadata = {
                email:        this.formData.email,
                total:        this.total,
                current_page: 'pickup/confirmation'
            };

            window.Intercom('trackEvent', 'pickup-confirmation', metadata);
        }

        this.$state.go('confirmation');
    }

    /**
     * Add an item to the basket
     *
     * @param key
     */
    itemAdd(key) {
        if (typeof this.formData.items != 'undefined') {
            this.formData.items[key].number++;
            this.updateCart();
        }
    }

    itemRemove(key) {
        if (typeof this.formData.items != 'undefined') {
            if (this.formData.items[key].number > 0) {
                this.formData.items[key].number--;
            }
            this.updateCart();
        }
    }

    itemChangeNumber(key, nb) {
        if (typeof this.formData.items != 'undefined') {
            this.formData.items[key].number = nb;
            this.updateCart();
        }
    }

    /**
     * Add an other items
     */
    otherItemAdd() {
        if (typeof this.formData.items != 'undefined') {
            this.formData.items.other.number++;
        }
    }

    /**
     * Add an other items
     */
    otherItemRemove(index) {
        if (typeof this.formData.items != 'undefined') {
            this.formData.items.other.lists.splice(index, 1);
            this.formData.items.other.number--;
        }
    }

    /**
     * On Scroll event
     */
    onScroll() {
        let el = $('.fixed-total');

        if (el.length) {
            let scroll = $(window).scrollTop() + $(window).height() - el.height();

            //var fixedTotalPosition = $('.fixed-total').offset();
            let submitPosition = $('#submit').offset().top;

            //console.log(scroll, submitPosition);
            if (scroll < submitPosition) {
                el.css({
                    position: 'fixed',
                    bottom:   '5%',
                    top:      'inherit',
                    right:    '10%'
                });
            } else {
                el.css({
                    position: 'absolute',
                    bottom:   'inherit',
                    top:      submitPosition + 'px',
                    right:    '10%'
                });
            }
        }
    }

    /**
     * Set the disabled dates for the Datepicker
     *
     * @param dates
     */
    setDisabledDates(dates) {
        this.unavailableDates = dates.unavailables;
        this.globals.unavailableDates = dates.unavailables;

        for (let key in dates.unavailables) {
            let date = dates.unavailables[key].date;
            let oDate = new Date(date);
            if (oDate.getHours() === 0) {
                this.disabledDates.push(date);
            }
        }

        this.setDisabledHours();
    }

    /**
     * Set the disabled dates for the Datepicker
     *
     * @param dates
     */
    setDisabledHours() {
        // reset available times
        this.availableTimes = angular.copy(this.defaultAvailableTimes);

        for (let key in this.unavailableDates) {
            let date = this.unavailableDates[key].date;
            let oDate = moment(date);
            let currentDate = moment(this.pickupDate, 'YYYY-MM-DD');

            if (oDate.format('YYYY-MM-DD') !== currentDate.format('YYYY-MM-DD')) {
                let ref = oDate.format('HH:mm');
                delete this.availableTimes[ref];
            }

        }
    }

    /**
     * SetError handler
     */
    setError(key, value) {
        if (!this.formErrors) {
            this.formErrors = {};
        }
        this.formErrors[key] = value;
    }

    /**
     * Submit the form Process
     */
    submitForm() {
        //1. Check if all the fields are corrects
        let valid = true;

        this.formErrors = null;

        //1. Check form validation
        //$('form').submit();
        if (!this.formReview.$valid) {
            valid = false;
            angular.forEach(this.formReview.$error.required, (field) => field.$setDirty());
            console.log('Form invalid', this.formReview.$error);
            this.setError('form', this.$filter('translate')('Some fields are required'));
        }

        // Check agree validation
        if (!this.formData.agree) {
            valid = false;
            this.setError('agree', this.$filter('translate')('You must accept the terms and conditions'));
        }

        if (this.formData.pickup_date.match('undefined')) {
            valid = false;
            this.setError('date', this.$filter('translate')('Pickup date is invalid'));
        }

        if (this.total === 0) {
            valid = false;
            this.setError('items', this.$filter('translate')('You should choose at least one item'));
        }

        if (valid === true) {
            // Preparing data for submission
            let data = this.formData;
            this.validating = true;

            // Scroll to top
            this.$http.post('/api/v1/pickup', data).then((response) => {
                this.validating = false;
                console.log('Form Success', response);
                if (typeof response.status !== 'undefined' && response.status == 200) {
                    this.validating = false;

                    /* jshint ignore:start */
                    let products = [];
                    let tax = this.total / ((21 / 100) + 1);
                    let total = this.total;
                    let coupon = this.formData.promo_code;

                    if (typeof coupon === 'undefined') {
                        coupon = '';
                    }

                    if (typeof this.formData.items != 'undefined') {
                        for (let i = 0; i < this.formData.items.length; i++) {
                            let item = this.formData.items[i];

                            if (item.number > 0) {
                                products.push([{
                                    'name':     item.name + '',
                                    'id':       item.id + '',
                                    'price':    item.price * item.number + '',
                                    'quantity': item.number + ''
                                }]);
                            }
                        }
                    }

                    let gtmData = {
                        'ecommerce': {
                            'purchase': {
                                'actionField': {
                                    'transactionId': (response.data.data.id + ''),
                                    'revenue':       (total + ''),
                                    'tax':           (tax + ''),
                                    'coupon':        (coupon + ''),
                                },
                                'products':    products,
                            },
                        },
                    };

                    console.log('Push GTM', gtmData);
                    window.dataLayer.push(gtmData);

                    let metadata = {
                        email: this.formData.email,
                        total: this.total,
                    };

                    window.Intercom('trackEvent', 'pickup-confirmation', metadata);
                    /* jshint ignore:end */

                    this.goStep3();

                } else if (
                    typeof response.data !== 'undefined' && typeof response.data.errors !== 'undefined'
                ) {
                    this.validating = false;
                    this.formErrors = response.data.errors;
                } else {
                    this.validating = false;
                    this.formErrors = {"process": "Unknow System error, please contact support@boxify.be"};
                }
            }, (response) => {
                this.validating = false;
                console.log('Form Errors', response);
                this.formErrors = response.data.data.errors;
            });
        }
    }

    /**
     * Translate a string
     *
     * @param str
     * @returns {*}
     */
    trans(str) {
        return this.$filter('translate')(str);
    }

    /**
     * Update Cart with items selected and calculate the total
     */
    updateCart() {
        this.total = 0;

        if (typeof this.formData.items !== 'undefined') {
            for (let i in this.formData.items) {
                let item = this.formData.items[i];

                this.total = this.total + (item.number * item.price);
            }
        }

        if (typeof this.formData.coupon_applied !== 'undefined') {
            this.total = this.total - this.formData.coupon_applied;
        }

        this.formData.total = this.total;

        if (typeof this.formData.items !== 'undefined') {
            this.globals.formData.items = this.formData.items;
        }
    }

    /**
     * Update the pickupDate
     */
    updatePickupDate() {
        if (this.pickupDate && this.pickupTime) {
            this.formData.pickup_date = this.pickupDate + ' ' + this.pickupTime;
            console.log('New pickup date', this.formData.pickup_date);
        }
    }
}