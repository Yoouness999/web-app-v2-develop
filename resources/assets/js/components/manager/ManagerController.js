import {angular, moment} from '../../bootstrap';
import BaseController from '../../shared/controllers/BaseController';
import {getInt} from "../order/utils";


export default class ManagerController extends BaseController {
    /**
     * @ngInject
     */
    constructor($scope, $state, $filter, $uibModal, ApiProfile, globals) {
        super($scope, $state, $filter, $uibModal, ApiProfile, globals);
        // Debug options
        this.isDebug = this.globals.debug;
        this.isScheduleModeDebug = false;
        this.isScheduleMode = false;
        this.selectedFloor = 0;

        // Questions form
        this.isQuestionsMode = false;
        this.resetAnswers();

        // Setup
        this.state = 'busy';
        this.user = {};
        this.items = [];
        this.plan = {};

        // Filters
        this.filters = {
            sorting: this.trans('filters.sorting'),
            types: this.trans('filters.types'),
        };

        this.formData = {};

        this.type = $state.current.name;
        this.oldType = this.type;

        this.insurance = null;
        this.storing_duration = null;

        this.older_storage_date = moment();

        this.itemsInStorage = [];
        this.itemsWithMe = [];
        this.itemsInTransit = [];
        this.itemsFiltered = [];
        this.itemsSelected = [];
        this.pickups = [];
        this.checkAll = false;
        this.hasSelection = false;
        this.selectedPickup = null;
        this.validatedData = {};

        this.location = null;
        this.text = null;
        this.total = 0;
        this.currency = '€';
        this.current_date = moment();
        this.end_month_date = moment().endOf('month');
        this.diff_days = this.end_month_date.diff(this.current_date, 'days');

        this.minDate = this.globals.minPickupDate || moment().format('YYYY-MM-DD');;

        this.pickupDate = null;
        this.oldPickupDate = null;
        this.pickupTime = null;
        this.vatError = null;
        this.wait_fill_boxes = null;
        this.confirmationFor = null;

        // Set default availableTimes for the time selectbox
        this.defaultAvailableTimes = this.trans('times');
        this.availableTimes = {}; //angular.copy(this.defaultAvailableTimes);
        this.unavailableDates = [];
        this.disabledDates = [];
        this.disabledWeekDays = [0,6]

        /**
         * Api Call
         */
		this.ApiProfile.getCities().then((data) => {
            this.cities = data.data;
        });

        /**
         * Api Call
         */
		this.ApiProfile.getStoringDurations().then((data) => {
            this.storing_durations = data.data;
        });

        this.setupUser();
        this.getItems(true);
        this.setupWatchers();

        //setTimeout(() => this.state = 'ready', 0);
    }

    /**
     * Setup user
     */
    setupUser() {
        this.ApiProfile.getUser(true)
            .then((response) => {
                this.user = response.data;
                this.resetAnswers();

                /*if (this.user.answers) {
                    this.answers = Object.assign({}, this.user.answers);
                } else {
                    this.ApiProfile
                        .getAnswers({id: this.user.id})
                        .then((response) => {
                            if (response.status === 200) {
                                this.user.answers = response.data;
                                this.answers = Object.assign({}, this.user.answers);
                            }
                        });
                }*/

                if (this.user.insurance) {
                    this.insurance = this.user.insurance.slug;
                } else {
                    this.insurance = Object.keys(this.globals.labels.insurances)[0];
                }

                if (this.user.storing_duration) {
                    this.storing_duration = this.user.storing_duration.slug;
                } else {
                    this.storing_duration = this.storing_durations[0];
                }

                if(this.user.plan) {
                    this.plan = this.user.plan.slug;
                    this.planVolume = this.user.plan.volume_m3;
                }

                // user default data if formData is empty
                [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                ].map((key) => {
                    if (!this.formData[key] && this.user[key]) {
                        this.formData[key] = this.user[key];
                    }
                });
            });

        // Check unaivalables dates
        this.checkSchedulesDates();
    }

