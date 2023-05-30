@extends('arxmin::layouts.admin')

@section('head')
    @parent
	
@stop


@section('content-header')
<section class="content-header">
    <h1><?= $title ?></h1>

    <ol class="breadcrumb">
        <li><a href="<?= url('arxmin') ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= url('arxmin/modules/datamanager') ?>">Data Manager</a></li>
        <li class="active"><?= $title ?></li>
    </ol>
</section>
@stop


@section('content')
<div class="row">
    <div class="col-sm-12">

        <div class="box">
            @if ($grid->title)
            <div class="box-header">
                <h3 class="box-title"><?= $grid->title ?></h3>
            </div>
            @endif
            <div class="box-body">
				<?= $filter ?>
                <?= $grid ?>
            </div>
        </div>

    </div>
</div>
@stop


@section('css')
@parent
@stop


@section('js')
@parent
<script>
    $(function () {
        $(document).on('click', '[data-confirm]', function (e) {
            var message = $(this).data('confirm') || 'Are you sure?';
            return confirm(message);
        });
    });
</script>
@stop