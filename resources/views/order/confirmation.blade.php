@extends('layouts.default')

@section('datalayer')
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            'event': 'checkoutConfirmation',
            'pickupTime': '<?= $orderBooking->pickup_date_to ?> - <?= $orderBooking->pickup_date_from ?>', // pickup time provided
            <?php if ($orderBooking->promo_code): ?>
            'coupon': '<?= $orderBooking->promo_code ?>', // coupon code
            <?php endif; ?>
            'paymentType': '<?= $orderBooking->iban ? 'Bank Card' : 'Credit Card' ?>', // Bank Card or Credit Card
            'transactionId': '<?= $orderBooking->getReference() ?>', // Order Id
            'transactionAffiliation': 'Boxify',
            'transactionTotal': '<?= number_format($total, 2, ',', '.') ?>', // Total Amount User Paid
            <?php if ($orderBooking->company_vat_number && $orderBooking->company_address_country): ?>
            'transactionTax': '<?= (isset($countries[$orderBooking->company_address_country]) && isset($countries[$orderBooking->company_address_country]['tax'])) ? $countries[$orderBooking->company_address_country]['tax'] : 21 ?>', // Tax amount if any
            <?php endif; ?>
            'transactionShipping': 0,
            'transactionProducts': [{
                'sku':      'Subscription',
                'name':     '<?= $orderBooking->plan->name ?> <?= $orderBooking->storingDuration->slug ?>', // Product Name
                'category': 'Subscription',
                <?php if ($orderBooking->storingDuration && $orderBooking->storingDuration->discount_percentage > 0): ?>
                'price': '<?= number_format($orderBooking->plan->price_per_month * (1 - ($orderBooking->storingDuration->discount_percentage / 100)), 2) ?>', // Product Price
                <?php else: ?>
                'price': '<?= number_format($orderBooking->plan->price_per_month, 2) ?>', // Product Price
                <?php endif; ?>
                'quantity': 1
            },
                    <?php foreach ($orderBooking->answers as $service): ?>
                {
                    'sku':      'Pickup Services',
                    'name':     '<?= $service->slug ?>',
                    'category': 'Appointment',
                    'price':    '<?= $service->appointment ?>',
                    'quantity': '<?= $service->value_number_to ? $service['value'] : 1 ?>'
                },
                    <?php endforeach; ?>
                    <?php /*if(false): ?>
            {
                'sku': 'Pickup Services',
                'name': 'Floor 3',
                'category': 'Appointment',
                'price': 100,
                'quantity': 1
            }, {
                'sku': 'Pickup Services',
                'name': 'Handling',
                'category': 'Appointment',
                'price': 100,
                'quantity': 1
            }, {
                'sku': 'Pickup Services',
                'name': 'Fragile',
                'category': 'Appointment',
                'price': 50,
                'quantity': 1
            }, {
                'sku': 'Pickup Services',
                'name': 'Parking',
                'category': 'Appointment',
                'price': 100,
                'quantity': 1
            },
        <?php endif;*/ ?>
                    <?php if ($orderBooking->assurance): ?>
                {
                    'sku':      'Insurance',
                    'name':     'Assurance - <?= $orderBooking->assurance->slug ?>',
                    'category': 'Insurance',
                    'price':    '<?= number_format($orderBooking->assurance->price_per_month, 2) ?>',
                    'quantity': 1
                },
                    <?php endif; ?>
                    <?php if ($orderBooking->storingDuration): ?>
                {
                    'sku':      'Duration',
                    'name':     '<?= $orderBooking->storingDuration->slug ?>',
                    'category': 'Duration',
                    'price':    '<?= number_format(($orderBooking->plan->price_per_month * (1 - ($orderBooking->storingDuration->discount_percentage / 100))) - $orderBooking->plan->price_per_month, 2) ?>',
                    'quantity': 1
                }
                <?php endif; ?>
            ]
        });
    </script>
@stop

@section('navbar-default')
    <nav class="navbar navbar-default navbar-fixed-top no-transition">
        @stop

        @section('content')
            <section class="section section--thankyou bg-gray-lighter-ultra">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <h1 class="text-center"><?= lg('order.confirmation.title') ?></h1>

                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <?= lg('order.confirmation.number') ?> <span class="pull-right"><?= $orderBooking->getReference() ?></span>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-unstyled">
                                        @foreach($lines as $line)
                                            <li>
                                                <?= $line->description ?>
                                                <span class="pull-right"><?= $line->price_formatted ?></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <?= lg('order.confirmation.total') ?> <span class="pull-right"><?= number_format($total, 2, ',', '.') ?>€</span>
                                </div>
                            </div>

                            <div class="text-center">
                                <p><?= lg('order.confirmation.follow') ?></p>

                                <a class="btn btn-primary" href="/profile">
                                    <i class="fa fa-user" aria-hidden="true"></i> <?= lg('order.confirmation.client_space') ?>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section class="section section--tips bg-gray-lighter-ultra">
                <div class="container">

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="text-center"><?= lg('order.confirmation.tips.title') ?></h2>

                            <div class="panel panel-default" id="panel-tips">
                                <div class="panel-body">
                                    <h3><?= lg('order.confirmation.tips.sub_title') ?></h3>

                                    <ul class="list-check">
                                        @foreach (lg('order.confirmation.tips.items') as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="panel panel-default" id="panel-forbidden">
                                <div class="panel-body">
                                    <h3><?= lg('order.confirmation.forbidden.title') ?></h3>

                                    <ul class="list-inline">
                                        @foreach (lg('order.confirmation.forbidden.items') as $item)
                                            <li>
                                                <img src="{{ asset($item['img']) }}" alt="{{ $item['text'] }}">
                                                {{ $item['text'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="panel panel-default" id="panel-faq">
                                <div class="panel-body">
                                    <h3><?= lg('order.confirmation.faq.title') ?></h3>

                                    <ul class="list-arrow">
                                        @foreach (lg('order.confirmation.faq.items') as $item)
                                            <li>
                                                <a href="{{ $item['link'] }}">
                                                    {{ $item['text'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
@stop
