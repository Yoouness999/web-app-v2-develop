/**
 * Call a function when a change in a element size is detected.
 * @example
 * angular.module('form').directive('validateVat', ValidateVatDirective);
 * @param $parse
 * @param $http
 * @return {{require: string, link: link}}
 * @constructor
 */
export default function ValidateVatDirective($parse, $http) {
    'ngInject';

    return {
        require: 'ngModel',
        link: function (scope, element, attrs, controller) {
            var name = element.attr('name');

            scope.busy = false;

            scope.$watch(attrs.ngModel, function (value) {
                if (value) {
                    scope.busy = true;

                    value = value.replace(/[^A-Z0-9]+/ig, '');

                    // update user input with correct value
                    $parse(attrs.ngModel).assign(scope, value);

                    if (/^((AT)?U[0-9]{8}|(BE)?0[0-9]{9}|(BG)?[0-9]{9,10}|(CY)?[0-9]{8}L|(CZ)?[0-9]{8,10}|(DE)?[0-9]{9}|(DK)?[0-9]{8}|(EE)?[0-9]{9}|(EL|GR)?[0-9]{9}|(ES)?[0-9A-Z][0-9]{7}[0-9A-Z]|(FI)?[0-9]{8}|(FR)?[0-9A-Z]{2}[0-9]{9}|(GB)?([0-9]{9}([0-9]{3})?|[A-Z]{2}[0-9]{3})|(HU)?[0-9]{8}|(IE)?[0-9]S[0-9]{5}L|(IT)?[0-9]{11}|(LT)?([0-9]{9}|[0-9]{12})|(LU)?[0-9]{8}|(LV)?[0-9]{11}|(MT)?[0-9]{8}|(NL)?[0-9]{9}B[0-9]{2}|(PL)?[0-9]{10}|(PT)?[0-9]{9}|(RO)?[0-9]{2,10}|(SE)?[0-9]{12}|(SI)?[0-9]{8}|(SK)?[0-9]{10})$/.test(value)) {
                        if (attrs.remote) {
                            var tmp = [];

                            tmp[name] = value;

                            $http.post(attrs.remote, tmp)
                                .success(function (response) {
                                    if (response) {
                                        controller.$setValidity(name, true);
                                    } else {
                                        controller.$setValidity(name, false);
                                    }

                                    scope.busy = false;
                                })
                                .error(function () {
                                    controller.$setValidity(name, true);

                                    scope.busy = false;
                                });
                        } else {
                            controller.$setValidity(name, true);

                            scope.busy = false;
                        }
                    } else {
                        controller.$setValidity(name, false);

                        scope.busy = false;
                    }
                }
            });
        }
    };
}