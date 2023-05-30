import $ from 'jquery';
import angular from 'angular';

import clipboard from 'clipboard';
import moment from 'moment-es6';
import adyenEncrypt from 'adyen-cse-js';
import 'intl-tel-input/build/js/utils';
import 'intl-tel-input';
import 'jsvat';

import 'jquery.repeater';
import 'jquery-cookiebar';
import 'jquery.cookie';
import 'jquery-mask-plugin';
import 'jquery-validation';
import 'jquery-validation/additional-methods';
import 'bootstrap-sass';
import 'bootstrap-notify';
import 'bootstrap-datepicker';
import 'owl-carousel';
import 'fancybox';

import * as uiRouter from 'angular-ui-router';
import 'angular-ui-bootstrap';
import 'angular-translate';
import 'angularjs-datepicker';
import 'ng-mask';

import debug from '../lib/debug';
import Router from '../lib/Router';
import '../lib/helpers';

import config from '../config';

export {
    $,
    adyenEncrypt,
    angular,
    config,
    clipboard,
    debug,
    moment,
    Router,
    uiRouter,
};