    /**
     * Setup watchers
     */
    setupWatchers() {
        // Add listener on formData to sync formData between routes
        this.$scope.$watch('formData', () => {
            this.globals.formData = this.formData;
        });

        // Add listener on formData to sync between route
        this.$scope.$watch('manager.pickupDate', () => {
            this.updatePickupDate();
        });

        /* jshint ignore:start */
        // Add listener on Location when Google Places Matches
        this.$scope.$watch('location', (place) => {
            if (typeof place !== 'undefined' && typeof place.geometry !== 'undefined') {
                this.formData.latitude = place.geometry.location.lat();
                this.formData.longitude = place.geometry.location.lng();

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
            }
        });
        /* jshint ignore:end */

        this.$scope.$watch(() => this.checkAll, () => this.toggleCheck());

        this.$scope.$watch('manager.wait_fill_boxes', () => {
            if(this.wait_fill_boxes && this.isAllowedToWait()) {
                this.formData.wait_fill_boxes = this.wait_fill_boxes;
            } else {
                this.formData.wait_fill_boxes = false;
            }
        });
    }

    /**
     * Check if items has selected items
     */
    checkSelection(scheduleClose = true) {
        this.hasSelection = false;
        this.itemsSelected = this.items.filter((item) => item.selected);
        this.hasSelection = this.itemsSelected.length > 0;
        if(!this.hasSelection) {
            this.showCart = false;
            if(scheduleClose) {
                this.scheduleClose();
            }
        } else {
            this.answers.isFragile = false;
            this.answers.volume = 0.00;
            this.itemsSelected.map((item) => {
                if(item.volume_m3 && !isNaN(item.volume_m3)) {
                    this.answers.volume += parseFloat(item.volume_m3);
                }
                if(item.fragile == 1) {
                    this.answers.isFragile = true;
                }
            });
        }

        this.debug('Items selected', this.itemsSelected);
    }

    /**
     *
     * @param entity
     * @return {string}
     */
    getAddressFrom(entity) {
        let address = '';

        if (entity.street) {
            address += entity.street + ' ';
        }

        if (entity.number) {
            address += entity.number + ', ';
        }

        if (entity.postalcode) {
            address += entity.postalcode + ' ';
        }

        if (entity.city) {
            address += entity.city;
        }

        return address;
    }

    /**
     * Get Items from API
     */
    getItems(refresh = false) {
        // Reset all items values
        this.itemsFiltered = [];
        this.itemsInStorage = [];
        this.itemsWithMe = [];
        this.itemsInTransit = [];

        if(refresh) {
            this.itemsSelected = [];
            this.state = 'busy';
            this.ApiProfile.getItems(null, refresh)
            .then((response) => {
                this.items = response.data;
                this.state = 'busy';
                this.ApiProfile.getPickups(refresh)
                .then((response) => {
                    this.pickups = response.data;
                    this.populateItems();
                    this.checkSelection();
                    this.state = 'ready';
                });
            });
        } else {
            this.populateItems();
            this.state = 'ready';
        }
    }

