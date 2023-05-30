import $ from 'jquery';


function query(url, options) {
    options = Object.assign({
        cache:       false,
        crossDomain: true,
        /*headers:     {
            'Access-Control-Allow-Origin': '*',
            'Cache-Control':               'no-cache',
        },*/
        method:      'GET',
        url,
    }, options);

    if (window.__app && window.__app.token) {
        options.headers = {
            'X-CSRF-TOKEN': window.__app.token,
        };
    }

    $.ajax(options);
}

export function getPolygons(city, callback = null) {
    if (!Array.isArray(city)) {
        city = [city];
    }

    const promise = new Promise(function (resolve, reject) {
        const options = {
            data:    {
                city,
            },
            error:   reject,
            success: function (response) {
                resolve(response);
            },
        };

        query('/api/maps/polygons', options);
    });

    if (callback) {
        promise.then(callback);
    }

    return promise;
}

export function getCoordinates(params, callback = null) {
    const promise = new Promise(function (resolve, reject) {
        const options = {
            data:    Object.assign({
                countrycodes: 'BE',
                dedupe: true,
                email: 'private@cherrypulp.com',
                extratags: 0,
                format:  'json',
            }, params),
            error:   reject,
            success: function (response) {
                // const result = response.filter((item) => item.osm_type === 'relation');
                // resolve(result[0]);
                resolve(response);
            },
        };

        query('https://nominatim.openstreetmap.org/search.php', options);
    });

    if (callback) {
        promise.then(callback);
    }

    return promise;
}

export function drawPolygon(polygons, options = {}) {
    polygons = polygons.map(function (polygon) {
        return {
            lat: parseFloat(polygon[1]),
            lng: parseFloat(polygon[0]),
        };
    });

    options = Object.assign({
        fillColor: '#cc003d',
        fillOpacity: 0.4,
        paths: polygons,
        strokeColor: '#cc003d',
        strokeOpacity: 0.4,
        strokeWeight: 2,
    }, options);

    return new window.google.maps.Polygon(options);
}

/*
export function getPolygons(osm_id, callback = null) {
    const promise = new Promise(function (resolve, reject) {
        const options = {
            data:    {
                id: osm_id,
            },
            error:   reject,
            success: function (response) {
                console.log('))) response polygon', response);
            },
        };

        query('http://polygons.openstreetmap.fr/get_geojson.py', options);
    });

    if (callback) {
        promise.then(callback);
    }

    return promise;
}*/
