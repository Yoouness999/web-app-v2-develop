export default function ($stateProvider, $urlRouterProvider) {
    'ngInject';

    $stateProvider
        .state('postalcode', {
            url: '/postalcode',
            templateUrl: '/assets/html/pickup.html',
            controller: 'PickupController as pickup'
        })
        .state('appointment', {
            url: '/appointment',
            templateUrl: '/assets/html/pickup-appointment.html',
            controller: 'PickupController as pickup'
        })
        .state('review', {
            url: '/review',
            templateUrl: '/assets/html/pickup-review.html',
            controller: 'PickupController as pickup'
        })
        .state('confirmation', {
            url: '/confirmation',
            templateUrl: '/assets/html/pickup-confirmation.html',
            controller: 'PickupController as pickup'
        });

    $urlRouterProvider
        .otherwise('/postalcode');
}