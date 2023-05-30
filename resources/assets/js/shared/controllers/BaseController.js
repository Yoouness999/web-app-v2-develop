import Injector from '../traits/Injector';


export default class BaseController extends Injector {
    constructor(...args) {
        super(...args);

        this.isDebug = false;
    }

    /**
     * Display a message in console when `isDebug` is true
     */
    debug() {
        this.isDebug && console.log.apply(console, arguments);
    }
}
