import arrayDot from '../lib/array-dot';
import kindsOf from '../lib/kindsOf';

export default class FormData {
    static data = {};

    get(name, defaults = null) {
        const value = arrayDot.get(FormData.data, name);

        if (typeof value !== 'undefined') {
            return value;
        }

        return defaults;
    }

    set(name, value = null) {
        if (kindsOf(name) === 'object') {
            Object.keys(name).forEach((key) => {
                arrayDot.set(FormData.data, key, name[key]);
            });
        } else if (kindsOf(name) === 'array') {
            name.forEach((val, key) => {
                arrayDot.set(FormData.data, key, val);
            });
        } else {
            arrayDot.set(FormData.data, name, value);
        }

        return this;
    }

    remove(name) {
        arrayDot.delete(FormData.data, name);
        return this;
    }
}