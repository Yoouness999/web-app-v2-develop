/**
 * GplacesDirective
 */
export default function GplacesDirective() {
    'ngInject';

    return {
        restrict: 'E',
        replace:  true,
        scope:    {location: '='},
        template: '<input id="google_places_ac" name="google_places_ac" type="text" autocomplete="false" autocorrect="false" />',
        link:     function (scope, elm, attrs) {
            /* jshint ignore:start */
            if (typeof window.google !== 'undefined') {
                var autocomplete = new window.google.maps.places.Autocomplete($("#google_places_ac")[0], {});
                window.google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    scope.location = place;
                    scope.$apply();
                });
            }
            /* jshint ignore:end */
        }
    };
}