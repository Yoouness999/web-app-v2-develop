@extends('arxmin::layouts.admin')

<?php
/**
 * Loader Config
 */
Hook::put('__app.scope.defaultValues', Hook::getJson('scope.defaultValue', (object)[]));
?>

@section('header')
    @parent
    <script>
        window.__app = <?= Hook::getJson('__app'); ?>;
    </script>
@stop

@section('content')
    <div class="container-fluid" ng-controller="formbuilderController">
        <div class="row">
            <div class="col-md-9" style="overflow: scroll;height: 700px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Structure</h3>
                    </div>
                    <div fb-builder="default"></div>
                    <div class="panel-footer">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="isImport"/>
                                Import
                            </label>
                        </div>
                    <textarea class="form-control" ng-if="isImport" ng-change="importForm()" ng-model="formImport"
                              cols="30" rows="10">
                        {{ form | json }}
                    </textarea>

                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="isExport"/>
                                Export
                            </label>
                        </div>
                        <pre ng-if="isExport">{{form}}</pre>

                        <div class="alert alert-success animated fadeIn" ng-if="alertStatus == 'success'">
                            <?php echo __("Updated") ?>
                        </div>
                        <div class="alert alert-error animated fadeIn" ng-if="alertStatus == 'error'">
                            <?php echo __("Errors") ?>
                        </div>
                        <div class="alert alert-info animated fadeIn" ng-if="alertStatus == 'wait'">
                            <i class="fa fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" style="overflow: scroll;height: 700px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Structure</h3>
                    </div>
                    <div class="panel-content">
                        <div fb-components></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><br/>
                <a class="btn btn-primary btn-block pull-right" ng-click="save()" href="#save">Save Data</a>
            </div>
        </div>
    </div>
@stop

@section('css')
    @parent
    <?php

    echo Asset::css([
            moduleAsset('css/datamanager.css'),
    ]);
    ?>
@stop

@section('js')
    @parent
    <?php
    echo Asset::js([
            moduleAsset('js/form-builder.js'),
            moduleAsset('js/form-validator.js'),
            moduleAsset('js/form-rules.js'),
    ]);
    ?>

    @include('datamanager::components.custom')

    <script>
        'use strict';

        angular.module('formbuilder', [
            'builder',
            'builder.components',
            'validator.rules'
        ]);

        angular.module('formbuilder')
                .controller('formbuilderController', formbuilderController);


        formbuilderController.$inject = [
            '$scope', '$http', '$builder', '$validator'
        ];

        function formbuilderController($scope, $http, $builder, $validator) {

            $scope.form = $builder.forms['default'];

            $scope.fields = window.__app.scope.fields;
            $scope.data = window.__app.scope.data;

            for (var key in $scope.fields) {
                $builder.addFormObject('default', $scope.fields[key]);
            }

            $scope.input = [];

            $scope.alertStatus = false;

            $scope.importForm = function () {

                var fields = $scope.formImport;

                for (var key in fields) {
                    $builder.addFormObject('default', fields[key]);
                }
            }


            return $scope.save = function () {

                console.log($scope.form);
                $scope.status = 'wait';

                $http({
                    method: 'post',
                    url: window.__app.api_url + 'form/' + $scope.data.id,
                    data: {
                        action: 'edit',
                        data: {
                            meta: $scope.form
                        }
                    }
                }).success(function (data, status, headers, config) {
                    $scope.alertStatus = 'success';
                }).error(function (data, status, headers, config) {
                    $scope.alertStatus = 'error';
                });
            };
        }

        // bootstrap the app (async)
        angular.element(document).ready(function () {
            angular.bootstrap(document, ['formbuilder']);
        });
    </script>

@stop