@extends('arxmin::layouts.admin')

@section('content')
    <div class="container-fluid">
        <div ng-app="importApp" ng-controller="importController">
            <h2>Items Importer</h2>

            <h3>Veuillez selectionner un utilisateur :</h3>

            <?php
            echo Form::select('user_id', $users, null, ['ng-model' => "user_id"]);
            ?>

            <br>
            <br>

            <form class="animated fadeIn" action="#" ng-show="user_id">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td width="10%">BOX ID</td>
                    <td width="13%">Type</td>
                    <td>Description</td>
                    <td width="10%">Prix</td>
                    <td width="10%"></td>
                </tr>
                </thead>
                <tbody>
                <tr class="item" ng-repeat="item in items track by $index">
                    <td><input type="text" ng-model="item.box_id" class="form-control"></td>
                    <td>
                        <?php
                        echo Form::select('items[][type]', $types, null, ['ng-model' => "item.type"]);
                        ?>
                    </td>
                    <td><input type="text" ng-model="item.description" class="form-control"></td>
                    <td><input ng-change="getTotal()" type="text" ng-model="item.price" class="form-control"></td>
                    <td>
                        <button ng-click="deleteItem($index)" class="btn btn-default" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                        <a ng-show="loading" href="#"><i class="fa fa-circle-o-notch fa-spin"></i></a>
                        <a ng-show="item.id" href="/arxmin/modules/boxifymanager/items/crud?modify={{ item.id }}" class="btn btn-default" target="_blank">
                            <i class="fa fa-link"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="4">
                            <button ng-click="addItem()" class="btn btn-default btn-block" type="button"><i
                                        class="fa fa-plus"></i> Ajouter un objet
                            </button>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="4">
                            Total:
                        </td>
                        <td>
                            {{ total | currency:"€" :0 }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <button ng-click="saveItems()" class="btn btn-default btn-block" type="button">
                                Sauvegarder
                            </button>
                        </td>
                    </tr>
                </tfooter>
            </table>
            </form>
            <form class="animated fadeIn"  ng-show="user_id" action="#" enctype="multipart/form-data">
                <br><br><br><br>
                <h2>A définir :...</h2>
                <input type="hidden" name="user" ng-model="user_id"/>
                <label for="file">
                    <input type="file" class="form-control" name="file">
                </label>
                <button class="btn btn-default">Importer l'excel</button>
            </form>

            <br><br>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        var app = angular.module('importApp', []);
        app.controller('importController', function ($scope, $http) {

            var defaultItem = {};

            $scope.loading = false;
            $scope.total = 0;
            $scope.users = <?= json_encode($users); ?>;
            $scope.types = <?= json_encode(trans('types')); ?>;
            $scope.user_id = "2";

            $scope.items = [];

            $scope.addItem = function () {
                $scope.items.push({});
                console.log('-', $scope.items);
            };

            $scope.deleteItem = function(key) {
                $scope.items.splice(key, 1);
            };
            $scope.saveItems = function() {
                $scope.loading = true;
                $http.post('/arxmin/modules/boxifymanager/import', {
                    user_id : $scope.user_id,
                    items : $scope.items
                }).then(function(data){
                    $scope.items =  data.data;
                    $scope.loading = false;
                });
            };

            $scope.getTotal = function() {
                console.log('Get total');
                $scope.total = 0;

                angular.forEach($scope.items, function(item){
                    console.log('Item', item.price);
                    $scope.total = parseFloat($scope.total) + parseFloat(item.price);
                });
            };

            $scope.items.push(angular.copy(defaultItem));
        });
    </script>
@endsection