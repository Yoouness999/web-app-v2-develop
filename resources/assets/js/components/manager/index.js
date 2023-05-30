import {angular, config} from '../../bootstrap';

import routes from './routes';
import QuestionsController from './QuestionsController';
import ManagerController from './ManagerController';
import Answers from './AnswersDirective';
import Questions from './QuestionsDirective';
import BoxItem from './ManagerDirective';
import ApiProfile from '../../shared/api/ApiProfile';
import GplacesDirective from '../../shared/directives/GplacesDirective';
import MomentDateFilter from '../../shared/filters/MomentdateFilter';
import LaravelLabelFilter from '../../shared/filters/LaravelLabelsFilter';

angular.module('manager', ['ui.bootstrap', 'ui.router', 'pascalprecht.translate', '720kb.datepicker'])
    .run(() => config.debug && console.log('-> Manager!'))

    // - Configurations
    .config(routes)
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations(config.lang, config.labels);
        $translateProvider.preferredLanguage(config.lang);
        $translateProvider.useSanitizeValueStrategy('escapeParameters');
    }])

    // - Filters
    .filter('labels', LaravelLabelFilter)
    .filter('momentDate', MomentDateFilter)
    .filter('toArray', function () {
        return function (obj, addKey) {
            if (!angular.isObject(obj)) {
                return obj;
            }

            if (addKey === false) {
                return Object.keys(obj).map(function (key) {
                    return obj[key];
                });
            } else {
                return Object.keys(obj).map(function (key) {
                    let value = obj[key];
                    return angular.isObject(value) ?
                           Object.defineProperty(value, '$key', {
                               enumerable: false,
                               value:      key,
                           }) : {
                               $key: key,
                               $value: value,
                           };
                });
            }
        };
    })

    // - Directives
    .directive('inputGplaces', GplacesDirective)
    .directive('boxItem', BoxItem)
    .directive('answers', Answers)
    .directive('questions', Questions)

    // - Services
    .service('ApiProfile', ApiProfile)

    // - Controllers
    .controller('QuestionsController', QuestionsController)
    .controller('ManagerController', ManagerController);
