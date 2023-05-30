
export default class Debug {
    constructor() {
        this.isDebug = false;
    }

    /**
     * Display a message in console when `isDebug` is true
     */
    debug() {
        this.isDebug && console.log.apply(console, arguments);
    }
}