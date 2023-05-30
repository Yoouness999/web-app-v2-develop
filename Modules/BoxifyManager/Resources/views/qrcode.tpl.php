@extends('arxmin::layouts.admin')

@section('content')
    <div class="container-fluid">
        <div ng-app="qrApp" ng-controller="qrController">
            <h2>Generate qr code</h2>
            <br><br>
            <section>
                <h3>Start from : </h3>
                <input ng-model="start" type="number" value="0" placeholder="Enter the number of qr code">
                <h3>To : </h3>
                <input ng-model="to" type="number" value="1" placeholder="Enter the number of qr code">
            </section>

            <hr>

            <div ng-repeat="(key,item) in range(start, to)">
                <div class="text-center pull-left" style="width: 200px;height: 200px;background: #FFF;border: 1px solid #000000;">
                        <img src="https://chart.googleapis.com/chart?cht=qr&chs=180x180&choe=UTF-8&chl={{ urlify(item) }}" alt=""><br>
                        <div >
                            #{{ item }}
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        var app = angular.module('qrApp', []);
        app.controller('qrController', function($scope, $http){

            $scope.to = 1;
            $scope.start = 1;

            $scope.range = function(start, end) {
                var result = [];
                for (var i = start; i <= end; i++) {
                    result.push(i);
                }
                return result;
            };

            $scope.urlify = function(key) {
                return encodeURIComponent('https://www.boxify.be/redirect/scan/'+key);
            };
        });
    </script>
@endsection