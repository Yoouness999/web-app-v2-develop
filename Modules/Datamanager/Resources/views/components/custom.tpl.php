<script type="text/javascript">
(function () {

    angular.module('builder.components', ['builder', 'validator.rules']).config([
        '$builderProvider', function ($builderProvider) {
            function setInput(type, label, name, required) {
                var input = [];

                switch (type) {
                    case 'text':
                    case 'email':
                        input = [
                            '<label class="control-label">' + label + '</label>',
                            '<input type="' + type + '" ng-model="' + name + '" ',
                            required && 'validator="[required]" ',
                            'class="form-control"/>',
                        ].join('');
                        break;

                    case 'radio':
                    case 'checkbox':
                        input = [
                            '<div class="' + type + '">',
                                '<label><input type="' + type + '" ng-model="' + name + '" ',
                                required && 'validator="[required]" ',
                                '/> ' + label + '</label>',
                            '</div>',
                        ].join('');
                        break;
                }

                var html = [
                    '<div class="form-group">',
                        input,
                    '</div>',
                ];

                return html.join('');
            }


            $builderProvider.registerComponent('textInput', {
                group: 'Default',
                label: 'Input',
                name: 'input',
                description: 'Input text',
                placeholder: '',
                required: false,
                validationOptions: [
                    {
                        label: 'none',
                        rule: '/.*/'
                    }, {
                        label: 'number',
                        rule: '[number]'
                    }, {
                        label: 'email',
                        rule: '[email]'
                    }, {
                        label: 'url',
                        rule: '[url]'
                    }
                ],
//                controller: function ($scope, $builder, $injector) {
//                    $scope.add = function () {
//
//                    }
//                },
                template: [
                    '<div class="form-group">',
                      '<label for="{{ formName + \'_\' + index }}" class="col-md-4 control-label" ng-class="{\'fb-required\':required}">{{ label }}</label>',
                      '<div class="col-md-8">',
                          '<input type="text" name="meta[{{ name }}]" ng-model="inputText" validator-required="{{ required }}" validator-group="{{ formName }}" id="{{ formName + \'_\' + index }}" class="form-control" placeholder="{{ placeholder }}"/>',
                          '<p class="help-block">{{ description }}</p>',
                      '</div>',
                    '</div>',
                ].join(''),
                popoverTemplate: [
                     '<form>',
                         setInput('text', 'Label', 'label', true),
                         setInput('text', 'Name', 'name', true),
                         setInput('text', 'Description', 'description'),
                         setInput('text', 'Placeholder', 'placeholder'),
                         setInput('checkbox', 'Required', 'required'),
                         '<div class="form-group" ng-if="validationOptions.length > 0">',
                             '<label class="control-label">Validation</label>',
                             '<select ng-model="$parent.validation" class="form-control" ng-options="option.rule as option.label for option in validationOptions"></select>',
                         '</div>',
                         '<hr/>',
                         '<div class="form-group">',
                             '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                             '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                             '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                         '</div>',
                    '</form>'
                 ].join('')
            });

            $builderProvider.registerComponent('fileInput', {
                group: 'Default',
                label: 'File',
                name : 'file',
                description: 'Input file',
                placeholder: '',
                required: false,
                validationOptions: [
                    {
                        label: 'none',
                        rule: '/.*/'
                    }
                ],
                template: [
                '<div class="form-group">',
                    '<label for="{{ formName + \'_\' + index }}" class="col-md-4 control-label" ng-class="{\'fb-required\':required}">{{ label }}</label>',
                    '<div class="col-md-8">',
                        '<div class="input-group">',
                            '<input type="text" name="meta[{{ name }}]" ng-model="inputText" validator-required="{{ required }}" validator-group="{{ formName }}" id="{{ formName + \'_\' + index }}" class="form-control" placeholder="{{ placeholder }}"/>',
                            '<div class="input-group-addon">',
                                '<a href="#" class="popup_selector" data-inputid="{{ formName + \'_\' + index }}">Select</a>',
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>',
                ].join(''),
                popoverTemplate: [
                 '<form>',
                     setInput('text', 'Label', 'label', true),
                     setInput('text', 'Name', 'name', true),
                     setInput('text', 'Description', 'description'),
                     setInput('text', 'Placeholder', 'placeholder'),
                     setInput('checkbox', 'Required', 'required'),
                     '<div class="form-group" ng-if="validationOptions.length > 0">',
                        '<label class="control-label">Validation</label>',
                        '<select ng-model="$parent.validation" class="form-control" ng-options="option.rule as option.label for option in validationOptions"></select>',
                     '</div>',
                     '<hr/>',
                     '<div class="form-group">',
                         '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                         '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                         '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                     '</div>',
                 '</form>'
             ].join('')
            });

            $builderProvider.registerComponent('emailInput', {
                group: 'Default',
                label: 'Email',
                name: 'email',
                description: '',
                placeholder: '',
                required: true,
                validationOptions: [
                    {
                        label: 'email',
                        rule: '[email]'
                    }, {
                        label: 'none',
                        rule: '/.*/'
                    }
                ],
                template: [
                    '<div class="form-group">',
                        '<label for="{{ formName + \'_\' + index }}" class="col-md-4 control-label" ng-class="{\'fb-required\':required}">{{ label }}</label>',
                        '<div class="col-md-8">',
                            '<input type="text" name="meta[{{ name }}]" ng-model="inputText" validator-required="{{ required }}" validator-group="{{ formName }}" id="{{ formName + \'_\' + index }}" class="form-control" placeholder="{{ placeholder }}"/>',
                        '</div>',
                    '</div>',
                ].join(''),
                popoverTemplate: [
                    '<form>',
                         setInput('text', 'Label', 'label', true),
                         setInput('text', 'Name', 'name', true),
                         setInput('text', 'Description', 'description'),
                         setInput('text', 'Placeholder', 'placeholder'),
                         setInput('checkbox', 'Required', 'required'),
                         '<div class="form-group" ng-if="validationOptions.length > 0">',
                             '<label class="control-label">Validation</label>',
                             '<select ng-model="$parent.validation" class="form-control" ng-options="option.rule as option.label for option in validationOptions"></select>',
                         '</div>',
                         '<hr/>',
                         '<div class="form-group">',
                             '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                             '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                             '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                         '</div>',
                     '</form>'
                 ].join('')
            });

            $builderProvider.registerComponent('textArea', {
                group: 'Default',
                label: 'Textarea',
                description: '',
                placeholder: 'placeholder',
                required: false,
                template: [
                    '<div class="form-group">',
                        '<label for="{{ formName + \'_\' + index }}" class="col-md-4 control-label" ng-class="{\'fb-required\':required}">{{ label }}</label>',
                        '<div class="col-md-8">',
                            '<textarea type="text" name="meta[{{ name }}]" ng-model="inputText" validator-required="{{ required }}" validator-group="{{ formName }}" id="{{ formName + \'_\' + index }}" class="form-control" rows="6" placeholder="{{ placeholder }}"/>',
                            '<p class="help-block">{{ description }}</p>',
                        '</div>',
                    '</div>',
                ].join(''),
                popoverTemplate: [
                     '<form>',
                         setInput('text', 'Label', 'label', true),
                         setInput('text', 'Name', 'name', true),
                         setInput('text', 'Description', 'description'),
                         setInput('text', 'Placeholder', 'placeholder'),
                         setInput('checkbox', 'Required', 'required'),
                         '<div class="form-group" ng-if="validationOptions.length > 0">',
                         '<label class="control-label">Validation</label>',
                         '<select ng-model="$parent.validation" class="form-control" ng-options="option.rule as option.label for option in validationOptions"></select>',
                         '</div>',
                         '<hr/>',
                         '<div class="form-group">',
                             '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                             '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                             '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                         '</div>',
                     '</form>'
                 ].join('')
            });

            $builderProvider.registerComponent('checkbox', {
                group: 'Default',
                label: 'Checkbox',
                name: 'checkbox',
                description: 'description',
                placeholder: 'placeholder',
                required: false,
                options: ['value one', 'value two'],
                arrayToText: true,
                template: [
                    '<div class="form-group">',
                        '<label for="{{ formName + \'_\' + index }}" class="col-md-4 control-label" ng-class="{\'fb-required\':required}">{{ label }}</label>',
                        '<div class="col-md-8">',
                            '<input type="hidden" ng-model="inputText" validator-required="{{ required }}" validator-group="{{ formName }}"/>',
                            '<div class="checkbox" ng-repeat="item in options track by $index">',
                                '<label>',
                                    '<input name="meta[{{ name }}][{{ $index }}]" type="checkbox" ng-model="$parent.inputArray[$index]" ng-value="item" ng-checked="$parent.inputArray.indexOf(item) > -1" id="{{ formName + \'_\' + index }}"/> {{ item }}',
                                '</label>',
                            '</div>',
                            '<p class="help-block">{{ description }}</p>',
                        '</div>',
                    '</div>',
                ].join(''),
                popoverTemplate: [
                    '<form>',
                         setInput('text', 'Label', 'label', true),
                         setInput('text', 'Name', 'name', true),
                         setInput('text', 'Description', 'description'),
                         setInput('checkbox', 'Required', 'required'),
                        '<div class="form-group">',
                            '<label class="control-label">Options</label>',
                            '<textarea class="form-control" rows="3" ng-model="optionsText"/>',
                        '</div>',
                        '<hr/>',
                        '<div class="form-group">',
                            '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                            '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                            '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                        '</div>',
                    '</form>',
                ].join('')
            });

            $builderProvider.registerComponent('radio', {
                group: 'Default',
                label: 'Radio',
                description: 'description',
                placeholder: 'placeholder',
                required: false,
                options: ['value one', 'value two'],
                template: "<div class=\"form-group\">\n    <label for=\"{{formName+index}}\" class=\"col-md-4 control-label\" ng-class=\"{'fb-required':required}\">{{label}}</label>\n    <div class=\"col-md-8\">\n        <div class='radio' ng-repeat=\"item in options track by $index\">\n            <label><input name='{{formName+index}}' ng-model=\"$parent.inputText\" validator-group=\"{{formName}}\" value='{{item}}' type='radio'/>\n                {{item}}\n            </label>\n        </div>\n        <p class='help-block'>{{description}}</p>\n    </div>\n</div>",
                popoverTemplate: [
                    '<form>',
                         setInput('text', 'Label', 'label', true),
                         setInput('text', 'Name', 'name', true),
                         setInput('text', 'Description', 'description'),
                        '<div class="form-group">',
                            '<label class="control-label">Options</label>',
                            '<textarea class="form-control" rows="3" ng-model="optionsText"/>',
                        '</div>',

                        '<hr/>',
                        '<div class="form-group">',
                            '<input type="submit" ng-click="popover.save($event)" class="btn btn-primary" value="Save"/>',
                            '<input type="button" ng-click="popover.cancel($event)" class="btn btn-default" value="Cancel"/>',
                            '<input type="button" ng-click="popover.remove($event)" class="btn btn-danger" value="Delete"/>',
                        '</div>',
                    '</form>',
                ].join(''),
            });

            $builderProvider.registerComponent('dateInput', {
                group: 'Default',
                label: 'Date',
                description: '',
                placeholder: 'placeholder',
                required: false,
                validationOptions: [
                    {
                        label: 'none',
                        rule: '/.*/'
                    }
                ],
                template: "<div class=\"form-group\">\n    <label for=\"{{formName+index}}\" class=\"col-md-4 control-label\" ng-class=\"{'fb-required':required}\">{{label}}</label>\n    <p class='help-block'>{{description}}</p>\n     <div class=\"col-md-8\">\n        <input type=\"text\" ng-model=\"dateInput\" validator-required=\"{{required}}\" validator-group=\"{{formName}}\" id=\"{{formName+index}}\" class=\"form-control datepicker\" placeholder=\"{{placeholder}}\"/>\n       </div>\n</div>",
                popoverTemplate: "<form>\n    <div class=\"form-group\">\n        <label class='control-label'>Label</label>\n        <input type='text' ng-model=\"label\" validator=\"[required]\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Description</label>\n        <input type='text' ng-model=\"description\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Placeholder</label>\n        <input type='text' ng-model=\"placeholder\" class='form-control'/>\n    </div>\n    <div class=\"checkbox\">\n        <label>\n            <input type='checkbox' ng-model=\"required\" />\n            Required</label>\n    </div>\n    <div class=\"form-group\" ng-if=\"validationOptions.length > 0\">\n        <label class='control-label'>Validation</label>\n        <select ng-model=\"$parent.validation\" class='form-control' ng-options=\"option.rule as option.label for option in validationOptions\"></select>\n    </div>\n\n    <hr/>\n    <div class='form-group'>\n        <input type='submit' ng-click=\"popover.save($event)\" class='btn btn-primary' value='Save'/>\n        <input type='button' ng-click=\"popover.cancel($event)\" class='btn btn-default' value='Cancel'/>\n        <input type='button' ng-click=\"popover.remove($event)\" class='btn btn-danger' value='Delete'/>\n    </div>\n</form>"
            });

            $builderProvider.registerComponent('country', {
                group: 'Default',
                label: 'Country',
                description: 'Select your country :',
                placeholder: 'placeholder',
                required: false,
                options: <?php echo json_encode(array_values(Lang::get('arx::countries'))); ?>,
                template: "<p class='help-block'>{{description}}</p>\n <div class=\"form-group\">\n    <label for=\"{{formName+index}}\" class=\"col-md-4 control-label\">{{label}}</label>\n    <div class=\"col-md-8\">\n        <select ng-options=\"value for value in options\" id=\"{{formName+index}}\" class=\"form-control\"\n  ng-model=\"inputText\" ng-init=\"inputText = options[0]\"/>\n </div>\n</div>",
                popoverTemplate: "<form>\n    <div class=\"form-group\">\n        <label class='control-label'>Label</label>\n        <input type='text' ng-model=\"label\" validator=\"[required]\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Description</label>\n        <input type='text' ng-model=\"description\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Options</label>\n        <textarea class=\"form-control\" rows=\"3\" ng-model=\"optionsText\"/>\n    </div>\n\n    <hr/>\n    <div class='form-group'>\n        <input type='submit' ng-click=\"popover.save($event)\" class='btn btn-primary' value='Save'/>\n        <input type='button' ng-click=\"popover.cancel($event)\" class='btn btn-default' value='Cancel'/>\n        <input type='button' ng-click=\"popover.remove($event)\" class='btn btn-danger' value='Delete'/>\n    </div>\n</form>"
            });

            $builderProvider.registerComponent('languages', {
                group: 'Default',
                label: 'lang',
                description: 'Choose your language',
                placeholder: 'placeholder',
                required: false,
                options: <?php echo json_encode(Arxmin::getLocales('select')); ?>,
                template: "<p class='help-block'>{{description}}</p>\n <div class=\"form-group\">\n    <label for=\"{{formName+index}}\" class=\"col-md-4 control-label\">{{label}}</label>\n    <div class=\"col-md-8\">\n        <select ng-options=\"value for value in options\" id=\"{{formName+index}}\" class=\"form-control\"\n            ng-model=\"inputText\" ng-init=\"inputText = options[0]\"/>\n </div>\n</div>",
                popoverTemplate: "<form>\n    <div class=\"form-group\">\n        <label class='control-label'>Label</label>\n        <input type='text' ng-model=\"label\" validator=\"[required]\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Description</label>\n        <input type='text' ng-model=\"description\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Options</label>\n        <textarea class=\"form-control\" rows=\"3\" ng-model=\"optionsText\"/>\n    </div>\n\n    <hr/>\n    <div class='form-group'>\n        <input type='submit' ng-click=\"popover.save($event)\" class='btn btn-primary' value='Save'/>\n        <input type='button' ng-click=\"popover.cancel($event)\" class='btn btn-default' value='Cancel'/>\n        <input type='button' ng-click=\"popover.remove($event)\" class='btn btn-danger' value='Delete'/>\n    </div>\n</form>"
            });

            $builderProvider.registerComponent('gender', {
                group: 'Default',
                label: 'Gender',
                description: '',
                placeholder: 'placeholder',
                required: false,
                options: ['M', 'F'],
                template: "<div class=\"form-group\">\n    <label for=\"{{formName+index}}\" class=\"col-md-4 control-label\" ng-class=\"{'fb-required':required}\">{{label}}</label>\n    <div class=\"col-md-8\">\n        <div class='radio' ng-repeat=\"item in options track by $index\">\n            <label><input name='{{formName+index}}' ng-model=\"$parent.inputText\" validator-group=\"{{formName}}\" value='{{item}}' type='radio'/>\n                {{item}}\n            </label>\n        </div>\n        <p class='help-block'>{{description}}</p>\n    </div>\n</div>",
                popoverTemplate: "<form>\n    <div class=\"form-group\">\n        <label class='control-label'>Label</label>\n        <input type='text' ng-model=\"label\" validator=\"[required]\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Description</label>\n        <input type='text' ng-model=\"description\" class='form-control'/>\n    </div>\n    <div class=\"form-group\">\n        <label class='control-label'>Options</label>\n        <textarea class=\"form-control\" rows=\"3\" ng-model=\"optionsText\"/>\n    </div>\n\n    <hr/>\n    <div class='form-group'>\n        <input type='submit' ng-click=\"popover.save($event)\" class='btn btn-primary' value='Save'/>\n        <input type='button' ng-click=\"popover.cancel($event)\" class='btn btn-default' value='Cancel'/>\n        <input type='button' ng-click=\"popover.remove($event)\" class='btn btn-danger' value='Delete'/>\n    </div>\n</form>"
            });
        }
    ]);

}).call(this);
</script>