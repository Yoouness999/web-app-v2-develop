const DEFAULTS = {
    callback: '__google_maps_api_provider__',       //
    key: 'AIzaSyBVGlR_JWv2dL4hTDgBihUg0unUBEc4das',                                      // Api key
    libraries: [],                                  // ['geometry', 'places']
    client: null,                                   // 'yourclientkey'
    version: '3.18',                                // '3.18'
    channel: null,                                  //
    language: null,                                 // 'fr'
    region: null                                    // 'GB'
};

let loading = false;

/**
 * @example
 * load(options, function (google) {
 *     // do something...
 * });
 * @example
 * load(options).then(function (google) {
 *     // do something...
 * });
 *
 * @param options
 * @param callback
 * @return {Promise<any>}
 */
export function load(options = {}, callback = null) {
    const result = new Promise(function (resolve, reject) {
        if (window.google) {
            resolve(window.google);
        } else if (loading) {
            let interval = setInterval(function () {
                if (window.google) {
                    interval && clearInterval(interval);

                    loading = false;
                    resolve(window.google);
                }
            }, 10);
        } else {
            loading = false;

            Object.assign(options, DEFAULTS, options);

            window[options.callback] = function () {
                loading = false;
                resolve(window.google);
            };

            createScript(options, reject);
        }
    });

    if (callback) {
        result.then(callback);
    }

    return result;
}

/**
 * @param options
 * @param errorCallback
 */
function createScript(options, errorCallback) {
    let params = Object.keys(options).map((key) => {
        let value = options[key];

        if (value) {
            return encodeURIComponent(key) + '=' + encodeURIComponent(value);
        }
    });

    console.log(params);

    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?' + params.join('&');

    if (script.addEventListener) {
        script.addEventListener('error', errorCallback);
    } else if (script.attachEvent) {
        script.attachEvent('onError', errorCallback);
    }

    document.body.appendChild(script);
}