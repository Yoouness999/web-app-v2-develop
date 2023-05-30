/**
 * Returns the type of the given value, returning number, string, boolean, function, regexp, array, date, error, null, undefined or object.
 * Based on grunt.util.kindOf.
 *
 * @example
 * kindOf(something) === 'string'
 *
 * @param value
 * @returns {String}
 */
const kindsOf = {};

'Number String Boolean Function RegExp Array Date Error'.split(' ')
    .forEach((k) => kindsOf[`[object ${k}]`] = k.toLowerCase());

export function kindOf(value) {
    if (value === null) {
        return String(value);
    }

    return kindsOf[kindsOf.toString.call(value)] || 'object';
}