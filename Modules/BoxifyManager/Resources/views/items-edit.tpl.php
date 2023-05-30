@extends('arxmin::layouts.admin')

@section('css')
    @parent
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/redactor/css/redactor.css"/>
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css"/>
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css"/>
    <?= Rapyd::styles() ?>
    <style>
        .datepicker{
            z-index: 3000 !important;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid box">
        <div class="box-body">
            
            <h1><a href="<?= moduleUrl('items'); ?>">Items</a> > Fiche #<?= $source->id. ' '.$source->name; ?></h1>
            
            <div class="row">
                <div class="col-sm-3">
                    <img src="<?= $source->photo ?: '/assets/img/item_'.$source->type.'.png'; ?>" alt="" class="img-responsive img-thumbnail">
                </div>
                <div class="col-sm-9">
                    <h2>Status : <?= Lang::get('items.status.'.$source->status); ?></h2>
                    <h2>Client : <?= HTML::link(moduleUrl('users/crud?modify='.$source->user_id), $source->user->name, ['targer' => '_blank']); ?></h2>
                    <h2>BOXID : <?= $source->box_id ?: '- '; ?></h2>
                    <h2>Transporter : Ilan</h2>

                    @if(isset($instructions))
                        <div class="alert alert-warning">
                            <h2>Special instructions :</h2>
                            <ul>
                                @foreach($instructions as $instruction)
                                 <li><?= $instruction; ?></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($redirect_back))
                        <a class="btn btn-default" href="<?= $redirect_back; ?>"><i class="fa fa-undo"></i> Retour au listing</a>
                    @endif
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Update infos</a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Amendes</a></li>
                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">History</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <?= $form; ?>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">

                                <form action="<?= moduleUrl('fees/create'); ?>">
                                    <h3>Add a fee</h3>
                                    <div class="form-group clearfix">
                                        <label for="status" class="col-sm-2 control-label">Fee : </label>
                                        <div class="col-sm-10" id="div_status">
                                            <?= Form::select('ref', $source->feesList()); ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="status" class="col-sm-2 control-label">Number : </label>
                                        <div class="col-sm-10" id="div_status">
                                            <?= Form::text('nb', 1); ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <input type="hidden" name="item_id" value="<?= $source->id; ?>">
                                        <input type="hidden" name="user_id" value="<?= $source->user_id; ?>">
                                        <button class="btn btn-default btn-block">Add a new fee</button>
                                    </div>
                                </form>
                                <ul class="timeline">

                                    @foreach($source->fees as $fee)
                                        <li>
                                            <!-- timeline icon -->
                                            <i class="fa fa-usd bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> <?= $fee['created_at']; ?></span>
                                                <h3 class="timeline-header"><?= $fee['type']; ?></h3>
                                                <div class="timeline-body">
                                                    <?= Lang::get('fees.'.$fee['ref'].'.description'); ?>

                                                </div>
                                                <div class='timeline-footer'>
                                                    <?= Lang::get('fees.'.$fee['ref'].'.price'); ?>€ - Status : <?= $fee['status']; ?>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">
                                <form action="<?= moduleUrl('logs/create'); ?>" class="form">
                                    <h3>Add a log</h3>
                                    <div class="form-group clearfix" id="fg_status">
                                        <div class="col-sm-12" id="div_status">
                                            <input class="form-control" type="text" name="title" placeholder="title">
                                            <textarea name="content" class="form-control" id="" cols="30" rows="10" placeholder="enter your message"></textarea>
                                            <input type="hidden" name="item_id" value="<?= $source->id; ?>">
                                            <input type="hidden" name="user_id" value="<?= $source->user_id; ?>">
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-default btn-block">Add a log</button>
                                        </div>
                                    </div>
                                </form>
                                <ul class="timeline">
                                    @foreach($source->logs as $log)
                                        <li>
                                            <!-- timeline icon -->
                                            <i class="fa fa-envelope bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> <?= $log['created_at']; ?></span>
                                                <h3 class="timeline-header"><?= $log['title']; ?></h3>
                                                <div class="timeline-body">
                                                    <?= $log['content']; ?>
                                                </div>
                                                <div class='timeline-footer'><?= $log['ref']; ?></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    <?= Rapyd::scripts() ?>
@stop