const API_URL = "api/url";

/**
 * ApiService
 */
export default class ApiService {

    /**
     * @ngInject
     */
    constructor($http, $timeout) {
        this.$http = $http;
        this.$timeout = $timeout;

        this.api_url = 'api/v1';
        this.app = window.__app;
    }

    call(endpoint, params = {}, refresh = true) {
        if (typeof this.app[endpoint] != 'undefined' && this.app[endpoint] && !refresh) {
            return this.$timeout(() => {
                return this.app[endpoint];
            });
        }

        return this.$http.post(`/${this.api_url}/${endpoint}`, params)
            .then((response) => {
                this.app[endpoint] = response.data.data;
                return response.data.data;
            }, () => []);
    }

    debug(v) {
        if (this.debug) {
            console.log(v);
        }
    }

    getUser(refresh = false) {
        if (this.app.user && !refresh) {
            return this.$timeout(() => {
                return this.app.user;
            });
        }

        return this.$http.get('/api/v1/user').then(function (response) {
            window.__app.user = response.data.data;
            return response.data.data;
        }, function () {
            return [];
        });
    }

    static getUserItems() {
        return window.__app.userItems ? window.__app.userItems : {};
    }

    getCities() {
        return this.call('cities');
    }

    getTypes() {
        return this.$http.get('/api/v1/types').then(function (response) {
            return response.data.data;
        }, function () {
            return [];
        });
    }
}