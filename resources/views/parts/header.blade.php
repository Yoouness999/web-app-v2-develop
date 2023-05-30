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
                    <a class="navbar-brand" href="{{ url('/') }}" rel="home" itemprop="url">
                        <img src="{{ asset('assets/img/boxify-logo.svg') }}" alt="Boxify" itemprop="logo" />
                        <img class="sticky" src="{{ asset('assets/img/boxify-logo.png') }}" alt="Boxify" />
                    </a>
                </div>
                <!-- / navbar-header -->

                <!-- navbar-collapse -->
                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    @if (isset($isProfile) && $isProfile)
                        <div class="navbar-left">
                            <ul class="nav navbar-nav">
                                <!-- menu-items -->
                                @if(isset($user))
                                    @foreach (Lang::get('profile.menu') as $menu)
                                        <li @if($menu['active']) class="active" @endif>
                                            <a href="{{ $menu['link'] }}">{{ $menu['name'] }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                @endif

                <!-- navbar-right -->
                    <div class="navbar-right">

                        <!-- navbar-nav -->
                        <ul class="nav navbar-nav" aria-label="Navigation" itemscope
                            itemtype="https://schema.org/SiteNavigationElement">
                            <!-- menu-items -->
                            @if(!isset($isProfile) || !$isProfile)
                                @if (isset($navigations['navbar']))
                                    @foreach ($navigations['navbar'][0] as $key => $value)
                                        @if (isset($value['link']))
                                            <li @if (isset($value['active']) && $value['active']) class="active" @endif>
                                                <a
                                                    href="{{ url($value['link']) }}"
                                                    itemprop="url"
                                                >{{ $value['name'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                                <li class="nav-color">{!! lg("common.boxify_phone") !!}</li>
                            @endif
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

                            @auth
                                <li class="name-dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        {{ shortcode(lg("Hi {first_name}"), Auth::user()->toArray()) }}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @if(isset($isProfile) && $isProfile)
                                            @foreach(Lang::get('profile.user') as $key => $value)
                                                @if (!$value['active'])
                                                    <li>
                                                        <a href="{{ $value['link'] }}">{{ ($value['name']) }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($navigations['user'] as $key => $value)
                                                @if (!$value['active'])
                                                    <li>
                                                        <a href="{{ $value['link'] }}">{{ ($value['name']) }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endauth
                        </ul>
                        <!-- / navbar-nav -->

                        @guest
                            <a
                                class="btn btn-default navbar-btn"
                                href="{{ url('login') }}"
                            >{{ lg("login") }}</a>
                        @endguest

                        @if (($order = Session::get('order')) && url()->current() !== 'order/calculator')
                            @if (isset($user) && !$user->isInPaymentDefault())
                                <a
                                    class="btn btn-primary navbar-btn"
                                    href="{{ $order->getCurrentStepUrl() }}"
                                >{{ lg('common.mycart') }}</a>
                            @endif
                        @endif

                        <div class="order-need-help">
                            {{ lg('common.need-help.label') }}
                            <a href="{{ lg('common.need-help.href') }}">{{ lg('common.need-help.phone') }}</a>
                        </div>
                    </div>
                    <!-- / navbar-right -->

                </div>
                <!-- / navbar-collapse -->

            </div>
            <!-- / container-fluid -->

        </nav>
        <!-- / navbar-default -->

</header><!-- / navbar-default -->
