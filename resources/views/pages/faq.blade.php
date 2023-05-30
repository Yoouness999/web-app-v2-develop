@extends('layouts.default')

@section('content')

<!-- page-banner -->
<section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
    <img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">

    <div class="page-banner-content">
        <h1><?= $title; ?></h1>
        <h2><?= $content; ?></h2>
        @include('parts.btn-get-started')
    </div>
</section><!-- / page-banner -->

<!-- section-faq -->
<section class="section-faq section">
    <div class="container">

        @foreach($accordions as $key => $accordion)
        <h3 id="section-<?= ($key+1); ?>"><?= ($key+1).'. '.$accordion['title']; ?></h3>

        <!-- accordion -->
        <div class="accordion" role="tablist">
            @foreach($accordion['items'] as $key2 => $item)
                <div class="accordion-group">
                    <a class="accordion-header collapsed" role="button" data-toggle="collapse" href="#question<?= $key.'_'.$key2; ?>" aria-expanded="true" aria-controls="question<?= $key.'_'.$key2; ?>">
                        <?= $item['title']; ?>
                    </a>
                    <div id="question<?= $key.'_'.$key2; ?>" class="accordion-collapse collapse" role="tabpanel"
                         aria-labelledby="question<?= $key.'_'.$key2; ?>">
                        <div class="accordion-body">
                            <?= $item['description']; ?>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- / accordion -->
        @endforeach

    </div>
</section><!-- / section-faq -->

@stop









