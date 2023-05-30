/**
 * @see https://github.com/angular/angular.js/blob/master/src/ng/directive/form.js
 * @see http://www.bennadel.com/blog/2930-using-cmd-enter-to-submit-a-form-in-angularjs.htm?utm_source=javascriptweekly&utm_medium=email
 * @see https://github.com/bennadel/JavaScript-Demos/blob/master/demos/cmd-enter-submit-angularjs/index.htm
 */
export default class FormDirective {
    /**
     * @ngInject
     */
    constructor() {
        this.restrict = 'E';
    }

    link(scope, element, attributes, controller) {

    }
}
