import ApiService from './../../shared/services/ApiService';


export default class ManagerApi extends ApiService {
    /**
     * @param {Object.$http} $http - Angular $http service
     * @param {Object.$q} $q - Angular $q service
     * @constructor
     * @ngInject
     */
    constructor($http, $q) {
        super($http, $q);

        this.apiUrl = '/profile/api/v1';
        this.timeDiff = 1000 * 60 * 60;
    }

    /**
     * Return the list of availables cities
     *
     * @return {Promise}
     * @public
     */
    getCities(refresh = false) {
        return this.get('cities', {}, refresh);
    }

    getPlan(refresh = null) {
        return this.get('plan', {}, refresh);
    }

    getTypes(refresh = false) {
        return this.get('types', {}, refresh);
    }

    getUser(refresh = false) {
        return this.get('user', {}, refresh);
    }

    checkSchedules(params = {}, refresh = false) {
        return this.get('check-schedules', params, refresh);
    }

    getItems(refresh = false) {
        return this.get('items', {}, refresh);
    }

    postGetBack(params = {}) {
        return this.post('get-back', params);
    }

    postReschedule(params = {}) {
        return this.post('reschedule', params);
    }
}