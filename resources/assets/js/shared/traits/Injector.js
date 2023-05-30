
export default class Injector {
    constructor(...args) {
        // inject every dependency as a class property
        this.constructor.$inject.forEach((name, i) => {
            this[name] = args[i];
        });
    }
}