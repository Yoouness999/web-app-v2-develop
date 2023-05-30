@extends('arxmin::layouts.admin')

<?php
/**
 * Generate destinations
 */
$sources = request()->has('debug') ? $actionsToCome : $actionsForToday;
$locations = [];
$destination = "";
foreach ($sources as $item) {
    $locations[] = ["location" => $item->getFullAddress('map'), "stopover" => true];
    $destination = $item->getFullAddress('map');
}
array_pop($locations);
Hook::put('__app.destination', $destination);
Hook::put('__app.locations', $locations);
?>

@section('css')
    @parent
    <?= Asset::css([
            moduleAsset('/plugins/datatables/css/dataTables.bootstrap.min.css'),
            'packages/zofe/rapyd/assets/datepicker/datepicker3.css'
    ]); ?>
    <style type="text/css">
        #map {
            width: 100%;
            height: 500px;
            margin: auto;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyBVGlR_JWv2dL4hTDgBihUg0unUBEc4das&sensor=false&language=fr"></script>
    @parent
    <?= Asset::js([
            moduleAsset('/plugins/datatables/js/jquery.dataTables.min.js'),
            moduleAsset('/plugins/datatables/js/dataTables.bootstrap.min.js'),
            'packages/zofe/rapyd/assets/datepicker/bootstrap-datepicker.js'
    ]) ?>
    <?= Rapyd::scripts() ?>
    <script>
        $(function () {
            $('.table').dataTable();
        });
    </script>

    <?php
        if(count($locations)):
    ?>
    <script>
        var map;
        var panel;
        var initialize;
        var calculate;
        var direction;

        initialize = function () {

            var latLng = new google.maps.LatLng(50.8264869, 4.3597201); // Default Boxify HQ

            var myOptions = {
                zoom: 14, // Zoom par défaut
                center: latLng, // Coordonnées de départ de la carte de type latLng
                mapTypeId: google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
                maxZoom: 20
            };

            map = new google.maps.Map(document.getElementById('map'), myOptions);
            panel = document.getElementById('panel');

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: "Boxify HQ"
            });

            var contentMarker = [].join('');

            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });


            direction = new google.maps.DirectionsRenderer({
                map: map,
                panel: panel // Dom element pour afficher les instructions d'itinéraire
            });

            var infoWindow = new google.maps.InfoWindow({
                content: contentMarker,
                position: latLng
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Boxify HQ');

                    map.setCenter(pos);
                    calculate(pos);

                }, function() {
                    calculate(latLng);
                });
            } else {
                calculate(latLng);
            }
        };

        calculate = function (origin) {
            var request = {
                origin: origin,
                destination: window.__app.destination,
                waypoints: window.__app.locations,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };

            var directionsService = new google.maps.DirectionsService();

            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    direction.setDirections(response);
                }
            });
        };

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
        }

        initialize();
    </script>

    <?php
    endif;
    ?>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header">
                    <h2>Actions à faire aujourd'hui</h2>
                </div>
                <div class="box-body">
                    @if(!count($actionsForToday))
                        <p>Relax, il n'y a rien à déposer aujourd'hui :-)</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Pickup N°</th>
                                <th>User ID</th>
                                <th>Address</th>
                                <th>Loc</th>
                                <th>Link</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($actionsForToday as $item)
                                <tr>
                                    <td><?= $item['pickup_date']; ?></td>
                                    <td><?= $item['pickup_id']; ?></td>
                                    <td><?= $item['user_id']; ?></td>
                                    <td><?= $item->user['full_name']; ?><br>
                                        <?= $item->getFullAddress(); ?></td>
                                    <td><a href="geo:<?= $item['latitude']; ?>, <?= $item['longitude']; ?>"
                                           class="btn btn-default"><i class="fa fa-map-marker"></i></a></td>
                                    <td>
                                        <a href="<?= moduleUrl('users/crud?tab=pickup&modify=' . $item['user_id'] . '&pickup_date=' . $item['pickup_date']); ?>"
                                           class="btn btn-default btn-block"><i class="fa fa-link"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif


                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h2>Actions à venir</h2>
                </div>
                <div class="box-body">
                    @if(!count($actionsToCome))
                        <p>Pas d'actions dans le futur non plus</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Pickup N°</th>
                                <th>User ID</th>
                                <th>Address</th>
                                <th>Link</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($actionsToCome as $item)
                                <tr>
                                    <td><?= $item['pickup_date']; ?></td>
                                    <td><?= $item['pickup_id']; ?></td>
                                    <td><?= $item['user_id']; ?></td>
                                    <td><?= $item->user['full_name']; ?><br>
                                        <?= $item->getFullAddress(); ?></td>
                                    <td>
                                        <a href="<?= moduleUrl('users/crud?tab=pickup&modify=' . $item['user_id'] . '&pickup_date=' . $item['pickup_date']); ?>"
                                           class="btn btn-default btn-block"><i class="fa fa-link"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    <?php
                    echo $actionsToCome->render();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h2>Clients en default de paiement</h2>
                </div>
                <div class="box-body">
                    @if(!count($customerToCheck))
                        <h3>Pas de défault de paiement :-)</h3>
                    @else
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Status</td>
                                <td>Billing Type</td>
                                <td>Billing ID</td>
                                <td>Billing Next Date</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customerToCheck as $user)
                                <tr style="cursor: pointer"
                                    onclick="document.location.href = '<?= (moduleUrl('users/crud?tab=billing&modify=' . $user['id'])); ?>';">
                                    <td><?= $user['id']; ?></td>
                                    <td><?= $user['name']; ?></td>
                                    <td><?= $user['billing_status']; ?></td>
                                    <td><?= $user['billing_type']; ?></td>
                                    <td><?= $user['billing_id']; ?></td>
                                    <td><?= $user['billing_next_date']; ?></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <?php
                        echo $customerToCheck->render();
                        ?>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <?php
    if(count($locations)):
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h2>Itinéraire du jour</h2>
                </div>
                <div class="box-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
@stop
