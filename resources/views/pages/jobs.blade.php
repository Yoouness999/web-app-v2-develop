@extends('layouts.default')

@section('content')
	<section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
		<img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">

		<div class="page-banner-content">
			<h1><?= $title ?></h1>
			<a class="btn btn-primary @if(Request::segment(2) == 'about') active @else @endif" href="/page/about"><?= lg("common.Team") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'partners') active @else @endif" href="/page/partners"><?= lg("common.Partners") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'press') active @else @endif" href="/page/press"><?= lg("common.Press") ?></a>
			<a class="btn btn-primary @if(Request::segment(2) == 'jobs') active @else @endif" href="/page/jobs"><?= lg("common.Jobs") ?></a>
		</div>
	</section><!-- /.page-banner -->

	<!-- section-action -->
	<section class="section-action section">
		<div class="container">
			<?= $content ?>
			@foreach($accordions as $key => $accordion)
				<!-- accordion -->
				<div class="accordion accordion-big" role="tablist">
					@foreach($accordion['items'] as $key2 => $item)
                        @if($item['title'])
                            <div class="accordion-group">
                                <a class="accordion-header collapsed" role="button" data-toggle="collapse" href="#job-<?= $key.'_'.$key2; ?>" aria-expanded="true" aria-controls="job-<?= $key.'_'.$key2; ?>">
                                    <?= $item['title']; ?>
                                </a>
                                <div id="job-<?= $key.'_'.$key2; ?>" class="accordion-collapse collapse" role="tabpanel"
                                     aria-labelledby="job-<?= $key.'_'.$key2; ?>">
                                    <div class="accordion-body">
                                        <?= $item['description']; ?>
                                        <br><br>
                                        <div class="row">
                                            <span st_title="<?= e($item['title']); ?>" class='st_sharethis_large' displayText='ShareThis'></span>
                                            <span st_title="<?= e($item['title']); ?>" class='st_facebook_large' displayText='Facebook'></span>
                                            <span st_title="<?= e($item['title']); ?>" class='st_twitter_large' displayText='Tweet'></span>
                                            <span st_title="<?= e($item['title']); ?>" class='st_linkedin_large' displayText='LinkedIn'></span>
                                            <span st_title="<?= e($item['title']); ?>" class='st_pinterest_large' displayText='Pinterest'></span>
                                            <span st_title="<?= e($item['title']); ?>" class='st_email_large' displayText='Email'></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
					@endforeach
				</div>
				<!-- / accordion -->
			@endforeach
		</div>
	</section><!-- / section-action -->
@stop