    populateItems() {
        // Refresh storage items nb
        Object.keys(this.items).map((key) => {
            let item = this.items[key];

            item.address = this.getAddressFrom(item);
            item.canBeSelected = true;

            switch (this.type) {
                case 'with_me':
                    if (item.status === 'DELIVERED') {
                        if (this.isScheduleModeDebug) {
                            item.selected = true;
                        }
                        this.itemsFiltered.push(item);
                    }
                    break;
                case 'in_transit':
                    if (item.status === 'TRANSIT' || item.status === 'ORDERED' || item.status === 'READY' || item.status === 'LOADED'  || item.status === 'PICKED-UP' || item.status === 'CREATE') {
                        if (this.isScheduleModeDebug) {
                            item.selected = true;
                        }
                        this.itemsFiltered.push(item);
                    }
                    break;
                case 'in_storage':
                    if (item.status === 'STORED' || item.status === 'DROPPED' || item.status === 'INDEXED') {
                        if (this.isScheduleModeDebug) {
                            item.selected = true;
                        }
                        this.itemsFiltered.push(item);
                    }
                    break;
            }

            /*
            ITEM_CREATE_STATUS = "CREATE";
            ITEM_PICKED_UP_STATUS = "PICKED-UP";
            ITEM_STORED_STATUS = "STORED";
            ITEM_LOADED_STATUS = 'LOADED';
            ITEM_TO_INDEX_STATUS = "TO INDEX";
            ITEM_INDEX_STATUS = "INDEXED";
            ITEM_TRANSIT_STATUS = "TRANSIT";
                */

            if (item.status === 'STORED' || item.status === 'DROPPED' || item.status === 'INDEXED') {
                this.itemsInStorage.push(item);
            } else if (item.status === 'DELIVERED') {
                this.itemsWithMe.push(item);
                item.canBeSelected = false;
            } else if (item.status === 'TRANSIT' || item.status === 'ORDERED' || item.status === 'READY' || item.status === 'LOADED'  || item.status === 'PICKED-UP' || item.status === 'CREATE') {
                this.itemsInTransit.push(item);

                const date = moment(item.pickup_date, 'YYYY-MM-DD HH:mm');

                if (date.diff(moment(), 'hours') < 24) {
                    item.canBeSelected = false;
                }
            }
        });

        Object.keys(this.pickups).map((key) => {
            let pickup = this.pickups[key];
            pickup.address = this.getAddressFrom(pickup);
            pickup.canBeSelected = true;
            let pitemIds = [];
            let pickupItems = [];
            if(pickup.items) {
                Object.keys(pickup.items).map((iKey) => {
                    let item = this.itemsInTransit.find(element => {
                        return (pickup.items[iKey] && element.id == pickup.items[iKey].id);
                    });
                    if(item && !pitemIds.includes(item.id)) {
                        pickupItems.push(item);
                        pitemIds.push(item.id);
                    }
                });
                pickup.items = pickupItems;
            }
            pickup.displayPickupTime = this.getDisplayPickupTime(pickup.pickup_date);
        });
        // Mode schedule debug => open directly the schedule
        if (this.isScheduleModeDebug) {
            this.checkSelection();
            this.schedule();
        }
    }

    isAllowedToResign() {
        return false;//this.itemsFiltered.length < 2 || this.itemsSelected.length === this.itemsFiltered.length;
    }

    isAllowedToWait() {
        let boxItems = this.itemsSelected.filter((item) => {
            return (item.type == 'box' || item.type == 'archived_box'
                || item.type == 'boxify_box' || item.type == 'custom_box'
                || item.tyoe == 'moving_box_large' || item.tyoe == 'moving_box_medium'
                || item.tyoe == 'moving_box_small' || item.tyoe == 'wardobe_box')
        });
        return boxItems.length > 0;
    }

    /**
     * Used with Insurances dropdown
     * @param insurance
     * @return {boolean}
     */
    isInsuranceDisabled(insurance) {
        const insurances = Object.keys(this.trans('insurances'));
        return insurances.indexOf(insurance) <= insurances.indexOf(this.insurance);
    }

    /**
     * Used with Storing Durations dropdown
     * @param storing_duration
     * @return {boolean}
     */
    isStoringDurationDisabled(storing_duration) {
        return this.storing_durations.indexOf(storing_duration) <= this.storing_durations.indexOf(this.storing_duration);
    }

    /**
     * Set the disabled dates for the Datepicker
     *
     * @param dates
     */
    setDisabledDates(dates) {
        this.globals.unavailableDates = this.unavailableDates = dates.map((item) => {
            item.date = moment(item.date, 'YYYY-MM-DD HH:mm:ss').toDate();
            return item;
        });

        Object.keys(this.unavailableDates)
            .map((key) => {
                let date = dates[key].date;
                let oDate = moment(date).hours(0);
                this.disabledDates.push(oDate.toDate());
            });
    }

    /**
     * Check schedules
     */
    checkSchedulesDates() {
        // Check unavailable dates
        let volume = 0.00;
        this.itemsSelected.map((item) => {
            volume += parseFloat(item.volume_m3);
        });

        return this.ApiProfile.checkUnavailableDates({'web': true, 'floor': this.selectedFloor, 'volume': volume}, true).then((response) => this.setDisabledDates(response.data));
    }

    checkSchedulesTimes(date) {
        return this.ApiProfile.checkAvailableTimes({date}).then((response) => {
            this.setDisabledTimes(response)
            this.formData.pickup_time = this.pickupTime;

        });
    }

