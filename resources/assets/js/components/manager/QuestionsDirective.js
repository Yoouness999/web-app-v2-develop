
export default function Questions() {
    'ngInject';
    
    return {
        bindToController: true,
        controller: 'QuestionsController as ctrl',
        restrict: 'E',
        scope: {
            answers: '=',
            callback: '&',
            ngShow: '=',
        },
        templateUrl: '/assets/html/questions.html',
    };
}