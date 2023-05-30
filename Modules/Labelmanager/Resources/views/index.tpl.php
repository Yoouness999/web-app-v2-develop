@extends('arxmin::layouts.admin')

@section('css')
    @parent
    <?=
    Asset::css([
            moduleAsset('/plugins/angular-ui-grid/ui-grid.min.css'),
            moduleAsset('/css/labelmanager.css')
    ]);
    ?>
@stop


@section('content-header')
<section class="content-header">
    <h1><?= $title ?></h1>

    <ol class="breadcrumb">
        <li><a href="<?= url('arxmin') ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= url('arxmin/modules/labelmanager') ?>">Labels Manager</a></li>
        <li class="active"><?= $title ?></li>
    </ol>
</section>
@stop


@section('content')
<div id="container" ng-app="app" ng-controller="labelmanagerController">
    <div class="row-fluid">
        <div class="box simple">
            <div class="box-header">
                <div class="row col-xs-6">
                    <h4><?= lg('Label Editor'); ?></h4>
                </div>
                <div class="row col-xs-6">
                    <button type="button" id="removeRow" class="btn btn-alert pull-right" ng-click="deleteRow()">Delete</button>
                    <button type="button" id="addRow" class="btn btn-primary pull-right" ng-click="addRow()">Add new label</button>
                </div>
            </div>
            <div class="box-body">
                <div id="labelgrid" ui-grid="gridOptions" ui-grid-selection ui-grid-edit ui-grid-cellnav ui-grid-resize-columns class="grid"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Export to excel</h3>
                    <p>Export your labels to an excel sheet</p>
                    <a class="btn btn-default" href="<?= $moduleUrl ?>export">
                        <i class="fa fa-download"></i> Download XSL
                    </a>
                </div>
                <div class="icon">
                    <i class="fa fa-exchange"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Import from excel</h3>
                    <p>Import your labels from an excel sheet</p>
                    <form class="row" action="<?= $moduleUrl; ?>import" method="post" enctype="multipart/form-data">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input class="form-control" type="file" name="file" />
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit" name="submit">
                                        <i class="fa fa-upload"></i> Import
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="icon">
                    <i class="fa fa-upload"></i>
                </div>
            </div>
        </div>
    </div>

    <script type="text/ng-template" id="labelEdit.html">
        <div>
            <form class='form' name="inputForm">
                <textarea style="z-index: 1000;position: absolute;width: 20%;" class="form-control" type="INPUT_TYPE" ng-class="'colt' + col.uid" ui-grid-editor ng-model="MODEL_COL_FIELD" rows="2"></textarea>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="labelForm.html">
        <div class="modal-header">
            <h3 class="modal-title">Add a new label</h3>
        </div>
        <div class="modal-body">
            <form class="form" action="#" id="formLabel">
                <div class="form-group pt-10 clearfix">
                    <label for="input_ref" class="col-sm-2 control-label">Ref</label>
                    <div class="col-sm-10">
                        <input id="input_ref" class="form-control" type="text" name="ref" placeholder="Please enter a unique ref" />
                     </div>
                </div>
                <div class="form-group pt-10 clearfix" ng-repeat="(key,item) in locales">
                    <label for="input_ref" class="col-sm-2 control-label">{{key}}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="{{key}}" rows="2"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">Save</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>
</div>
@stop


@section('js')
@parent
<?=
Asset::js([
    moduleAsset('js/plugins.js'),
    moduleAsset('js/labelmanager.js')
])
?>
@stop
