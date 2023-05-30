@extends('arxmin::layouts.admin')

@section('css')
    @parent
    <?= Asset::css([
            moduleAsset('/plugins/datatables/css/dataTables.bootstrap.min.css'),
            'packages/zofe/rapyd/assets/datepicker/datepicker3.css'
    ]); ?>
@stop

@section('js')
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

        $('.text-danger').on('click', function (e) {
            return confirm('Are you sure you want to delete this item?');
        });
    </script>
@stop

@section('content')
    <div class="container-fluid">

        <div class="box">
            @if($grid->title)
                <div class="box-header">
                    <h3 class="box-title"><?= $grid->title; ?></h3>
                </div>
            @endif
            <div class="box-body">
                <?= $filter; ?>
                <?= $grid; ?>
            </div>
        </div>
    </div>
@stop