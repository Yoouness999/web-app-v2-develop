var app = angular.module('app', ['ui.bootstrap', 'ngAnimate', 'ngTouch', 'ui.grid', 'ui.grid.edit', 'ui.grid.cellNav', 'ui.grid.selection', 'ui.grid.resizeColumns']);

app.controller('modalController', function($scope, $http, $uibModalInstance, locales){

    var __app = window.__app;

    $scope.locales = locales;

    $scope.ok = function () {

        var formData = $('#formLabel').serializeArray();
        var data = {};


        for(var k in formData) {
            var item = formData[k];
            data[item['name']] = item['value'];
        }

        $http.post(__app.ajax.create.url, data).then(function(response) {
            console.log(response);
        }, function(response) {
            console.log(response);
        });

        $uibModalInstance.close();
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('labelmanagerController', ['$scope', '$http', '$uibModal', '$timeout', function ($scope, $http, $uibModal, $timeout) {
    // Load global data
    var __app = window.__app;

    var _this = this;

    $scope.selectedRows = {};

    $scope.gridOptions = {
        enableFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        fastWatch: false,
        enableRowSelection: true,
        enableSelectAll: true,
        selectionRowHeaderWidth: 35,
        rowHeight: 35,
        enableCellEditOnFocus: true,
        editableCellTemplate : "labelEdit.html"
    };

    $scope.gridOptions.columnDefs = [
        {name: 'ref'}
    ];

    for (var k in __app.locales) {
        $scope.gridOptions.columnDefs.push({
            name: k
        });
    }

    $scope.gridOptions.onRegisterApi = function (gridApi) {
        //set gridApi on scope
        $scope.gridApi = gridApi;

        /**
         * Check if
         */
        gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
            /*console.log(
             'edited row id:' + rowEntity.id + ' Column:' + colDef.name + ' newValue:' + newValue + ' oldValue:' + oldValue );*/
            if(newValue !== oldValue) {
                var data = {
                    id: rowEntity.id
                };

                data[colDef.name] = newValue;

                $http.post(__app.ajax.update.url, data);

                $scope.$apply();
            }
        });

        gridApi.selection.on.rowSelectionChanged($scope, checkRow);

        gridApi.selection.on.rowSelectionChangedBatch($scope,function(rows){
            for(var k in rows) {
                var row = rows[k];
                checkRow(row);
            }
        });
    };

    $scope.addRow = function() {

        var modalInstance = $uibModal.open({
            templateUrl: 'labelForm.html',
            controller: 'modalController',
            resolve: {
                locales: function () {
                    return __app.locales;
                }
            }
        });

        modalInstance.result.then(function () {
            $scope.updateRows();
        }, function () {
            $scope.updateRows();
        });
    }

    //$scope.addRow();

    $scope.updateRows = function(){
        console.log('update rows');
        $http.get(__app.ajax.read.url)
            .success(function (response) {
                $scope.gridOptions.data = response.data;
            });
    }

    function checkRow(row) {
        if(row.isSelected){
            $scope.selectedRows[row.entity.id] = row.entity;
        }
    }

    $scope.deleteRow = function deleteRow(){
        console.log('Delete row', $scope.selectedRows);
        for(var k in $scope.selectedRows) {
            $http.delete(__app.ajax.delete.url+'/'+ k).then(function(){
                $scope.updateRows();
            });
        }
    }

    //init
    $scope.updateRows();

}]);
