@extends('arxmin::layouts.admin')

<?php
$table = 'form';

$structure = [
    'id',
    'title',
    'slug',
    'type',
    'created_at',
    'updated_at',
];

Hook::put('__app.scope.structure', $structure);
Hook::put('__app.scope.type', request()->get('type', 'page'));
?>

@section('content')
    <div id="container" ng-controller="datamanagerController as datamanager">
        <div class="row-fluid">
            <div class="col-sm-12">

                <div class="box">
                    <div class="box-body">
                        <table id="module-datamanager" class="display table datatable arx-table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>

                                </th>
                                @foreach($structure as $key)
                                    <th>
                                        <?php echo $key ?>
                                    </th>
                                @endforeach
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/6.3.0/css/font-awesome.min.css" rel="stylesheet">
    
    @parent
    <?php
    echo Asset::css([
            $theme_url."/plugins/datatables/css/jquery.dataTables.css",
            $theme_url."/plugins/boostrap-checkbox/css/bootstrap-checkbox.css",
            $theme_url."/plugins/datatables-responsive/css/datatables.responsive.css",
            $theme_url."/plugins/jquery-table-editor/examples/plugins/TableTools/css/dataTables.tableTools.css",
            $theme_url."/plugins/jquery-table-editor/dist/css/jquery-table-editor.css",
    ]);
    ?>
    <style>
        table.dataTable tr td:first-child { text-align: center; } table.dataTable tr td:first-child:before { content: "\f096"; /* fa-square-o */ font-family: FontAwesome; } table.dataTable tr.selected td:first-child:before { content: "\f046"; /* fa-check-square-o */ } table.dataTable tr td.dataTables_empty:first-child:before { content: ""; }
    </style>
@stop

@section('js')
    @parent
    <?=
    Asset::js([
            $theme_url."/plugins/datatables/jquery.dataTables.js",
            $theme_url."/plugins/datatables/dataTables.bootstrap.js",
            $theme_url."/plugins/datatables-tabletools/js/dataTables.tableTools.js",
            $theme_url."/plugins/jquery-table-editor/dist/js/jquery-table-editor.js",
    ])
    ?>

    <script>

        var editor;

        $(function(){

            var __app = window.__app;

            var $scope = {};

            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    create: {
                        type: 'POST',
                        url:  "/arxmin/modules/datamanager/api/data"
                    },
                    edit: {
                        type: 'PUT',
                        url:  "/arxmin/modules/datamanager/api/data/_id_"
                    },
                    remove: {
                        type: 'DELETE',
                        url:  "/arxmin/modules/datamanager/api/data/_id_"
                    }
                },
                table: "#module-datamanager",
                fields: [
                    {"label" : "id", "name" : "id"},
                    {"label" : "title", "name" : "title"},
                    {"label" : "slug", "name" : "slug"},
                    {"label" : "type", "name" : "type"},
                    {"label" : "created_at", "name" : "created_at"},
                    {"label" : "updated_at", "name" : "updated_at"}
                ]
            } );

            // Activate an inline edit on click of a table cell
            $('#module-datamanager').on( 'click', 'tbody td:not(:first-child)', function (e) {
                editor.inline( this );
            });

            $('#module-datamanager').DataTable( {
                dom: "Tfrtip",
                ajax: "/arxmin/modules/datamanager/api/data?format=datatable&type="+$scope.type,
                columns: [
                    { data: null, defaultContent: '', orderable: false },
                    {"data" : "id"},
                    {"data" : "title"},
                    {"data" : "slug"},
                    {"data" : "type"},
                    {"data" : "created_at"},
                    {"data" : "updated_at"}                ,
                    {
                        "aTargets": [1],
                        "mData": null,
                        "mRender": function(data, type, full){
                            //console.log(data, type, full);
                            return '<a class="btn btn-default" href="data/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>';
                        }
                    }
                ],
                tableTools: {
                    sRowSelect: "os",
                    aButtons: [
                        { sExtends: "editor_create", editor: editor },
                        { sExtends: "editor_remove", editor: editor }
                    ]
                }
            });
        })
    </script>
@stop
