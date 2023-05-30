'use strict';

import * as hash from 'object-hash';
import Storage from '../Storage';


/**
 * ApiService core class with localStorage capability
 *
 * @example
 * class MyService extends ApiService {
 *     constructor() {
 *         super()
 *
 *         this.timeDiff = 43200000; // 12 hour
 *     }
 *
 *     get(id) {
 *         return this.get('my', {id: id});
 *     }
 * }
 *
 * @TODO
 * - tests
 */
export default class ApiService {
    /**
     * @param {Object.$http} $http - Angular $http service
     * @param {Object.$q} $q - Angular $q service
     * @constructor
     * @ngInject
     */
    constructor($http, $q) {
        'ngInject';
        /**
         * @type {Object.$http}
         */
        this.$http = $http;
        /**
         * @type {Object.$q}
         */
        this.$q = $q;
        /**
         * @type {Object.hash}
         */
        this.hash = hash;
        /**
         * @type {Object.Storage}
         */
        this.storage = new Storage('sessionStorage');

        // @note Should be overridden
        /**
         * @type {String}
         */
        this.apiUrl = '/api/v1/';
        /**
         * @type {Number}
         */
        this.timeDiff = 0;

        /**
         * @type {Boolean}
         */
        this.debug = false;
    }


    /* Public methods
     ---------------------------------------------- */

    /**
     * Clear localStorage
     *
     * @return {ApiService}
     * @public
     */
    clear() {
        this.storage.clear();
        return this;
    }

    /**
     * POST method
     *
     * @param {String} endpoint - The API endpoint
     * @param {Object} params - Query parameters
     * @returns {Promise}
     * @public
     */
    post(endpoint, params = {}) {
        return this._call(endpoint, params, 'post');
    }

    /**
     * DELETE method
     *
     * @param {String} endpoint - The API endpoint
     * @param {Object} params - Query parameters
     * @returns {Promise}
     * @public
     */
    delete(endpoint, params = {}) {
        params._method = 'DELETE';
        return this._call(endpoint, params, 'delete');
    }

    /**
     * GET method
     *
     * @param {String} endpoint - The API endpoint
     * @param {Object} params - Query parameters
     * @param {Boolean} refresh - If true, it will ignore the localStorage data and refresh it
     * @returns {Promise}
     * @public
     */
    get(endpoint, params = {}, refresh = true) {
        let deferred = this.$q.defer();

        let _hash = this.hash(endpoint + JSON.stringify(params));

        if (this._hasToRefresh(_hash) || refresh) {
            this._call(endpoint, params, 'get')
                .then((response) => {
                    this.storage.set(_hash, response);

                    let updated_times = this.storage.get('updated_times', {});
                    updated_times[_hash] = new Date().getTime();
                    this.storage.set('updated_times', updated_times);

                    deferred.resolve(response);
                }, deferred.reject);
        } else {
            let response = this.storage.get(_hash);
            this._debug('✔ API storage success', { get: 'get', endpoint, params }, response);
            deferred.resolve(response);
        }

        return deferred.promise;
    }

    /**
     * PUT method
     *
     * @param {String} endpoint - The API endpoint
     * @param {Object} params - Query parameters
     * @returns {Promise}
     * @public
     */
    update(endpoint, params = {}) {
        params._method = 'PUT';
        return this._call(endpoint, params, 'put');
    }

    /**
     * Force a endpoint to be refreshed in the next query
     * @param {String} endpoint - The API endpoint
     * @return {ApiService}
     * @public
     */
    refreshUpdatedTime(endpoint) {
        let updated_times = this.storage.get('updated_times', {});
        let _hash = this.hash(endpoint + JSON.stringify({}));

        if (updated_times[_hash]) {
            updated_times[_hash] = 0;
            this.storage.set('updated_times', updated_times);
        }

        return this;
    }


    /* Private methods
     ---------------------------------------------- */

    /**
     * Execute a request or return the previously cached result
     *
     * @param {String} endpoint - The API endpoint
     * @param {Object} params - Query parameters
     * @param {String} method - The query HTTP method
     * @returns {Promise}
     * @private
     */
    _call(endpoint, params, method) {
        let deferred = this.$q.defer();

        let _params = {
            headers: {
                'Cache-Control': 'no-cache', // prevent query caching
                //'Content-Type': undefined,   // while using file upload
            },
            method,
            params,
        };

        // if (window.__app && window.__app.token) {
        //     _params.headers['X-CSRF-TOKEN'] = window.__app.token;
        // }

        let request = null;

        // @see https://code.angularjs.org/1.4.7/docs/api/ng/service/$http#shortcut-methods
        if (['patch', 'post', 'put'].indexOf(method) > -1) {
            let tmp = _params.params;
            delete _params.params;
            request = this.$http[method](this.apiUrl + endpoint, tmp, _params);
        } else {
            request = this.$http[method](this.apiUrl + endpoint, _params);
        }

        request
            .then((response) => {
                this._debug('✔ API success', { method, endpoint, params }, response);
                const data = response.data ? response.data : response;
                deferred.resolve(data);
            }, (errors) => {
                this._debug('✘ API error', { method, endpoint, params }, errors);
                const data = errors.data ? errors.data : errors;
                deferred.reject(data);
            });

        return deferred.promise;
    }


    /**
     * Display debug information in console if this.debug is set to true
     *
     * @private
     */
    _debug() {
        this.debug && console.log.apply(console, arguments);
    }

    /**
     * Check if we need to do a request or use the stored data
     *
     * @param {String} hash - A unique reference to the data
     * @param {Number} timeDiff - Time difference to validate the cached data
     * @returns {Boolean}
     * @private
     */
    _hasToRefresh(hash) {
        let updated_times = this.storage.get('updated_times');

        if (!updated_times) {
            updated_times = this.storage.set('updated_times', {});
            return true;
        }

        let updated_time = updated_times[hash];

        return updated_time + this.timeDiff < new Date().getTime() || !this.storage.get(hash);
    }

    /**
     * Convert recursively object to FormData
     *
     * @param {Object} obj
     * @param {FormData} form
     * @param {String} namespace
     * @returns {FormData}
     * @private
     */
    _objectToFormData(obj, form = null, namespace = null) {
        let fd = form || new FormData();
        let formKey;

        for (let property in obj) {
            if (obj.hasOwnProperty(property)) {
                if (namespace) {
                    formKey = namespace + '[' + property + ']';
                } else {
                    formKey = property;
                }

                // if the property is an object, but not a File,
                // use recursivity.
                if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
                    obj[property] = this._objectToFormData(obj[property], fd, formKey);
                } else {
                    // if it's a string or a File object
                    fd.append(formKey, obj[property] || '');
                }
            }
        }

        return fd;
    }
}
