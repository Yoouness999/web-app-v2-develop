'use strict';

/**
 * Storage helper (localStorage or sessionStorage)
 *
 * @example
 * import Storage from './Storage';
 *
 * let storage = new Storage('local');
 *
 * // set
 * storage.set('someKey', someValue);
 * // get
 * storage.get('someKey', 'Default value');
 * // get all
 * storage.all();
 * // delete
 * storage.delete('someKey');
 * // clear
 * storage.clear();
 * // chaining
 * const someVar = storage.delete('someKey').set('someKey', someValue).get('someKey');
 */
export default class Storage {
    /**
     * @param {String} type - Type of the storage used (default: 'localStorage')
     * @param {String} prefix - Base prefix (default: '_')
     * @constructor
     */
    constructor(type = 'localStorage', prefix = '_') {
        if (type === 'local') {
            type = 'localStorage';
        } else if (type === 'session') {
            type = 'sessionStorage';
        }

        /**
         * @type {Object}
         * @private
         */
        this._storage = window[type];

        /**
         * @type {Boolean}
         */
        this.debug = false;
        /**
         * @type {String}
         */
        this.prefix = prefix;
    }

    /**
     * Clear storage
     * @return {Storage}
     */
    clear() {
        this._storage.clear();
        return this;
    }

    /**
     * Delete a key from the storage
     *
     * @param {String} key - Key of the value in storage
     * @return {Storage}
     */
    delete(key) {
        this._storage.removeItem(key);
        return this;
    }

    /**
     * Get a value from the storage
     *
     * @param {String} key - Key of the value in storage
     * @param {String} missing - Value to return if 'key' is missing
     * @param {Object} prefix - Custom prefix
     * @returns {Object}
     */
    get(key, missing = null, prefix = null) {
        let value = null;

        key = this._getPrefixedKey(key, prefix);

        try {
            value = JSON.parse(this._storage.getItem(key));
        } catch (e) {
            try {
                if (this._storage[key]) {
                    value = JSON.parse(`{"data": "${this._storage.getItem(key)}"}`);
                }
            } catch (err) {
                this._debug(`WARNING: Could not load the item with key "${key}"`);
            }
        }

        if (value && typeof value.data !== 'undefined') {
            return value.data;
        }

        return missing;
    }

    /**
     * Return all stored values
     *
     * @returns {Array}
     */
    all() {
        let keys = Object.keys(this._storage);
        return keys.map((key) => this.get(key));
    }

    /**
     * Set a value in the storage
     *
     * @param {String} key - Key of the value in storage
     * @param {Mixed} value - Value to store
     * @param {String} prefix - Custom prefix (default: '')
     * @return {Storage}
     */
    set(key, value, prefix = '') {
        key = this._getPrefixedKey(key, prefix);

        try {
            this._storage.setItem(key, JSON.stringify({ data: value }));
        } catch (e) {
            this._debug(`WARNING: {"${key}": "${value}"} not saved because the storage is full.`);
        }

        return this
    }

    /**
     * Return the key prefixed
     *
     * @param {String} key - The key
     * @param {String} prefix - The prefix
     * @returns {String} - Return the key prefixed with 'prefix' or 'this.prefix'
     * @private
     */
    _getPrefixedKey(key, prefix = null) {
        if (prefix) {
            return prefix + key;
        }

        return this.prefix + key;
    }

    /**
     * Display debug information in console if this.debug is set to true
     *
     * @private
     */
    _debug() {
        this.debug && console.log.apply(console, arguments);
    }
}