export default ($stateProvider, $urlRouterProvider, $locationProvider) => {
    'ngInject';

    $locationProvider.html5Mode(true);

    $stateProvider
        .state('in_storage', {
            url:         '/in_storage',
            templateUrl: '/assets/html/manager-boxes.html',
            controller:  'ManagerController as manager',
        })
        .state('in_transit', {
            url:         '/in_transit',
            templateUrl: '/assets/html/manager-boxes.html',
            controller:  'ManagerController as manager',
        })
        .state('with_me', {
            url:         '/with_me',
            templateUrl: '/assets/html/manager-boxes.html',
            controller:  'ManagerController as manager',
        });

    $urlRouterProvider.otherwise('/in_storage');
};
