import routes from './routes';
import PickupController from './PickupController';
import MomentDateFilter from './../../shared/filters/MomentdateFilter';
import ApiService from './../../shared/services/ApiService';
import GplacesDirective from './../../shared/directives/GplacesDirective';
import ValidateCreditCardDirective from './../../shared/directives/ValidateCreditCardDirective';

import angular from 'angular';
import 'angular-ui-router';

angular.module('pickup', ['ui.router', 'pascalprecht.translate', '720kb.datepicker', 'ui.bootstrap', 'ngMask'])
    .run(() => console.log('-> pickup!'))
    .config(routes)
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations(window.__app.lang, window.__app.labels);
        $translateProvider.preferredLanguage(window.__app.lang);
        $translateProvider.useSanitizeValueStrategy('escapeParameters');
    }])
    .filter('momentDate', MomentDateFilter)
    .directive('inputGplaces', GplacesDirective)
    .directive('validateCreditCard', ValidateCreditCardDirective)
    .service('ApiService', ApiService)
    .controller('PickupController', PickupController);