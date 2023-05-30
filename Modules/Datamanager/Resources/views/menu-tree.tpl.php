@extends('arxmin::shared.datatree')

@section('content')
    <div class="row">
        <div class="col-sm-6 pl-50">
            <a href="<?= moduleUrl('menu/crud?parent_id=' . $id . '&create=true'); ?>"
               class="btn btn-primary"><?= lg('datamanager::index.create'); ?></a>
        </div>
    </div>
    @parent
@stop