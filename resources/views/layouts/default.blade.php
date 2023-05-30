<!DOCTYPE html>
<head>
    <meta charset="UTF-8">

    <title>
        @if(isset($meta['pagetitle']))
            {{ $meta['pagetitle'] }}
        @elseif(isset($meta['metatitle']))
            {{ $meta['metatitle'] }}
        @else
            Boxify
        @endif
    </title>

    @if(isset($meta['metadescription']))
        <meta name="description" content="{{ @$meta['metadescription'] }}">
    @endif

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">

    @section('sharemetas')
        @if(isset($businessPage) && isset($meta['metatitle']))
            <meta property="og:title" content="{{ @$meta['metatitle'] }}">
            <meta name="twitter:title" content="{{ @$meta['metatitle'] }}">
        @else
            <meta property="og:title" content="Boxify">
            <meta name="twitter:title" content="Boxify">
        @endif

        @if(isset($meta['metadescription']))
            <meta property="og:description" content="<?= $meta['metadescription'] ?>">
            <meta name="twitter:description" content="<?= $meta['metadescription'] ?>">
        @endif

        <meta property="og:image" content="<?= url('/assets/img/bg-press.jpg') ?>">
        <meta name="twitter:image" content="<?= url('/assets/img/bg-press.jpg') ?>">
        <meta property="og:url" content="<?= url('/') ?>">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Boxify">
        <meta property="og:locale" content="<?= App::getLocale() ?>">
        <meta name="fb:app_id" content="<?= config('services.facebook.client_id') ?>">
        @if(isset($businessPage))
        <meta property="og:email" content="<?= strip_tags(lg("business.email")) ?>">
        <meta property="og:phone_number" content="<?= strip_tags(lg("business.phone")) ?>">
        @else
        <meta property="og:email" content="<?= strip_tags(lg("common.boxify_email")) ?>">
        <meta property="og:phone_number" content="<?= strip_tags(lg("boxify_phone")) ?>">
        @endif
        <meta property="og:country-name" content="Belgium">
        <meta name="fb:app_id" content="<?= config('services.facebook.client_id') ?>">
        <meta name="twitter:card" content="summary_large_image">
    @show

    @if(preg_match("/profile\/manage/i", url()->current()))
        <base href="/profile/manage/">
    @endif

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide {
            display: none !important;
        }</style>
    <link rel="stylesheet" href="{{ mix('/assets/css/main.css') }}">

    {!! javascript()->render('__app') !!}
    {!! javascript()->render('__labels') !!}

    @if (env('APP_ENV') == 'production')
        <script type="text/javascript">var switchTo5x = true;</script>
        <script type="text/javascript"
                src="<?= Request::isSecure() ? 'https://' : 'http://' ?>w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({
                publisher: "c1744979-60e9-4c8b-bf7a-55b1a3fd551f",
                doNotHash: false,
                doNotCopy: false,
                hashAddressBar: false
            });</script>

        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-PDDWGK');</script>
        <!-- End Google Tag Manager -->

        <!-- Hotjar Tracking Code for www.boxify.be -->
        <script>
            (function (h, o, t, j, a, r) {
                h.hj = h.hj || function () {
                    (h.hj.q = h.hj.q || []).push(arguments)
                };
                h._hjSettings = {hjid: 400770, hjsv: 5};
                a = o.getElementsByTagName('head')[0];
                r = o.createElement('script');
                r.async = 1;
                r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');
        </script>
    @endif
</head>
<body <?= isset($body, $body['attributes']) ? HTML::attributes($body['attributes']) : '' ?> itemscope
      itemtype="https://schema.org/WebPage">
<meta itemprop="accessibilityControl" content="fullKeyboardControl">
<meta itemprop="accessibilityControl" content="fullMouseControl">
<meta itemprop="accessibilityHazard" content="noFlashingHazard">
<meta itemprop="accessibilityHazard" content="noMotionSimulationHazard">
<meta itemprop="accessibilityHazard" content="noSoundHazard">
<meta itemprop="accessibilityAPI" content="ARIA">
<input type="hidden" name="fingerprint" id="fingerprint">

@if (env('APP_ENV') == 'production')
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '978174222305785', {
            /*em: 'insert_email_variable,'*/
        });
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=978174222305785&ev=PageView&noscript=1">
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

    <script>
        dataLayer.push({
            pageName: '<?= e(Request::getRequestUri() == '/' ? 'home' : Request::getRequestUri()) ?>',
            category: '<?= e(Request::segment(1) ?: 'home') ?>',
            language: '<?= app()->getLocale() ?>',
            logged: '<?= auth()->check() ? 'TRUE' : 'FALSE' ?>',
            template_responsive: '<?= \Arx\classes\Detect::is_mobile() ? 'mobile' : 'desktop' ?>',
        });

        @if(Session::has('new_user'))
        dataLayer.push({
            event: 'Account',
            action: 'Create',
        });
        @endif
    </script>

    @yield('datalayer')

    @if(isset($meta, $meta['Googletag']))
        <?= $meta['Googletag'] ?>
    @endif

    <!-- Google Tag Manager -->
    <noscript>
        <iframe src="//www.googletagmanager.com/ns.html?id=GTM-PDDWGK" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager -->
@endif

@section('body')
@section('header')
    @if(isset($businessPage))
        @include('parts.header-business')
    @else
        @include('parts.header')
    @endif
@show
<main class="main-content" id="content">
    @include('flash::message')

    @section('content')
        @yield('content')
    @show
</main>

@section('footer')
    @if(isset($businessPage))
        @include('parts.footer-business')
    @else
        @include('parts.footer')
    @endif
@show

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.14/angular.min.js"></script>
    <script src="<?= mix('/assets/js/manifest.js') ?>"></script>
    <script src="<?= mix('/assets/js/vendor.js') ?>"></script>
    <script src="<?= mix('/assets/js/main.js') ?>"></script>
@show

@if (env('APP_ENV') == 'production')
    @include('parts.intercom')
@endif

<script type="text/javascript" src="https://live.adyen.com/hpp/js/df.js"></script>

<script type="text/javascript">
    var d = new Date();

    dict = {
        "colorDepth": screen.colorDepth,
        "javaEnabled": navigator.javaEnabled(),
        "language": navigator.language,
        "screenHeight": screen.height,
        "screenWidth": screen.width,
        "timeZoneOffset": d.getTimezoneOffset(),
        "userAgent": navigator.userAgent
    };

    for (i in dict) {
        if (dict[i].toString() != "") {
            document.cookie = i.toString() + '=' + dict[i].toString();
        }
    }

    dfDo("fingerprint");
    f = document.getElementById("fingerprint").value;
    if (f != '') {
        document.cookie = 'fingerprint=' + document.getElementById("fingerprint").value;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        if($(".alert").length > 0) {
            $('html,body').animate({
                scrollTop: $(".alert").offset().top -100
            });
        }
    });
</script>
@show
</body>
</html>
