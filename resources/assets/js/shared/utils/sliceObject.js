/**
 * Return only selected keys of the given object
 * @see http://stackoverflow.com/a/37950530/1420009
 * @TODO - Make a 'only' function that work with arrays and objects
 * @param item
 * @param accepts
 * @return {Object}
 */
export default function sliceObject(item, accepts) {
    return Object.keys(item)
        .filter((key) => accepts.indexOf(key) > -1)
        .reduce((acc, key) => {
            acc[key] = item[key];
            return acc;
        }, {});
}