
/**
 * Validate field with the given function (accept promise).
 *
 * @example
 * <input type="text" validator="someFunction">
 * <input type="text" validator-ajax="someFunction">
 *
 * @ngInject
 */
export function ValidatorDirective($parse, $timeout) {
    return {
        link: function (scope, element, attrs, ngModel) {
            const name = element.attr('name');

            scope.$watch(attrs.ngModel, function (value) {
                if (value) {
                    if (typeof scope.callback === 'function') {
                        if (scope.callback(value)) {
                            ngModel.$setValidity(name, true);
                        } else {
                            ngModel.$setValidity(name, false);
                        }
                    }
                    //if (attrs.validatorAjax) {
                    //    callback = $parse(attrs.validatorAjax);
                    //
                    //    callback(value)
                    //    .success(function (valid) {
                    //        ngModel.$setValidity(name, valid);
                    //    })
                    //    .error(function (valid) {
                    //        ngModel.$setValidity(name, valid);
                    //    });
                    //} else if (attrs.validator) {
                    //    callback = $parse(attrs.validator);
                    //
                    //    console.log('- validator function', value, attrs.validatorAjax(value));
                    //
                    //    if (callback(value)) {
                    //        ngModel.$setValidity(name, true);
                    //    } else {
                    //        ngModel.$setValidity(name, false);
                    //    }
                    //} else {
                    //    // @todo
                    //}
                }
            }, true);
        },
        require: 'ngModel',
        scope: {
            validator: '&',
        },
    };
}

export function ValidatorAjaxDirective($parse, $timeout) {
    return {
        link: function (scope, element, attrs, ngModel) {

        },
        require: 'ngModel',
        scope: {
            validatorAjax: '&',
        },
    };
}