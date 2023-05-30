import camelize from './camelize';

/**
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * The default order is:
 * 1. common:load
 * 2. page_class:load
 * 3. page_class:finalize
 * 4. common:finalize
 *
 * @example
 * const routes = new Router({
 *     common: {
 *         load(config) {
 *             console.log('-> common:load');
 *         },
 *         finalize(config) {
 *             console.log('-> common:finalize');
 *         },
 *     },
 *     fireMe: {
 *         load(config) {
 *             console.log('-> fireMe:load');
 *         },
 *     }
 * });
 *
 * $(document.body).ready(routes.loadModules());
 * @param modules
 */
export default class Router {
    constructor(routes, options = null) {
        this.options = options;
        this.routes = routes;
    }

    fire(route, fn = 'load', args = null) {
        const fire = route !== '' && this.routes[route] && typeof this.routes[route][fn] === 'function';

        if (fire) {
            this.routes[route][fn](args);
        }
    }

    loadEvents() {
        // Fire common init JS
        this.fire('common', 'load', this.options);

        // Fire page-specific init JS, and then finalize JS
        document.body.className
            .toLowerCase()
            .replace(/-/g, '_')
            .split(/\s+/)
            .map(camelize)
            .forEach((className) => {
                this.fire(className, 'load', this.options);
                this.fire(className, 'finalize', this.options);
            });

        // Fire common finalize JS
        this.fire('common', 'finalize', this.options);
    }
}
