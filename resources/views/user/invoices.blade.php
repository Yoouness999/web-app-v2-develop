@extends('layouts.profile')

@section('subcontent')
<h2 class="h4"><?= lg("common.Past invoices") ?></h2>
<hr>
@if(!count($invoices))
    <?= lg("common.You don't have any invoice") ?>
@else
    <table class="table table-striped">
        <thead>
        <tr>
            <td></td>
            <td><?= lg("ref") ?></td>
            <td><?= lg("common.date") ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td><img src="<?= $invoice['paymentImage']; ?>" alt=""></td>
                <td><?= $invoice['id']; ?></td>
                <td><?= $invoice['date']; ?></td>
                <td><?= $invoice['amount']; ?><?= $invoice['devise']; ?></td>
                <td><a href="?download=<?= $invoice['id']; ?>" target="_blank" class="btn btn-link"><i
                                class="fa fa-download"></i></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@stop
