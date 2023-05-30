import {adyenEncrypt} from '../../bootstrap/libraries';
import {$, config} from "../../bootstrap";

export function getInt(val) {
    if (typeof val === 'undefined' || Number.isNaN(val) || val === '') {
        return 0;
    }

    return parseInt(val, 10);
}

export function getFloat(val, doNotFixDecimal) {
    if (typeof val === 'undefined' || Number.isNaN(val) || val === '') {
        return 0.00;
    }

    let value = parseFloat(val);
    if(!doNotFixDecimal) {
        value = parseFloat(parseFloat(parseFloat(parseFloat(val).toFixed(5)).toFixed(4)).toFixed(3)).toFixed(2);
    }
    return parseFloat(value);
}


export function formatPrice(price) {
    return parseFloat(price).toFixed(2).replace('.', ',');
}

/* Adyen */

export function getAdyenCardValidation(args) {
    let options = {};
    let cseInstance = adyenEncrypt.createEncryption(args.key, options);

    return cseInstance.validate({
        number: args.number,
        cvc:    args.cvc,
        month:  args.month,
        year:   args.year,
    });
}

export function getAdyenCardEncryptedJson(args) {
    let options = {};
    let cseInstance = adyenEncrypt.createEncryption(args.key, options);

    let postData = {
        'adyen-encrypted-data': cseInstance.encrypt({
            number:         args.number,
            cvc:            args.cvc,
            holderName:     args.holderName,
            expiryMonth:    args.expiryMonth,
            expiryYear:     args.expiryYear,
            generationtime: args.generationtime,
        }),
    };

    return JSON.stringify(postData);
}

/**
 * Promise facade from jQuery Deferred
 *
 * @example
 * function fetch(params = {}) {
 *     let options = {
 *         url: '/api/v1/fetch',
 *         params,
 *     };
 *
 *     return promise(function (resolve, reject) {
 *         $.ajax(options).then(resolve, reject);
 *     });
 * }
 *
 * @param {Function} callback
 * @returns {promise}
 */
export function promise(callback) {
    let deferred = $.Deferred();

    callback(deferred.resolve, deferred.reject);

    return deferred.promise();
}


export function parseUrl(url) {
    // @see https://stackoverflow.com/a/21553982/1420009
    const match = url.match(/^(https?\:)\/\/(([^:\/?#]*)(?:\:([0-9]+))?)([\/]{0,1}[^?#]*)(\?[^#]*|)(#.*|)$/);

    if (!match) {
        return false;
    }

    const linkObject = {
        href: url,
        protocol: match[1].replace(':', ''),
        host: match[2],
        hostname: match[3],
        port: match[4],
        pathname: match[5],
        search: match[6],
        params: {},  // => {search: 'test'}
        hash: match[7],
        toString() {
            return `${this.protocol}://${this.hostname}${this.port ? ':' + this.port : ''}${this.pathname}${this.params ? '?' + $.param(this.params) : ''}${this.hash}`;
        },
    };

    if (match[6] && match[6].length > 1) {
        linkObject.params = JSON.parse(`{"${decodeURI(match[6].substring(1)).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"')}"}`);
    }

    return linkObject;
}

export function apiGetPlans(data) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            cache: false,
            data,
            error: reject,
            headers: {
                'Cache-Control': 'no-cache', // prevent query caching
                'Content-Type': undefined,   // while using file upload
            },
            method: 'GET',
            url: '/api/v1/plans',
            success: resolve,
        });
    });
}

/**
 * Simple template string replacement
 * @param {String} template
 * @param {Object} data
 * @return {String}
 */
export function tpl(template, data) {
    for (let p in data) {
        template = template.replace(new RegExp(`{${p}}`, 'g'), data[p]);
    }

    return template;
}