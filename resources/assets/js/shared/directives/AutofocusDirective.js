/**
 * Autofocus Directive
 *
 * @example
 * angular.module('form').directive('autofocus', AutofocusDirective);
 *
 * @param $timeout
 * @return Object
 * @constructor
 */
export default function AutofocusDirective($timeout) {
    'ngInject';

    return {
        link: function (scope, element) {
            $timeout(function () {
                element[0].focus();
            });
        },
    };
}