/**
 * Call a function when a change in a element size is detected.
 * @example
 * <input type="text" validate-credit-card>
 * @param $parse
 * @param $timeout
 * @return {{require: string, link: link}}
 * @constructor
 */
export default function ValidateCreditCardDirective($parse, $timeout) {
    'ngInject';

    return {
        require: 'ngModel',
        link: function (scope, element, attrs, controller) {
            var name = element.attr('name');

            // @see https://gist.github.com/DiegoSalazar/4075533
            // @see http://www.freeformatter.com/credit-card-number-generator-validator.html#cardFormats
            var types = [{
                name: 'amex',
                pattern: /^3[47]/,
                valid_length: [15]
            }, {
                name: 'diners_club_carte_blanche',
                pattern: /^30[0-5]/,
                valid_length: [14]
            }, {
                name: 'diners_club_international',
                pattern: /^36/,
                valid_length: [14]
            }, {
                name: 'jcb',
                pattern: /^35(2[89]|[3-8][0-9])/,
                valid_length: [16]
            }, {
                name: 'laser',
                pattern: /^(6304|670[69]|6771)/,
                valid_length: [16, 17, 18, 19]
            }, {
                name: 'visa_electron',
                pattern: /^(4026|417500|4508|4844|491(3|7))/,
                valid_length: [16]
            }, {
                name: 'visa',
                pattern: /^4/,
                valid_length: [16]
            }, {
                name: 'mastercard',
                pattern: /^5[1-5]/,
                valid_length: [16]
            }, {
                name: 'maestro',
                pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
                valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
            }, {
                name: 'discover',
                pattern: /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
                valid_length: [16]
            }];

            scope.busy = false;

            scope.$watch(attrs.ngModel, function (value) {
                if (value) {
                    var valid = false;

                    scope.busy = true;

                    value = value.replace(/[^0-9]+/ig, '');

                    // update user input with correct value
                    $parse(attrs.ngModel).assign(scope, value);

                    angular.forEach(types, function (type) {
                        if (!valid && type.pattern.test(value) && type.valid_length.indexOf(value.length) > -1) {
                            valid = true;
                            scope.cctype = type.name;
                        }
                    });

                    $timeout(function () {
                        controller.$setValidity(name, valid);

                        scope.busy = false;
                    });
                }
            });
        }
    };
}
