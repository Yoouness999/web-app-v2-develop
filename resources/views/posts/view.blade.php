@extends('layouts.default')

@section('head')
    @parent
    <script type="text/javascript">var switchTo5x=true;</script>
    <script type="text/javascript" src="<?= Request::isSecure() ? 'https://ws.sharethis.com/button/buttons.js' : 'http://w.sharethis.com/button/buttons.js'; ?>"></script>
    <script type="text/javascript">stLight.options({publisher: "c1744979-60e9-4c8b-bf7a-55b1a3fd551f", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
@stop

@section('sharemetas')
    <meta property="og:title" content="<?= $title ?>"/>
    <meta name="twitter:title" content="<?= $title ?>">
    @if(isset($meta, $meta['metadescription']))
        <meta property="og:description" content="<?= $meta['metadescription'] ?>"/>
        <meta name="twitter:description" content="<?= $meta['metadescription'] ?>">
    @endif
    @if(isset($meta, $meta['image']))
        <meta property="og:image" content="<?= url('/' . $meta['image']) ?>"/>
        <meta name="twitter:image" content="<?= url('/' . $meta['image']) ?>">
    @else
        <meta property="og:image" content="<?= url('/assets/img/bg-press.jpg') ?>"/>
        <meta name="twitter:image" content="<?= url('/assets/img/bg-press.jpg') ?>">
    @endif
    <meta property="og:url" content="<?= URL::current() ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="Boxify"/>
    <meta property="og:locale" content="<?= App::getLocale() ?>"/>
    <meta property="og:email" content="<?= strip_tags(lg("common.boxify_email")) ?>"/>
    <meta property="og:phone_number" content="<?= strip_tags(lg("common.boxify_phone")) ?>"/>
    <meta property="og:country-name" content="Belgium"/>
    <meta name="fb:app_id" content="<?= config('services.facebook.client_id') ?>"/>
    <meta name="twitter:card" content="summary_large_image">
@stop

@section('content')
<div aria-label="Main content" itemscope itemtype="https://schema.org/Blog">
    <section class="page-banner" style="background-image: url(<?= asset('assets/img/bg-banner.jpg') ?>)">
        <img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">

        <div class="page-banner-content">
            <h1><a href="/blog" style="color: #ffffff"><?= lg("common.Blog") ?></a></h1>
        </div>
    </section><!-- / page-banner -->

    <div class="container mt-20">
        <div class="row">
            <div class="col-sm-9" itemprop="blogPost" itemid="<?= URL::current() ?>" itemscope itemtype="http://schema.org/BlogPosting">
                <meta itemprop="mainEntityOfPage" content="<?= URL::current() ?>">
                <meta itemprop="dateModified" content="<?= date('c', strtotime($published_at)); ?>">

                <h1 itemprop="name headline"><?= $title ?></h1>

                <div class="clearfix">
                    <time itemprop="datePublished" datetime="<?= date('c', strtotime($published_at)); ?>"><?= date('d/m/Y', strtotime($published_at)); ?></time> - <span itemprop="keywords"><?= join(', ', array_map(function ($category) {
                        return '<a href="/blog/search/' . str_slug($category['name']) . '?cat=' . $category['id'] . '" rel="category tag">' . ucfirst($category['name']) . '</a>';
                    }, $categories)) ?></span>

                    <div class="pull-right">
                        <span class="st_sharethis_large" st_title="<?= e($title) ?>" displayText="ShareThis"></span>
                        <span class="st_facebook_large" st_title="<?= e($title) ?>" displayText="Facebook"></span>
                        <span class="st_twitter_large" st_title="<?= e($title) ?>" displayText="Tweet"></span>
                        <span class="st_linkedin_large" st_title="<?= e($title) ?>" displayText="LinkedIn"></span>
                        <span class="st_pinterest_large" st_title="<?= e($title) ?>" displayText="Pinterest"></span>
                        <span class="st_email_large" st_title="<?= e($title) ?>" displayText="Email"></span>
                    </div>
                </div>

                @if(isset($meta, $meta['image']))
                    <figure itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <img class="img-responsive" src="/<?= $meta['image'] ?>" alt="" itemprop="url">
                    </figure>
                @endif

                <div itemprop="articleBody">
                    <?= $content ?>
                </div>

                <br>

                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <a class="link link-primary" href="/blog">< <?= lg("Return") ?></a>
                    </div>
                    <div class="col-xs-6">
                        <div class="pull-right">
                            <span class="st_sharethis_large" st_title="<?= e($title) ?>" displayText="ShareThis"></span>
                            <span class="st_facebook_large" st_title="<?= e($title) ?>" displayText="Facebook"></span>
                            <span class="st_twitter_large" st_title="<?= e($title) ?>" displayText="Tweet"></span>
                            <span class="st_linkedin_large" st_title="<?= e($title) ?>" displayText="LinkedIn"></span>
                            <span class="st_pinterest_large" st_title="<?= e($title) ?>" displayText="Pinterest"></span>
                            <span class="st_email_large" st_title="<?= e($title) ?>" displayText="Email"></span>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>
        </div>
    </div>
</div>
@stop










