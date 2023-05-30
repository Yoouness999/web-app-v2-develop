function encode(value) {
    if (Object.prototype.toString.call(value) === '[object Date]') {
        return '__date__|' + value.toUTCString();
    }

    if (Object.prototype.toString.call(value) === '[object RegExp]') {
        return '__expr__|' + value.source;
    }

    if (typeof value === 'number') {
        return '__numb__|' + value;
    }

    if (typeof value === 'boolean') {
        return '__bool__|' + (value ? '1' : '0');
    }

    if (typeof value === 'string') {
        return '__strn__|' + value;
    }

    if (typeof value === 'function') {
        return '__strn__|' + value.toString();
    }

    if (value === Object(value)) {
        return '__objt__|' + JSON.stringify(value);
    }

    // hmm, we don't know what to do with it,
    // so just return it as is
    return value;
}

function decode(value) {
    let type, length, source;

    length = value.length;

    if (length < 10) {
        // then it wasn't encoded by us
        return value;
    }

    type = value.substr(0, 8);
    source = value.substring(9);

    switch (type) {
        case '__date__':
            return new Date(source);

        case '__expr__':
            return new RegExp(source);

        case '__numb__':
            return Number(source);

        case '__bool__':
            return Boolean(source === '1');

        case '__strn__':
            return '' + source;

        case '__objt__':
            return JSON.parse(source);

        default:
            // hmm, we reached here, we don't know the type,
            // then it means it wasn't encoded by us, so just
            // return whatever value it is
            return value;
    }
}

function generateFunctions(fn) {
    return {
        local:   fn('local'),
        session: fn('session'),
    };
}

const
    hasStorageItem     = generateFunctions(
        (type) => (key) => window[type + 'Storage'].getItem(key) !== null
    ),

    getStorageLength   = generateFunctions(
        (type) => () => window[type + 'Storage'].length
    ),

    getStorageItem     = generateFunctions((type) => {
        let
            hasFn   = hasStorageItem[type],
            storage = window[type + 'Storage'];

        return (key) => {
            if (hasFn(key)) {
                return decode(storage.getItem(key));
            }

            return null;
        };
    }),

    getStorageAtIndex  = generateFunctions((type) => {
        let
            lengthFn  = getStorageLength[type],
            getItemFn = getStorageItem[type],
            storage   = window[type + 'Storage'];

        return (index) => {
            if (index < lengthFn()) {
                return getItemFn(storage.key(index));
            }
        };
    }),

    getAllStorageItems = generateFunctions((type) => {
        let
            lengthFn  = getStorageLength[type],
            storage   = window[type + 'Storage'],
            getItemFn = getStorageItem[type];

        return () => {
            let
                result = {},
                key,
                length = lengthFn();

            for (let i = 0; i < length; i++) {
                key = storage.key(i);
                result[key] = getItemFn(key);
            }

            return result;
        };
    }),

    setStorageItem     = generateFunctions((type) => {
        let storage = window[type + 'Storage'];
        return (key, value) => { storage.setItem(key, encode(value)); };
    }),

    removeStorageItem  = generateFunctions((type) => {
        let storage = window[type + 'Storage'];
        return (key) => { storage.removeItem(key); };
    }),

    clearStorage       = generateFunctions((type) => {
        let storage = window[type + 'Storage'];
        return () => { storage.clear(); };
    }),

    storageIsEmpty     = generateFunctions((type) => {
        let getLengthFn = getStorageLength[type];
        return () => getLengthFn() === 0;
    });

export const LocalStorage = {
    has:     hasStorageItem.local,
    get:     {
        length: getStorageLength.local,
        item:   getStorageItem.local,
        index:  getStorageAtIndex.local,
        all:    getAllStorageItems.local
    },
    set:     setStorageItem.local,
    remove:  removeStorageItem.local,
    clear:   clearStorage.local,
    isEmpty: storageIsEmpty.local,
};

export const SessionStorage = { // eslint-disable-line one-var
    has:     hasStorageItem.session,
    get:     {
        length: getStorageLength.session,
        item:   getStorageItem.session,
        index:  getStorageAtIndex.session,
        all:    getAllStorageItems.session
    },
    set:     setStorageItem.session,
    remove:  removeStorageItem.session,
    clear:   clearStorage.session,
    isEmpty: storageIsEmpty.session,
};