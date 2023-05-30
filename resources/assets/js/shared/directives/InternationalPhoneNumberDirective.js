/**
 * @param $timeout
 * @returns {object}
 * @constructor
 */
export default function InternationalPhoneNumber($timeout) {
    'ngInject';

    return {
        require: '^ngModel',
        restrict: 'A',
        scope: {
            ngModel: '=',
            defaultCountry: '@',
        },
        link(scope, element, attrs, ctrl) {
            let options = {
                autoFormat: true,
                autoHideDialCode: true,
                defaultCountry: '',
                nationalMode: false,
                numberType: '',
                onlyCountries: void 0,
                preferredCountries: ['us', 'gb'],
                responsiveDropdown: false,
                utilsScript: '',
            };

            Object.keys(options).forEach(function (key) {
                let value = options[key];

                if (key === 'preferredCountries') {
                    options.preferredCountries = handleWhatsSupposedToBeAnArray(value);
                } else if (key === 'onlyCountries') {
                    options.onlyCountries = handleWhatsSupposedToBeAnArray(value);
                // } else if (typeof value === 'boolean') {
                //     options[key] = value === 'true';
                } else {
                    options[key] = value;
                }
            });

            let watchOnce = scope.$watch('ngModel', (newValue) => {
                return scope.$$postDigest(() => {
                    options.defaultCountry = scope.defaultCountry;

                    if (newValue !== null && newValue !== void 0 && newValue !== '') {
                        element.val(newValue);
                    }

                    element.intlTelInput(options);

                    if (!(attrs.skipUtilScriptDownload !== void 0 || options.utilsScript)) {
                        if (options.utilsScript === true) {
                            options.utilsScript = '/bower_components/intl-tel-input/lib/libphonenumber/build/utils.js';
                        }
                        element.intlTelInput('loadUtils', options.utilsScript);
                    }

                    return watchOnce();
                });
            });

            ctrl.$formatters.push((value) => {
                if (value) {
                    $timeout(() => {
                        return element.intlTelInput('setNumber', value);
                    });

                    return element.val();
                }

                return value;
            });

            ctrl.$parsers.push((value) => {
                if (!value) {
                    return value;
                }

                return value.replace(/[^\d]/g, '');
            });

            ctrl.$validators.internationalPhoneNumber = (value) => {
                if (value) {
                    return element.intlTelInput('isValidNumber');
                }

                return value;
            };

            element.on('blur keyup change', () => scope.$apply(read));

            element.on('$destroy', () => {
                element.intlTelInput('destroy');

                element.off('blur keyup change');
            });


            function read() {
                return ctrl.$setViewValue(element.val());
            }

            function handleWhatsSupposedToBeAnArray(value) {
                if (value instanceof Array) {
                    return value;
                }

                return value.toString().replace(/[ ]/g, '').split(',');
            }
        }
    };

}