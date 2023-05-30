@extends('layouts.html')

@section('head')
<?php
echo HTML::style('/assets/css/main.css');
?>
<style type="text/css" media="print">
    body {
        color: #000000 !important;
    }

    @page {
        color: #000000;
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
</style>
@stop

@section('body')
<div class="container" style="font-size: 14px;max-width: 900px;">

    <div class="row">
        <div class="col-sm-9 col-xs-9">
            @if($aInvoice['type'] == \App\Invoice::TYPE_CREDIT_NOTE)
                <h1><?= lg("invoice.Credit note") ?></h1>
            @else
                <h1><?= lg("invoice.Invoice") ?></h1>
            @endif
        </div>
        <div class="col-sm-3 col-xs-3 pt-20" style="padding: 20px 20px 0 0;">
            <img class="pull-right" src="/assets/img/logo-black.png" alt=""/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <p><?= lg("invoice.Addressed to") ?> :</p>
            <p>
                <strong><?= $aInvoice['billing_to'] ?></strong><br/>
                <?= $aInvoice['billing_number'] ?>@if ($aInvoice['billing_number']), @endif<?= $aInvoice['billing_street']; ?> <?= $aInvoice['billing_box']; ?>
                <br/>
                <?= $aInvoice['billing_postalcode']; ?> <?= $aInvoice['billing_city']; ?>
                @if(isset($aInvoice['billing_vat']) && $aInvoice['billing_vat'])
                <br/>
                <?= $aInvoice['billing_vat']; ?>
                @endif
            </p>
        </div>
        <div class="col-xs-4" style="font-size: 13px;">
            <p><?= lg("invoice.Invoiced by") ?> :</p>
            <p>
                <?= lg("invoice.sender_address") ?>
            </p>
        </div>
        <div class="col-xs-4" style="font-size: 13px;">
            <table class="table">
                <tr>
                    <td class="col-xs-2"></td>
                    <td class="col-xs-4"><?= lg("invoice.Order n°") ?>:</td>
                    <td class="col-xs-6"><?= $aInvoice['number'] ?></td>
                </tr>
                <tr>
                    <td class="col-xs-2"></td>
                    <td>REF :</td>
                    <td>#<?= $aInvoice['id'] ?></td>
                </tr>
                <tr>
                    <td class="col-xs-2"></td>
                    <td><?= lg("invoice.date") ?>:</td>
                    <td><?= $aInvoice['date'] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <br/>

    <table class="table table-bordered">
        <thead class="well" style="font-weight: bold;">
        <tr>
            <th class="col-xs-10">
                <?= lg("invoice.Description") ?>
            </th>
            <th class="col-xs-2"><?= lg("invoice.Price") ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <p>
                    @if($aInvoice['type'] == \App\Invoice::TYPE_CREDIT_NOTE)
                    <?php
                    echo $aInvoice['title']
                    ?>
                    @else
                    <?php
                    echo $aInvoice['content']
                    ?>
                    @endif                    
                </p>
            </td>
            @if($aInvoice['format'] == 0 || $aInvoice['billing_exempted'])
            <td>€ <?= number_format($aInvoice['price'], 2, ',', '.') ?></td>
            @else
            <td>€ <?= number_format($aInvoice['price'] / 1.21, 2, ',', '.') ?></td>
            @endif
        </tr>
        </tbody>
        <tfoot>
        @if($aInvoice['billing_exempted'])
            @if($aInvoice['no_vat_price'] != 0)
            <tr>
                <td class="text-right">
                    <?php
                    echo $aInvoice['no_vat_content']
                    ?>
                </td>
                <td>€ <?= number_format($aInvoice['no_vat_price'] * 1, 2, ',', '.') ?></td>
            </tr>
            @endif
        <tr>
            <td class="text-right"><?= lg("invoice.Total VAT Excl.") ?>:
            </td>
            <td>€ <?= number_format(($aInvoice['price'] * 1 + $aInvoice['no_vat_price'] * 1), 2, ',', '.') ?></td>
        </tr>
        @else
            @if($aInvoice['format'] == 0)
            <tr>
                <td class="text-right"><?= lg("invoice.Total VAT Excl.") ?>:
                </td>
                <td>€ <?= number_format($aInvoice['price'] / 1.21, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-right"><?= lg("invoice.Tax") ?>:
                </td>
                <td>€ <?= number_format(($aInvoice['price'] / 1.21) * 0.21, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-right"><?= lg("invoice.total") ?>:
                </td>
                <td>
                    <strong>€ <?= number_format($aInvoice['price'] * 1, 2, ',', '.') ?></strong>
                </td>
            </tr>
            @else
            <tr>
                <td class="text-right"><?= lg("invoice.Tax") ?>:
                </td>
                <td>€ <?= number_format(($aInvoice['price'] / 1.21) * 0.21, 2, ',', '.') ?></td>
            </tr>
                @if($aInvoice['no_vat_price'] != 0)
                <tr>
                    <td class="text-right">
                        <?php
                        echo $aInvoice['no_vat_content']
                        ?>
                    </td>
                    <td>€ <?= number_format($aInvoice['no_vat_price'] * 1, 2, ',', '.') ?>
                    </td>
                </tr>
                @endif
            <tr>
                <td class="text-right"><?= lg("invoice.total") ?>:
                </td>
                <td>
                    <strong>€ <?= number_format(($aInvoice['price'] * 1 + $aInvoice['no_vat_price'] * 1), 2, ',', '.') ?></strong>
                </td>
            </tr>
            @endif        
        @endif
        </tfoot>
    </table>
    <div class="text-center">
        <?= lg("invoice.footer") ?>
    </div>
</div>
@stop

@section('js')
@if (request()->get('action') == 'download' || isset($forcePrint))
<script>document.title='<?= $aInvoice['number'] ?>'; window.print();</script>
@endif
@stop
