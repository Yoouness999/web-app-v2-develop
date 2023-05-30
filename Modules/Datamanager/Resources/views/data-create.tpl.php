@extends('arxmin::layouts.admin')

@section('css')
@parent
<link rel="stylesheet" href="/packages/zofe/rapyd/assets/redactor/css/redactor.css"/>
<link rel="stylesheet" href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css"/>
<link rel="stylesheet" href="/packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css"/>
<?= Rapyd::styles() ?>
@stop

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3><?php echo $this->title; ?></h3>
    </div>
    <div class="row">
        <?= $form; ?>
    </div>
</div>
@stop

@section('js')
@parent
<?= Rapyd::scripts() ?>

<script>
$(function () {
    'use strict';

    $('input[name="title"]').on('keydown', function (e) {
        var $el = $(this);
        var timeout = $el.data('timeout');

        if (timeout) {
            clearTimeout(timeout);
        }

        $el.data('timeout', setTimeout(function () {
            var $slug = $('input[name="slug"]');
            var value = $el.val();

            value = slugify(value);

            $slug.val(value);
        }, 500));
    });

    function slugify(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str;
    }
});
</script>
@stop