    /**
     * Set the disabled dates for the Datepicker
     *
     * @param dates
     */
    setDisabledHours() {
        this.checkSchedulesTimes({date: this.pickupDate});
    }

    /**
     * Set the disabled dates for the Datepicker
     *
     * @param dates
     */
    setDisabledTimes(times) {
        // reset available times
        this.availableTimes = {};

        times.map((time) => {
            const [timeStart] = time.value.split('_').map((t) => moment(t));
            const ref = timeStart.format('HH:mm');
            this.availableTimes[ref] = this.defaultAvailableTimes[ref];
        });
        if(!this.availableTimes[this.pickupTime]) {
            this.availableTimes[this.pickupTime] = this.defaultAvailableTimes[this.pickupTime];
        }
        return this.unavailableDates;
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

    userConfirmation(userResponse) {
        $('#orderUpdateConfirmModal').modal('hide');
        if(userResponse) {
            if(this.confirmationFor == 'cancel') {
                this.postCancelSchedule(this.selectedPickup);
            } else if(this.confirmationFor == 'create') {
                this.postGetback(this.validatedData);
            } else if(this.confirmationFor == 'update') {
                this.postReschedule(this.validatedData);
            }
        } else {
            this.state = 'ready';
        }
    }

    postCancelSchedule(pickup) {
        let data = { 'pickupId': pickup.id};
        this.ApiProfile.postCancelSchedule(data)
            .then((response) => {
                this.validating = false;

                if (response.status === 200) {
                    this.debug('Form Success', response);
                    this.formSuccess = true;
                } else {
                    this.debug('Form Errors', response);
                    this.formErrors = response.data;
                }

                this.getItems(true);
                this.itemsSelected = [];
                this.state = 'ready';
            }, (response) => {
                this.validating = false;
                this.debug('Form Errors', response);
                if(response.data) {
                    this.formErrors = response.data.errors;
                } else {
                    this.setError('form', "Something wrong happened on serverside. Please try after sometime or contact support");
                }
                this.getItems();
                this.state = 'ready';
            });
    }

    cancelSchedule(pickup) {
        this.state = 'busy';
        this.confirmationFor = "cancel";
        this.selectedPickup = pickup;
        $('#orderUpdateConfirmModal').modal();
    }

    /**
     * Submit the form Process
     */
     updateSchedule() {
        this.state = 'busy';

        // 1. Check if all the fields are corrects
        let valid = true;

        this.formErrors = null;
        this.formSuccess = false;

        // 2. Check form validation
        if (!this.formReschedule.$valid) {
            valid = false;
            this.setError('form', 'Some fields are required');
        }

        if (typeof this.formData.pickup_date === 'undefined' || this.formData.pickup_date.match('undefined')) {
            valid = false;
            this.setError('date', 'Pickup date is invalid');
        }

		if (typeof this.cities[this.formData.postalcode] === 'undefined') {
            valid = false;
            this.setError('area', 'Area is invalid');
        }

        if(!this.answers || !this.answers.completed) {
            valid = false;
            this.setError('question', 'Delivery services questions are not answered.');
        }

        if (valid === true) {
            // Preparing data for submission
            let data = this.formData;
            this.validating = true;

            // Scroll to top
            // data.itemsIds = [];
            data.total = this.total;

            this.debug('Items', this.itemsSelected, data);

            data.itemsIds = this.itemsSelected.filter((item) => item.selected).map((item) => item.id);

            if (this.answers) {
                data.answers = this.answers;
            }

            if (this.type === 'in_storage') {
                this.confirmationFor = "create";
                this.validatedData = data;
                //$('#orderUpdateConfirmModal').modal();
                this.postGetback(this.validatedData);
            } else {
                let updated = false;
                if(this.selectedPickup) {
                    let oldPickupDate = this.getMoment(this.selectedPickup.pickup_date);
                    let old_pickup_date = `${oldPickupDate.format('YYYY-MM-DD')}`;
                    let old_pickup_time = `${oldPickupDate.format('HH:mm')}:00`;
                    let newPickupDate = data.pickup_date.split(" ")[0];
                    let newPickupTime = data.pickup_date.split(" ")[1];
                    if(old_pickup_date != newPickupDate) {
                        updated = true;
                    } else if(this.selectedPickup.street != data.street
                        || this.selectedPickup.number != data.number
                        || this.selectedPickup.box != data.box
                        || this.selectedPickup.postalcode != data.postalcode
                        || this.selectedPickup.city != data.city
                        || this.selectedPickup.add_infos != data.add_infos
                        || old_pickup_time != newPickupTime) {
                        updated = true;
                    } else if(this.selectedPickup.type == 'delivery' && this.wait_fill_boxes) {
                        updated = true;
                    }
                    if(!updated) {
                        let olditemIds = this.selectedPickup.items.map((item) => item.id);
                        if(this.selectedPickup.items.length == this.itemsSelected.length) {
                            Object.keys(this.itemsSelected).map((k) => {
                                if(!olditemIds.includes(this.itemsSelected[k].id)) {
                                    updated = true;
                                }
                            });
                        } else {
                            updated = true;
                        }
                    }

                    if(!updated) {
                        let oldAnswers = [];
                        Object.keys(this.selectedPickup.answers).map((k) => {
                            let pickupAnswer = this.selectedPickup.answers[k];
                            let answerType = 'number';
                            if(pickupAnswer.value == 'yes' || pickupAnswer.value == 'no') {
                                answerType = 'boolean';
                            }

                            if(!oldAnswers[answerType]) {
                                oldAnswers[answerType] = {};
                            }
                            const questionId = pickupAnswer.answer.order_question_parent_id;
                            oldAnswers[answerType][questionId] = pickupAnswer.value;
                        });
                        if(this.answers['number'] && this.answers['boolean']
                            && this.answers['number'].length == oldAnswers['number'].length
                            && this.answers['boolean'].length == oldAnswers['boolean'].length) {
                                Object.keys(oldAnswers['number']).map((k) => {
                                    if(this.answers['number'][k] != oldAnswers['number'][k]) {
                                        updated = true;
                                    }
                                });

                                if(!updated) {
                                    Object.keys(oldAnswers['boolean']).map((k) => {
                                        if(this.answers['boolean'][k] != oldAnswers['boolean'][k]) {
                                            updated = true;
                                        }
                                    });
                                }
                        } else {
                            updated = true;
                        }
                    }
                }
                if(updated) {
                    data['pickupId'] = this.selectedPickup.id;
                    this.confirmationFor = "update";
                    this.validatedData = data;
                    $('#orderUpdateConfirmModal').modal();
                } else {
                    this.setError('form', 'Nothing to update');
                    this.state = 'ready';
                }
            }
        } else {
            this.state = 'ready';
        }
    }

    postGetback(data) {
        this.ApiProfile
            .postGetBack(data)
            .then((response) => {
                this.validating = false;

                if (response.status === 200) {
                    this.$state.go(this.$state.current.name);
                    this.debug('Form Success', response);
                    this.formSuccess = true;
                } else {
                    this.debug('Form Errors', response);
                    this.formErrors = response.data;
                }

                // remove selection, refresh items and close form
                this.getItems(true);
                this.scheduleClose();

                this.state = 'ready';
            }, (response) => {
                this.validating = false;
                this.debug('Form Errors', response);
                if(response.data) {
                    this.formErrors = response.data.errors;
                } else {
                    this.setError('form', "Something wrong happened on serverside. Please try after sometime or contact support");
                }

                // remove selection, refresh items and close form
                //this.hasSelection = false;
                //this.getItems(true);
                //this.scheduleClose();

                this.state = 'ready';
            });
    }

    postReschedule(data) {
        this.ApiProfile
            .postReschedule(data)
            .then((response) => {
                this.validating = false;
                //this.getItems();

                if (response.status === 200) {
                    this.$state.go(this.$state.current.name);
                    this.debug('Form Success', response);
                    this.formSuccess = true;
                } else {
                    this.debug('Form Errors', response);
                    this.formErrors = response.data;
                }

                    // remove selection, refresh items and close form
                    this.getItems(true);
                    this.scheduleClose();

                    this.state = 'ready';
            }, (response) => {
                this.validating = false;
                this.debug('Form Errors', response);
                if(response.data) {
                    this.formErrors = response.data.errors;
                } else {
                    this.setError('form', "Something wrong happened on serverside. Please try after sometime or contact support");
                }

                this.state = 'ready';
            });
    }
    /**
     * Schedule
     */
    schedule(pickup = null) {
        this.isScheduleMode = true;
        this.formErrors = null;
        this.formSuccess = false;
        if (pickup) {
            //Updating order does not need questions to reanswered again.
            this.isQuestionsMode = false;
            this.resetAnswers();
            this.itemsSelected.map((item) => {
                item.selected = false;
            });
            this.selectedPickup = pickup;
            Object.keys(pickup.items).map((k) => {
                pickup.items[k].selected = true;
            });
            this.checkSelection();

            let propToPopulate = [
                'longitude',
                'latitude',
                'add_infos',
                'street',
                'number',
                'box',
                'postalcode',
                'city'
            ];

            Object.keys(propToPopulate).map((k) => {
                let prop = propToPopulate[k];
                this.formData[prop] = pickup[prop];
            });

            let pickupDate = this.getMoment(pickup.pickup_date);
            //pickup.pickup_date = `${pickupDate.format('YYYY-MM-DD')} ${pickupDate.format('HH:mm')}:00`;
            this.pickupTime = pickupDate.format('HH:mm');
            this.pickupDate = pickupDate.format('YYYY-MM-DD');
            this.initializeAnswers(pickup);
        } else {
            this.checkSelection();
            this.isQuestionsMode = true;
        }
        $('[data-toggle="tooltip"]').tooltip({});
    }

    getMoment(dateStr) {
        let dateMoment = moment(dateStr, 'YYYY-MM-DD HH:mm');
        let hour = dateMoment.get('hour');
        let hourDiff = (hour % 2 == 0)? 2 : 1;
        dateMoment.set('hour', dateMoment.get('hour') + hourDiff);
        return dateMoment;
    }

    getDisplayPickupTime(dateStr) {
        let pickupDate = this.getMoment(dateStr);
        let fromTime = `${pickupDate.format('HH:mm')}`;
        pickupDate.set('hour', pickupDate.get('hour') + 2);
        let toTime= `${pickupDate.format('HH:mm')}`;
        return `${fromTime} - ${toTime}`;
    }

    /**
     * Schedule close
     */
    scheduleClose() {
        if(this.selectedPickup) {
            let propToPopulate = [
                'longitude',
                'latitude',
                'add_infos',
                'street',
                'number',
                'box',
                'postalcode',
                'city',
                'pickup_date'
            ];

            Object.keys(propToPopulate).map((k) => {
                let prop = propToPopulate[k];
                this.formData[prop] = "";
            });

            this.pickupTime = null;
            this.pickupDate = null;
            Object.keys(this.selectedPickup.items).map((k) => {
                this.selectedPickup.items[k].selected = false;
            });
            this.selectedPickup = null;
            this.resetAnswers();
        }
        this.checkSelection(false);
        this.isScheduleMode = false;
        this.isQuestionsMode = false;
        this.showCart = false;
        this.formErrors = null;
        this.formSuccess = false;
    }

    /**
     * Update the pickupDate
     */
    updatePickupDate() {
        if (this.pickupDate && this.pickupDate !== this.oldPickupDate) {
            this.oldPickupDate = this.pickupDate;
            this.checkSchedulesTimes(this.pickupDate);
            let selectedDate = moment(this.pickupDate);
            let secondDay = moment(this.pickupDate).startOf('month').add(1, 'days');
            let last4day = moment(this.pickupDate).endOf('month').subtract(3, 'days');
            if(!this.answers.date) {
                this.answers.date = {};
            }
            if(selectedDate < secondDay || selectedDate > last4day) {
                this.answers.date['busyDay'] = true;
            } else {
                this.answers.date['busyDay'] = false;
            }
        }

        if (this.pickupDate && this.pickupTime) {
            this.formData.pickup_date = `${this.pickupDate} ${this.pickupTime}:00`;
        } else {
            this.formData.pickup_date = "";
            this.formData.pickup_time = "";
            this.oldPickupDate = null;
        }
    }

    /**
     * Update insurance
     * @param value
     */
    updateInsurance(value) {
        const oldInsurance = this.insurance;

        // Show confirmation modal
        const modalInstance = this.$uibModal.open({
            /**
             * @param $scope
             * @param $timeout
             * @param $uibModalInstance
             * @param ApiProfile
             * @param value
             * @ngInject
             */
            controller: function($scope, $timeout, $uibModalInstance, ApiProfile, value) {
                $scope.status = false;

                $scope.cancel = function () {
                    $uibModalInstance.dismiss('cancel');
                };
                $scope.ok = function () {
                    $scope.status = 'loading';

                    // If ok, save via AJAX
                    ApiProfile.postInsurance(value)
                        .then(function (response) {
                            ApiProfile.refreshUpdatedTime('user');

                            $scope.status = 'success';

                            $timeout(function () {
                                $uibModalInstance.close(response.data);
                            }, 1000);
                        }, function () {
                            $scope.status = 'error';

                            $timeout(function () {
                                $scope.status = false;
                            }, 1500);
                        });
                };
            },
            resolve: {
                ApiProfile: () => {
                    return this.ApiProfile;
                },
                value: function () {
                    return value;
                },
            },
            template: `<div class="modal-body">
                <button class="close" type="button" ng-click="cancel()"></button>
                <p>{{ 'modals.insurance' | translate }}</p>
                <button class="btn" type="button" ng-class="{'btn-primary': (status != 'error' && status != 'success'), 'btn-danger': status == 'error', 'btn-success': status == 'success', 'loading': status == 'loading'}" ng-click="ok()">
                    <span ng-show="status != 'error' && status != 'success'">{{ 'modals.ok' | translate }}</span>
                    <span ng-show="status == 'error'"><i class="fa fa-times"></i></span>
                    <span ng-show="status == 'success'"><i class="fa fa-check"></i></span>
                </button>
                <br>
                <button class="btn btn-link" type="button" ng-click="cancel()">{{ 'modals.cancel' | translate }}</button>
            </div>`,
            windowClass: 'modal-insurance',
        });

        modalInstance.result.then((insurance) => {
            this.insurance = insurance.slug;
        }, () => {
            this.insurance = oldInsurance;
        });
    }

    /**
     * Update storing duration
     * @param value
     */
    updateStoringDuration(value) {
        const oldStoringDuration = this.storing_duration;

        // Show confirmation modal
        const modalInstance = this.$uibModal.open({
            /**
             * @param $scope
             * @param $timeout
             * @param $uibModalInstance
             * @param ApiProfile
             * @param value
             * @ngInject
             */
            controller: function($scope, $timeout, $uibModalInstance, ApiProfile, value) {
                $scope.status = false;

                $scope.cancel = function () {
                    $uibModalInstance.dismiss('cancel');
                };
                $scope.ok = function () {
                    $scope.status = 'loading';

                    // If ok, save via AJAX
                    ApiProfile.postStoringDuration(value)
                        .then(function (response) {
                            ApiProfile.refreshUpdatedTime('user');
                            $scope.status = 'success';

                            $timeout(function () {
                                $uibModalInstance.close(response.data);
                            }, 1000);
                        }, function () {
                            $scope.status = 'error';

                            $timeout(function () {
                                $scope.status = false;
                            }, 1500);
                        });
                };
            },
            resolve: {
                ApiProfile: () => {
                    return this.ApiProfile;
                },
                value: function () {
                    return value;
                },
            },
            template: `<div class="modal-body">
                <button class="close" type="button" ng-click="cancel()"></button>
                <p>{{ 'modals.storing_duration' | translate }}</p>
                <button class="btn" type="button" ng-class="{'btn-primary': (status != 'error' && status != 'success'), 'btn-danger': status == 'error', 'btn-success': status == 'success', 'loading': status == 'loading'}" ng-click="ok()">
                    <span ng-show="status != 'error' && status != 'success'">{{ 'modals.ok' | translate }}</span>
                    <span ng-show="status == 'error'"><i class="fa fa-times"></i></span>
                    <span ng-show="status == 'success'"><i class="fa fa-check"></i></span>
                </button>
                <br>
                <button class="btn btn-link" type="button" ng-click="cancel()">{{ 'modals.cancel' | translate }}</button>
            </div>`,
            windowClass: 'modal-storing_duration',
        });

        modalInstance.result.then((storing_duration) => {
            this.storing_duration = storing_duration.slug;
        }, () => {
            this.storing_duration = oldStoringDuration;
        });
    }

    /**
     * Show slideshow
     *
     * @param items
     */
    showSlideshow(e, items) {
        let data = Object.keys(items).map((key) => ({
            href:  items[key],
            title: '',
        }));

        $.fancybox.open(data, {});

        e.stopImmediatePropagation();
    }

    /**
     * Switch between QuestionMode and ScheduleMode
     */
    toggleQuestionsForm(from, floor) {
        if(from != 'answers') {
            if(floor) {
                this.selectedFloor = floor;
            }
            if(!this.answers.date) {
                this.answers.date = {};
            }
        }
        this.isQuestionsMode = !this.isQuestionsMode;
        if(from == 'questions-cancel') {
            this.scheduleClose();
        }
    }

    /**
     * Toggle check Value
     */
    toggleCheck() {
        this.itemsFiltered.map((item) => {
            item.selected = this.checkAll;
        });

        this.checkSelection();
    }

    /**
     * Toggle item
     *
     * @param item
     */
    toggleItem(item) {
        item.selected = !item.selected;
        this.resetAnswers();
        this.checkSelection();
    }

    /**
     * Translate a string
     *
     * @param str
     * @returns {*}
     */
    trans(str) {
        let translation = this.$filter('translate')(str);

        if (translation === str) {
            translation = this.$filter('labels')(str);
        }

        return translation;
    }

    resetAnswers() {
        this.answers = Object.assign({}, {});
        let $question = $('#formQuestions .question.first');
        if($question.length > 0) {
            $question.addClass('active');
            $question.nextAll('.question').removeClass('active');
            $('#formQuestions')[0].reset();
        }
        this.answers.completed = false;
    }

    initializeAnswers(pickup) {
        Object.keys(pickup.answers).map((k) => {
            let pickupAnswer = pickup.answers[k];
            let answerType = 'number';
            if(pickupAnswer.value == 'yes' || pickupAnswer.value == 'no') {
                answerType = 'boolean';
            }

            if(!this.answers[answerType]) {
                this.answers[answerType] = {};
            }

            const questionId = pickupAnswer.answer.order_question_parent_id;
            const $questions = $('#formQuestions .question[data-id="'+questionId+'"]');
            if($questions.length > 0) {
                const $question = $($questions[0]);
                if($question.data("slug") != 'fragile') {
                    $question.addClass('active');
                }
                if(answerType == 'number') {
                    $question.find('input[type="text"]').addClass('active');
                } else {
                    $question.find('label').removeClass('active');
                    $question.find('label.anwser-'+pickupAnswer.value).addClass('active');
                }
                const $answerEle = $question.find('input[type="hidden"][data-id="'+pickupAnswer.order_answer_id+'"]');
                $question.data('answer-appointment', $answerEle.data('appointment'));
                $question.data('answer-label', this.trans($answerEle.data('label')));

                if($question.data("slug") == 'parking') {
                    this.answers.completed = true;
                }
            }
            this.answers[answerType][questionId] = pickupAnswer.value;
        });
    }

    changeTab(tabName) {
        if(this.isScheduleMode || this.isQuestionsMode || this.showCart) {
            return;
        }
        this.type = tabName;
        this.getItems();
    }

    toggleCart() {
        this.showCart = !this.showCart;
        if(!this.answers.completed) {
            this.isQuestionsMode = true;
        }
    }

    toggleScheduleMode() {
        this.isScheduleMode = !this.isScheduleMode;
        if(!this.isScheduleMode) {
            this.oldType = this.type;
            this.type = 'in_storage';
            this.getItems();
        } else {
            this.type = this.oldType;
            this.getItems();
        }
    }
}

