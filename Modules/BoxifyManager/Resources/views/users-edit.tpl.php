@extends('arxmin::layouts.admin')

@section('css')
    @parent
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/redactor/css/redactor.css"/>
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css"/>
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css"/>
    <?= Rapyd::styles() ?>
@stop

@section('content')
    <div class="container-fluid box" ng-app="userApp" ng-controller="userCtrl">
        <div class="box-body">

            <h1><a href="<?= moduleUrl('users'); ?>">Users</a> > Fiche #<?= $source->id. ' '.$source->name; ?></h1>

            <div class="row">
                <div class="col-sm-2">
                    <img src="<?= $source->getGravatar(); ?>" alt="" class="img-responsive img-thumbnail">
                </div>
                <div class="col-sm-4">
                    <h2>Name : <?= $source->name ?></h2>
                    <h2>Status : <?= $source->status ?></h2>
                    <h2>Lang : <?= $source->lang ?></h2>
                    <h2>Items : <?= $source->items->count() ?></h2>
                    <h2>Balance Account : <?= $source->getBalanceAccount() ?></h2>
                    <h2>Since : <?= $source->created_at->format('Y/m/d') ?></h2>
                </div>
                <div class="col-sm-4">
                    <h2>Billing status : <?= $source->billing_status?:'-' ?></h2>
                    <h2>Payment method : <?= $source->billing_type?:'-' ?></h2>
                    <h2>Sponsor : - </h2>
                    <h2>Sponsored : - </h2>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="<?= request()->has('tab') ? '' : 'active'; ?>"><a href="#tab_edit" data-toggle="tab" aria-expanded="true">Update infos</a></li>
                            <li class="<?= request()->get('tab') == 'items' ? 'active':''; ?>"><a href="#tab_items" data-toggle="tab" aria-expanded="true">Items</a></li>
                            <li class="<?= request()->get('tab') == 'fees' ? 'active':''; ?>"><a href="#tab_fees" data-toggle="tab" aria-expanded="true">Amendes</a></li>
                            <li class="<?= request()->get('tab') == 'history' ? 'active':''; ?>"><a href="#tab_history" data-toggle="tab" aria-expanded="true">History</a></li>
                            <li class="<?= request()->get('tab') == 'email' ? 'active':''; ?>"><a href="#tab_email" data-toggle="tab" aria-expanded="true">Send email</a></li>
                            <li class="<?= request()->get('tab') == 'invoice' ? 'active':''; ?>"><a href="#tab_invoice" data-toggle="tab" aria-expanded="true">Invoices</a></li>
                            <li class="<?= request()->get('tab') == 'pickup' ? 'active':''; ?>"><a href="#tab_pickup" data-toggle="tab" aria-expanded="true">Pickup</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?= request()->has('tab') ? '' : 'active'; ?>" id="tab_edit">
                                <?= $form; ?>
                            </div><!-- /#tab_edit -->

                            <div class="tab-pane <?= request()->get('tab') == 'items' ? 'active':''; ?>" id="tab_items">
                                <?php

                                    $data = collect($source->items)->map(function($item){
                                        return [
                                                'id' => HTML::link('/arxmin/modules/boxifymanager/items/crud?modify='.$item['id'], $item['id']),
                                                'name' => HTML::link('/arxmin/modules/boxifymanager/items/crud?modify='.$item['id'],$item['name'] ?:'-'),
                                                'description' => $item['description'],
                                                'price' => $item['price'],
                                                'type' => $item['type'],
                                                'status' => $item['status'],
                                                'storage_date' => $item['storage_date']
                                        ];
                                    })->toArray();

                                if (count($data)) {
                                    echo Arx\BootstrapHelper::table($data);
                                }
                                ?>
                            </div><!-- /#tab_items -->

                            <div class="tab-pane <?= request()->get('tab') == 'fees' ? 'active':''; ?>" id="tab_fees">
                                <form action="<?= moduleUrl('fees/create'); ?>">
                                    <h3>Add a fee</h3>
                                    <div class="form-group clearfix">
                                        <label for="status" class="col-sm-2 control-label">Fee : </label>
                                        <div class="col-sm-10" id="div_status">
                                            <?= Form::select('ref', $source->feesList(), null, ['ng-change' => 'changePrice()', 'ng-model' => 'ref']); ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="status" class="col-sm-2 control-label">Price : </label>
                                        <div class="col-sm-10" id="div_status">
                                            <?= Form::text('price', 0, ['ng-model' => 'price']); ?>
                                        </div>
                                    </div>
                                    <?= Form::hidden('nb', 1); ?>
                                    <div class="form-group clearfix">
                                        <input type="hidden" name="user_id" value="<?= $source->id; ?>">
                                        <button class="btn btn-default btn-block">Ajouter une amende</button>
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
                            </div><!-- /#tab_fees -->

                            <div class="tab-pane <?= request()->get('tab') == 'history' ? 'active':''; ?>" id="tab_history">
                                <form action="<?= moduleUrl('logs/create'); ?>" class="form">
                                    <h3>Add a log</h3>
                                    <div class="form-group clearfix" id="fg_status">
                                        <div class="col-sm-12" id="div_status">
                                            <input class="form-control m-10" type="text" name="title" placeholder="title">
                                            <input class="form-control m-10" type="text" name="ref" placeholder="Référence interne">
                                            <textarea name="content m-10" class="form-control" id="" cols="30" rows="10" placeholder="enter your message"></textarea>
                                            <input type="hidden" name="user_id" value="<?= $source->user_id; ?>">
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-default btn-block">Add a log</button>
                                        </div>
                                    </div>
                                </form>
                                <ul class="timeline">
                                    @foreach($source->logs()->orderBy('created_at', 'DESC')->get()->toArray() as $log)
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
                            </div><!-- /#tab_history -->

                            <div class="tab-pane <?= request()->get('tab') == 'email' ? 'active':''; ?>" id="tab_email">
                                @if(isset($mailsent))
                                    <div class="alert alert-success">Email envoyé</div>
                                @endif
                                <form action="?modify=<?= $source->id; ?>&tab=email" method="post" class="form">
                                    <h3>Envoyer un email</h3>
                                    <div class="form-group clearfix" id="fg_status">
                                        <div class="col-sm-12" id="div_status">
                                            <input class="form-control" type="text" name="title" placeholder="title">
                                            <textarea name="content" class="form-control" id="" cols="30" rows="10" placeholder="enter your message"></textarea>
                                            <input type="hidden" name="user_id" value="<?= $source->user_id; ?>">
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-default btn-block">Send an email</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /#tab_history -->

                            <div class="tab-pane <?= request()->get('tab') == 'invoice' ? 'active':''; ?>" id="tab_invoice">
                                <ul class="timeline">
                                    @foreach($source->invoices as $invoice)
                                        <li>
                                            <!-- timeline icon -->
                                            <i class="fa fa-envelope bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> <?= $invoice['created_at']; ?></span>
                                                <h3 class="timeline-header"><?= $invoice['title']; ?></h3>
                                                <div class="timeline-body">
                                                    <?= $invoice['content']; ?>
                                                </div>
                                                <div class='timeline-footer'><?= $invoice['ref']; ?></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane <?= request()->get('tab') == 'pickup' ? 'active':''; ?>" id="tab_pickup">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Status</td>
                                        <td>Pickup Option</td>
                                        <td>Picture Option</td>
                                        <td>Price</td>
                                        <td>Edit</td>
                                    </tr>
                                    </thead>
                                    @foreach($pickupItems as $item)
                                        <tr>
                                            <td>
                                                <?= $item['id']; ?>
                                            </td>
                                            <td>
                                                <?= $item['name']; ?>
                                            </td>
                                            <td>
                                                <?= $item['status']; ?>
                                            </td>
                                            <td>
                                                <?= $item['pickup_option']; ?>
                                            </td>
                                            <td>
                                                <?= $item['picture_option']; ?>
                                            </td>
                                            <td>
                                                <?= $item['price']; ?>
                                            </td>
                                            <td>
                                                @if($item['status'] == \App\Item::STATUS_IN_TRANSIT && $item['pickup_option'] == "delayed")
                                                <a class="btn btn-block btn-default" href="<?= moduleUrl('items/crud?modify='.$item['id'].'&status='.\App\Item::STATUS_DELIVERED); ?>"><i class="fa fa-pencil"></i></a>
                                                @elseif($item['status'] == \App\Item::STATUS_IN_TRANSIT && $item['pickup_option'] != "delayed")
                                                    <a class="btn btn-block btn-default" href="<?= moduleUrl('items/crud?modify='.$item['id'].'&storage_date='.date('Y-m-d').'&status='.\App\Item::STATUS_STORED); ?>"><i class="fa fa-pencil"></i></a>
                                                @elseif($item['status'] == \App\Item::STATUS_DELIVERED)
                                                    <a class="btn btn-block btn-default" href="<?= moduleUrl('items/crud?modify='.$item['id'].'&storage_date='.date('Y-m-d').'&status='.\App\Item::STATUS_STORED); ?>"><i class="fa fa-pencil"></i></a>
                                                @else
                                                    <i class="fa fa-check"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
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

    <script>
        var app = angular.module('userApp', []);
        app.controller('userCtrl', function($scope, $http){
            $scope.fees = <?= json_encode(lg('fees')); ?>;
            $scope.price = '-';
            $scope.changePrice = function(){
                console.log('Change ref', $scope.ref);
                $scope.price = $scope.fees[$scope.ref].price;
            }
        });
    </script>
@stop
