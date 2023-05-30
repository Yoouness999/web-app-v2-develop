
export default {

    /**
     * Delete properties in object following path
     * @param obj {Object} - The object where delete property
     * @param path {String} - The property path
     * @return {Boolean} - Return false if property has not been found. or true if actual delete
     */
    delete(obj, path) {
        if (!path.forEach) {
            path = path.split('.');
        }

        let tmp = obj;

        for (let i = 0, len = path.length - 1; i < len; ++i) {
            if (!tmp || typeof(tmp = tmp[path[i]]) === 'undefined') {
                return false;
            }
        }

        if (tmp) {
            if (tmp.forEach) {
                tmp.splice(parseInt(path[i], 10), 1);
            } else {
                delete tmp[path[i]];
            }
        }

        return true;
    },

    /**
     * Get property from object following path
     * @param obj {Object} - The object where retrieve property
     * @param path {String} - The property-s path
     * @return {*} - The retrieved value
     */
    get(obj, path) {
        if (!path.forEach) {
            path = path.split('.');
        }

        let tmp = obj;

        for (let i = 0, len = path.length; i < len; ++i) {
            if (!tmp || typeof(tmp = tmp[path[i]]) === 'undefined') {
                return;
            }
        }

        return tmp;
    },

    /**
     * Set property to object following path
     * @param to {Object} - The object where set property
     * @param path {String} - The property's path
     * @param value {*} - The new value
     * @return {*} - The replaced (old) value (if any)
     */
    set(to, path, value) {
        if (!path.forEach) {
            path = path.split('.');
        }

        let tmp = to,
            i = 0,
            old,
            len = path.length - 1;

        for (; i < len; ++i) {
            if (!tmp && typeof(tmp[path[i]]) === 'undefined') {
                tmp = tmp[path[i]] = {};
            } else {
                tmp = tmp[path[i]];
            }
        }

        if (tmp) {
            old = tmp[path[i]];
            tmp[path[i]] = value;
        }

        return old;
    },

};