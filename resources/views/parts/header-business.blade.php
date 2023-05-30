<?php
/**
 * @var $order /App/Order
 */
if (!isset($languageActive)) {
    $languageActive = 'en';
}
?>
<!-- navbar-default -->
<header class="main-header" itemscope itemtype="https://schema.org/Organization">

    <!-- navbar-default -->
    @section('navbar-default')
        <nav class="navbar navbar-default navbar-fixed-top">
            @show

            <div class="container">

                <!-- navbar-header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse-main" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-toggle-mobile visible-sm-inline-block visible-xs-inline-block">
                        <ul class="nav navbar-nav">
                            <!-- languages -->
                            <li class="language-dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ strtoupper(@$languageActive) }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if (isset($languageItems))
                                        @foreach ($languageItems as $key => $value)
                                            @if ($key !== App::getLocale())
                                                @php
                                                $localeUrl = str_replace(url('/'), $value['url'], Request::url('/'));
                                                $localeUrl .= strpos($localeUrl, '?') ? 'force_locale=true' : '?force_locale=true';
                                                @endphp
                                                <li>
                                                    <a href="//{{ $localeUrl }}">
                                                        {{ strtoupper($key) }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <!-- / languages -->
                        </ul>
                    </div>
                    <a class="navbar-brand" href="{{ url('/page/business') }}" rel="home" itemprop="url">
                        <img src="{{ asset('assets/img/boxify-logo.svg') }}" alt="Boxify" itemprop="logo" />
                        <img class="sticky" src="{{ asset('assets/img/boxify-logo.png') }}" alt="Boxify" />
                    </a>
                </div>
                <!-- / navbar-header -->

                <!-- navbar-collapse -->
                <div class="collapse navbar-collapse" id="navbar-collapse-main">

                <!-- navbar-right -->
                    <div class="navbar-right">

                        <!-- navbar-nav -->
                        <ul class="nav navbar-nav" aria-label="Navigation" itemscope
                            itemtype="https://schema.org/SiteNavigationElement">
                            <!-- menu-items -->
                            <li>
                                <a href="/page/move">
                                {!! lg("business.menu.navbar.move") !!}
                                </a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                    {!! lg("business.menu.navbar.services") !!}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/page/business">
                                        {!! lg("business.menu.navbar.archive") !!}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/page/merchandise">
                                        {!! lg("business.menu.navbar.merchandise") !!}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="/" itemprop="url">{!! lg("business.menu.navbar.individual") !!}</a>
                            </li>
                            <li>
                                <a href="/page/contact"><?= lg("business.menu.navbar.contact") ?></a>
                            </li>
                            <li class="nav-color">{!! lg("business.phone") !!}</li>
                            <!-- / menu-items -->

                            <!-- languages -->
                            <li class="language-dropdown hidden-xs hidden-sm">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ strtoupper(@$languageActive) }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if (isset($languageItems))
                                        @foreach ($languageItems as $key => $value)
                                            @if ($key !== App::getLocale())
                                                @php
                                                    $localeUrl = str_replace(url('/'), $value['url'], Request::url('/'));
                                                    $localeUrl .= strpos($localeUrl, '?') ? 'force_locale=true' : '?force_locale=true';
                                                @endphp
                                                <li>
                                                    <a href="//{{ $localeUrl }}">
                                                        {{ strtoupper($key) }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </li><!-- / languages -->
                        </ul>
                    </div>
                    <!-- / navbar-right -->

                </div>
                <!-- / navbar-collapse -->

            </div>
            <!-- / container-fluid -->

        </nav>
        <!-- / navbar-default -->

</header><!-- / navbar-default -->
