/**
 * Returns a function, that, as long as it continues to be invoked, will not
 * be triggered. The function will be called after it stops being called for
 * N milliseconds. If `immediate` is passed, trigger the function on the
 * leading edge, instead of the trailing.
 * @see https://davidwalsh.name/essential-javascript-functions
 *
 * @example
 * var myEfficientFn = debounce(function() {
 *     // All the taxing stuff you do
 * }, 250);
 * window.addEventListener('resize', myEfficientFn);
 *
 * @param func
 * @param wait
 * @param immediate
 * @returns {function()}
 */
export default function debounce(func, wait = 50, immediate = false) {
    let timeout;

    return () => {
        const args = arguments;
        const callNow = immediate && !timeout;

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            timeout = null;
            if (!immediate) func(args);
        }, wait);

        if (callNow) func(args);
    };
}