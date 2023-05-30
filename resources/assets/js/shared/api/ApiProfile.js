import ApiService from '../services/ApiService';


export default class ApiProfile extends ApiService {
    /**
     * @param $http
     * @param $q
     * @ngInject
     */
    constructor($http, $q) {
        super($http, $q);

        this.apiUrl = '/';
        this.timeDiff = 1000 * 60 * 60;
        this.debug = true;
    }

    getAnswers(params = {}) {
        return this.get('profile/api/v1/answers', params);
    }

    /**
     * Return the list of availables cities
     * @param refresh
     * @return {Promise}
     */
    getCities(refresh = false) {
        return this.get('profile/api/v1/cities', {}, refresh);
    }

    /**
     * Return the current user's insurance
     * @param status
     * @param refresh
     * @return {Promise}
     */
    getInsurance(status = null, refresh = null) {
        return this.get('profile/api/v1/insurance', {status}, refresh);
    }

    /**
     * Return the current user's items
     * @param status
     * @param refresh
     * @return {Promise}
     */
    getItems(status = null, refresh = null) {
        return this.get('profile/api/v1/items', {status}, refresh);
    }

    /**
     * Return the current user plan
     * @param refresh
     * @return {Promise}
     */
    getPlan(refresh = false) {
        return this.get('profile/api/v1/plan', {}, refresh);
    }

    /**
     * Return the list of available item types
     * @param refresh
     * @return {Promise}
     */
    getTypes(refresh = false) {
        return this.get('profile/api/v1/types', {}, refresh);
    }

    /**
     * Return the current user
     * @param refresh
     * @return {Promise}
     */
    getUser(refresh = false) {
        return this.get('profile/api/v1/user', {}, refresh);
    }

    checkPricingDate(params = {}) {
        return this.get('profile/api/v1/check-pricing-date', params);
    }

    /**
     * Check available schedules for a specific address
     * @param params
     * @param refresh
     * @return {Promise}
     */
    checkSchedules(params = {}, refresh = false) {
        return this.get('profile/api/v1/check-schedules', params, refresh);
    }

    checkUnavailableDates(params = {}, refresh = false) {
        return this.get('profile/api/v1/unavailable-dates', params, refresh);
    }

    checkAvailableTimes(params = {}, refresh = true) {
        return this.get('order/time-slots', params, refresh);
    }

    /**
     * Reschedule a pickup
     * @param params
     * @return {Promise}
     */
    postGetBack(params = {}) {
        return this.post('profile/api/v1/get-back', params);
    }

    postCancelSchedule(params = {}) {
        return this.post('profile/api/v1/cancel-schedule', params);
    }

    /**
     * Update a user insurance
     * @param insurance
     * @return {Promise}
     */
    postInsurance(insurance) {
        return this.post('profile/api/v1/insurance', {insurance});
    }

    /**
     * Reschedule a pickup
     * @param params
     * @return {Promise}
     */
    postReschedule(params = {}) {
        return this.post('profile/api/v1/reschedule', params);
    }

    postServices(services) {
        return this.post('profile/api/v1/services', {services});
    }

    /**
     * Update a user storing duration
     * @param storing_duration
     * @return {Promise}
     */
    postStoringDuration(storing_duration) {
        return this.post('profile/api/v1/storing-duration', {storing_duration});
    }

    /**
     * Get all storing durations
     * @param storing_duration
     * @return {Promise}
     */
     getStoringDurations(refresh = true) {
        return this.get('profile/api/v1/storing-duration', {}, refresh);
    }

    /**
     * Return the current user's deliveries
     * @param refresh
     * @return {Promise}
     */
     getPickups(refresh = null) {
        return this.get('profile/api/v1/pickups', {}, refresh);
    }
}
