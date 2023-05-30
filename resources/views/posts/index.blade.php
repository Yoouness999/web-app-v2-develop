@extends('layouts.default')

@section('head')
    @parent
    <script type="text/javascript">var switchTo5x=true;</script>
    <script type="text/javascript" src="<?= Request::isSecure() ? 'https://ws.sharethis.com/button/buttons.js' : 'http://w.sharethis.com/button/buttons.js'; ?>"></script>
    <script type="text/javascript">stLight.options({publisher: "c1744979-60e9-4c8b-bf7a-55b1a3fd551f", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
@stop

@section('sharemetas')
    <meta property="og:title" content="<?= lg("common.Blog"); ?>"/>
    <meta name="twitter:title" content="<?= lg("common.Blog"); ?>">
    @if(isset($meta, $meta['metadescription']))
        <meta property="og:description" content="<?= $meta['metadescription'] ?>"/>
        <meta name="twitter:description" content="<?= $meta['metadescription'] ?>">
    @endif
    <meta property="og:image" content="<?= url('/assets/img/bg-press.jpg') ?>"/>
    <meta name="twitter:image" content="<?= url('/assets/img/bg-press.jpg') ?>">
    <meta property="og:url" content="<?= url('/') ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Boxify"/>
    <meta property="og:locale" content="<?= App::getLocale() ?>"/>
    <meta name="fb:app_id" content="<?= config('services.facebook.client_id') ?>"/>
    <meta property="og:email" content="<?= strip_tags(lg("common.boxify_email")) ?>"/>
    <meta property="og:phone_number" content="<?= strip_tags(lg("common.boxify_phone")) ?>"/>
    <meta property="og:country-name" content="Belgium"/>
    <meta name="fb:app_id" content="<?= config('services.facebook.client_id') ?>"/>
    <meta name="twitter:card" content="summary_large_image">
@stop

@section('content')
<div aria-label="Main content" itemscope itemtype="https://schema.org/Blog">
    <section class="page-banner" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
        <img class="sr-only" src="{{ asset('assets/img/bg-banner.jpg') }}" alt="Banner">

        <div class="page-banner-content">
            <h1><?= lg("common.Blog"); ?></h1>
        </div>
    </section><!-- / page-banner -->

    <div class="container mt-25">
        <div class="row">
            <div class="col-sm-9">
                <div class="media-list media-blog mb-50" itemscope itemtype="http://schema.org/ItemList">
                    @if(count($data))
                        @foreach($data as $key => $item)
                            <div class="media <?php if ($item['is_highlighted']) echo 'highlight'; ?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/BlogPosting">
                                <a href="<?= $item['slug']; ?>" itemprop="url">
                                    <h3 class="primary-color" itemprop="name headline"><?= $item['title'] ?></h3>
                                    @if(isset($item['meta'], $item['meta']['image']))
                                        <figure itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                            <img class="img-responsive" src="<?= $item['meta']['image']; ?>" alt="" style="min-width: 100%;" itemprop="url">
                                        </figure>
                                    @endif
                                </a>

                                <div>
                                    <time itemprop="datePublished" datetime="<?= date('c', strtotime($item['published_at'])); ?>"><?= date('d/m/Y', strtotime($item['published_at'])); ?></time> - <span itemprop="keywords"><?= join(', ', array_map(function ($category) {
                                        return '<a href="/blog/search/' . str_slug($category['name']) . '?cat=' . $category['id'] . '" rel="category tag">' . ucfirst($category['name']) . '</a>';
                                    }, $item->categories()->get()->toArray())) ?></span>
                                </div>
                            </div>

                            <div class="divider divider--x2"></div>
                        @endforeach
                    @else
                        <h1><?= lg("No articles found") ?></h1>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>
        </div>
    </div>
</div>
@stop

