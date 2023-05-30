@extends('layouts.default')

@section('content')
    <div class="carousel slide" id="homeCarousel" data-ride="carousel">
        @if(count($slides) >1)
            <ol class="carousel-indicators">
                @foreach($slides as $key => $slide)
                    <li
                        @if($key == 0) class="active" @endif
                        data-slide-to="{{ $key }}"
                        data-target="#homeCarousel"
                    ></li>
                @endforeach
            </ol>
        @endif

        <div class="carousel-inner" role="listbox">
            @foreach($slides as $key => $slide)
                <div class="item @if($key == 0) active @endif page-banner page-banner-lg">
                    <img class="sr-only" src="{{ asset($slide['background']) }}" alt="">

                    <div class="background-banner mobile" style="background-image: url({{ asset('assets/img/home_mobile.jpg') }})"></div>
                    <div class="background-banner desktop" style="background-image: url({{ asset($slide['background']) }})"></div>

                    <div class="page-banner-content">
                        <h1>{{ $slide['title'] }}</h1>
                        <h2>{{ $slide['subtitle'] }}</h2>

                        @if (isset($slide['has_order_form']) && $slide['has_order_form'])
                        
                            <form class="order-form postal_code-form" action="{{ url('/order') }}" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input
                                            class="form-control"
                                            data-msg-pattern="{{ lg('validation.custom.postal_code') }}"
                                            name="postal_code"
                                            placeholder="{{ lg('pages/home.order_form.zip_code_placeholder') }}"
                                            required
                                            type="text"
                                            value="{{ @$postalCode }}"
                                        >
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" onclick="dataLayer.push({event:'zipSearch'})">
                                                {{ $slide['btn_text'] }}
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="zip-code-error alert alert-warning hidden col-sm-2 col-sm-offset-5">
                                        {{ lg('pickup.This area is not available') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 contact">
                                        {!! lg('pages/home.order_form.text') !!}
                                    </div>
                                </div>
                            </form>


                        @elseif ($user)
                            <a class="btn btn-primary" href="/user/pickup">{{ $slide['btn_text'] }}</a>
                        @else
                            <a class="btn btn-primary" href="{{ $slide['btn_link'] }}">{{ $slide['btn_text'] }}</a>
                        @endif
                    </div>

                    <a class="scroll-down" href="#section-home-steps">
                        <span></span>
                    </a>
                </div>
            @endforeach
        </div>

        <script type="text/javascript">
            //var home_order_form_cities = {!! json_encode(Lang::get('cities')) !!};
        </script>

        @if(count($slides) >1)
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#homeCarousel" role="button" data-slide="prev">
                {{-- <span class="fa fa-chevron-left" aria-hidden="true"></span> --}}
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#homeCarousel" role="button" data-slide="next">
                {{-- <span class="fa fa-chevron-right" aria-hidden="true"></span> --}}
                <span class="sr-only">Next</span>
            </a>
        @endif
    </div>

    <!-- section-home-steps -->
    <section id="section-home-steps" class="section-home-steps">
        <div class="container">
            <div class="row">
                <h2>{{ lg('pages/home.steps_title') }}</h2>
                @foreach($explanations as $key => $item)
                    <div class="col-sm-4 with-arrow">
                        <img class="center-block" src="{{ $item['image'] }}" alt="{{ $item['description'] }}">
                        <p class="number"><span>{{ $key + 1 }}</span></p>
                        <p>{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- / section-home-steps -->

    <!-- section-home-order -->
    @include('order.storage-content', ['categories' => $categories, 'assets' => $assets, 'from' => 'home', 'categoryBySlide' => 1])
    <!-- / section-home-order -->

    <!-- section-home-mobile -->
    <section class="section-home-mobile">
        <div class="container">
            <div class="row">

                <div class="col-sm-6">
                    <h3 class="text-center">
                        {!! $text_image['title'] !!}
                    </h3>

                    <p class="text-center">
                        {{ $text_image['description'] }}
                    </p>
                </div>

                <div class="col-sm-6">
                    <img class="center-block" src="{{ $text_image['image'] }}" alt="mobile box">
                </div>

            </div>
        </div>
    </section><!-- / section-home-mobile -->

    <!-- section-home-assets -->   <!-- TABLE COMPARAISON  -->
    <section class="section-home-assets text-center bg-gray-lighter-ultra">
        <div class="container">
			<h2><?= lg('pages/home.assets.title') ?></h2>
			<div class="panel panel-primary">
				<div>
					<div></div>
					<div></div>
					<div>Boxify</div><!---
				---><div>{{ lg('pages/home.assets.selfstorage') }}</div>
					<div></div>
				</div>
                @for ($i = 1; $i <= 4; $i++)
                    <div>
						<div></div>
						<div>{{ lg('pages/home.assets.row-' . $i) }}</div>
						<div><i class="fa fa-check" aria-hidden="true"></i></div>
					    <div><i class="fa fa-times" aria-hidden="true"></i></div>
						<div></div>
					</div>
                @endfor
			</div>
			<p>
				{{ lg('pages/home.assets.starting') }}
			</p>
			<p>
				<a
                    class="btn btn-primary"
                    @if ($order = Session::get('order'))
                        href="{{ $order->getCurrentStepUrl() }}"
                    @else
                        href="{{ url('/order') }}"
                    @endif
                >{{ lg('pages/home.assets.button') }}</a>
			</p>
		</div>
    </section><!-- / section-home-assets -->




    

    <!-- section-home-testimonies -->
    <section class="section-home-testimonies text-center">
        <div class="container">
			<h2>{{ lg('pages/home.testimonials-title') }}</h2>
            <div class="testimonies-carousel">
                @foreach($testimonials as $item)
                    <div class="item">
                        <div class="testimony">
							<p class="testimony-note">.
                                @if (isset($item['note']))
                                    @for ($i = 1; $i <= $item['note']; $i++)
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    @endfor
                                @endif
							</p>
                            <p class="testimony-content">“{{ $item['text'] }}”</p>
                            <div class="testimony-author">
                                @if($item['thumb'])
                                    <img src="{{ $item['thumb'] }}" alt="{{ $item['author'] }}">
                                @endif
                                <p>
                                    {{ $item['author'] }}<br />
                                    <span class="text-muted">{{ $item['location'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- / section-home-testimonies -->

 
    <!-- section-home-partners -->
    <section class="section-home-partners text-center">
        <div class="container">
			<h2>{{ lg('pages/home.partners.title') }}</h2>
            <div class="carousel-partners">
                <div class="item">
					<a href="https://www.rtbf.be/info/societe/onpdp/pigeons-ou-pas-pigeons/detail_boxify-bruxelles-pour-stocker-votre-surplus-en-toute-securite?id=9474804" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_rtbf.jpg') }}" alt="RTBF - on est pas de pigeons" />
					</a>
				</div>
				<div class="item">
					<a href="https://www.rtbf.be/info/societe/onpdp/pigeons-ou-pas-pigeons/detail_boxify-bruxelles-pour-stocker-votre-surplus-en-toute-securite?id=9474804" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_on-est-pas-des-pigeons.jpg') }}" alt="RTBF - on est pas de pigeons" />
					</a>
				</div>
				<div class="item">
					<a href="http://www.lalibre.be/video/boxify-une-nouvelle-solution-bruxelloise-de-stockage-57e92273cd70f8c3926f0389" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_la-libre.jpg') }}" alt="La libre" />
					</a>
				</div>
				<div class="item">
					<a href="http://www.dhnet.be/video/boxify-une-nouvelle-solution-bruxelloise-de-stockage-57e92273cd70f8c3926f0382" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_ladh.jpg') }}" alt="DH.BE" />
					</a>
				</div>
				<div class="item">
					<a href="http://www.vivreici.be/article/detail_boxify-une-nouvelle-solution-de-stockage-bruxelloise-pour-les-entreprises-et-particuliers?id=102297" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_vivre-ici.jpg') }}" alt="Vivre Ici" />
					</a>
				</div>
                <div class="item">
                    <a href="https://www.solutions-magazine.com/boxify-reinvente-stockage-physique/" target="_blank">
                        <img src="{{ asset('assets/img/partners/logo_digital-energy-solution.jpg') }}" alt="Solution Magazine" />
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dvo.be/artikel/53832-boxify-innoveert-met-flexibele-opslagdienst/" target="_blank">
                        <img src="{{ asset('assets/img/partners/logo_dvo.jpg') }}" alt="DVO" />
                    </a>
                </div>
				<div class="item">
					<a href="http://www.flanderstoday.eu/business/week-business-5-august  + https://nl.boxify.be/files/press/FlanderToday_Augustus16_2016-08-10.pdf" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_flanders-today.jpg') }}" alt="Flander Today" />
					</a>
				</div>
				<div class=item>
					<a href="http://onlinetouch.be/beci/2015-dot-10-brussel-metropool?html=true#/51/" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_brussel-metropole.jpg') }}" alt="Brussel Metropool" />
					</a>
				</div>
				<div class="item">
					<a href="http://onlinetouch.be/beci/2015-dot-10-bruxelles-metropole?html=true#/51/" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_bruxelles-metropole.jpg') }}" alt="Bruxelles Metropole" />
					</a>
				</div>
				<div class="item">
					<a href="https://fr.boxify.be/files/press/LaCapitale_Aout16_2016-08-20.pdf" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_la-capitale.jpg') }}" alt="La Capitale" />
					</a>
				</div>
				<div class="item">
					<a href="https://www.youtube.com/watch?v=UpcopO6T_QY&feature=youtu.be" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_vivacite.jpg') }}" alt="Vivacité" />
					</a>
				</div>
				<div class="item">
					<a href="http://www.rtl.be/info/video/593602.aspx" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_rtl-tvi.jpg') }}" alt="RTL TVI" />
					</a>
				</div>
				<div class="item">
					<a href="https://www.bruzz.be/samenleving/brusselse-start-boxify-stockeert-je-overbodige-spullen-2016-08-02" target="_blank">
						<img src="{{ asset('assets/img/partners/logo_bruzz.jpg') }}" alt="Bruzz" />
					</a>
				</div>
				<div class="item">
					<a href="#">
						<img src="{{ asset('assets/img/partners/logo_trends.jpg') }}" alt="Trends" />
					</a>
				</div>
            </div>
        </div>
    </section><!-- / section-home-partners -->

    <!-- section-home-map -->
    <section class="section-home-map text-center">
		<form class="order-form postal_code-form" action="{{ url('/order') }}" method="post">
			<h2>{{ lg('pages/home.map.title') }}</h2>
            <div class="form-group">
                <div class="input-group">
                    <input
                        class="form-control"
                        data-msg-pattern="{{ lg('validation.custom.postal_code') }}"
                        name="postal_code"
                        placeholder="{{ lg('pages/home.order_form.zip_code_placeholder') }}"
                        required
                        type="text"
                    />
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit" onclick="dataLayer.push({'event':'zipSearch'});">
                            {{ lg('pages/home.order_form.submit') }}
                        </button>
                    </span>
                </div>
            </div>
			<div class="row">
				<div class="zip-code-error alert alert-warning hidden col-sm-6 col-sm-offset-3">
					{{ lg('pickup.This area is not available') }}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<a href="#modal-coverage-map" data-toggle="modal">{{ lg('pages/home.map.link') }}</a>
				</div>
			</div>
		</form>
    </section><!-- / section-home-map -->

    <!-- section-home-areas -->
    <?php /* <section class="section-home-areas text-center" style="display:none">
		<div class="container">
			<h2><?= lg('pages/home.areas-title') ?></h2>
			<div class="row text-left">
				@if (isset($areas))
					@foreach ($areas as $col)
						<div class="col-md-4">
							<ul>
								@foreach ($col as $area)
									<li><a href="<?= ''#url('/area/' . strtolower($area)) ?>">{{ $area }}</a></li>
								@endforeach
							</ul>
						</div>
					@endforeach
				@endif
			</div>
		</div>
    </section> */ ?>
    <!-- / section-home-areas -->
@stop


@section('js')
    <div class="modal fade" id="modal-coverage-map" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ lg('coverage.Coverage map') }}</h4>
                    <p>{{ lg("coverage.We serve a select area within Belgium. Explore the map below to see if you're in our local service.") }}</p>
                </div>
                <div class="modal-body">
                    <div id="coverage-map"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">
                        {{ lg('coverage.Get started') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @parent
@stop
