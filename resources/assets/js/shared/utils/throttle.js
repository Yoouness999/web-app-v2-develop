/**
 * Returns a function, that, when invoked, will only be triggered at most once
 * during a given window of time. Normally, the throttled function will run
 * as much as it can, without ever going more than once per `wait` duration.
 *
 * @example
 * var myEfficientFn = throttle(function() {
 *     // All the taxing stuff you do
 * }, 250);
 * window.addEventListener('resize', myEfficientFn);
 *
 * @param callback
 * @param timeout
 * @param context
 * @return {function(...[*]=)}
 */
export default function throttle(callback, timeout = 50, context = window) {
    let to;
    let wait = false;

    return (...args) => {
        let later = () => callback.apply(context, args);

        if (!wait)  {
            later();

            wait = true;

            to = setTimeout(() => wait = false, timeout);
        }
    };
}