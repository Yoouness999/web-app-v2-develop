<?php
    $businessPage = true;
?>


@extends('layouts.default')

@section('content')



<div id="businessCarousel" class="carousel slide animated fadeIn" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <div class="page-banner page-banner-lg">
            <img class="sr-only" src="{{ asset('assets/img/move.jpg') }}" alt="Boxify moving service Banner">
            <div class="background-banner mobile" style="background-image: url({{ asset('assets/img/move.jpg') }})"></div>
            <div class="background-banner desktop" style="background-image: url({{ asset('assets/img/move.jpg') }})"></div>
            <div class="page-banner-content">
                <h1><?= lg('move.page.header.title')?></h1>
                <h2><?= lg('move.page.header.subtitle')?></h2>
                <a class="btn btn-primary" href="#form-contact"><?= lg('move.page.header.button')?></a>
            </div>
        </div>
    </div>
</div>











 <!-- stepper-advantage-section-move -->
 <section class="stepper-advantage-section-move text-center">
  <div class="container black" style="display: flex; flex-direction: row; justify-content: space-between;">
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/xuhnd2ap.png?w=48" alt="<?= lg('move.page.advantage.first')?>" />
        </p>
        <h3 class="title"><?= lg('move.page.advantage.first')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/6d5fio4d.png?w=48" alt="<?= lg('move.page.advantage.second')?>" />
        </p>
        <h3 class="title"><?= lg('move.page.advantage.second')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/t7e72zjw.png?w=48" alt="<?= lg('move.page.advantage.third')?>" />
        </p>
        <h3 class="title"><?= lg('move.page.advantage.third')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/4n26c7rj.png?w=48" alt="<?= lg('move.page.advantage.fourth')?>" />
        </p>
        <h3 class="title"><?= lg('move.page.advantage.fourth')?></h3>
      </div>
    </div>
  </div>
</section>

<!-- //Services Section -->


















 <!-- first-section-move -->
 <section class="first-section-move">
  <div class="box">
    <div class="section">
      <div class="features">
        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3"><?= lg('move.page.first.section.heading.title')?></h2>
        </div>
        <div class="content-subtitle">
          <h5><?= lg('move.page.first.section.heading.subtitle')?></h5>
        </div>
        <div class="feature">
          <div class="circle">
            <i class="fa fa-truck" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('move.page.first.section.element-1-title')?></h3>
            <p><?= lg('move.page.first.section.element-1-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
          <div class="circle">
            <i class="fa fa-cubes" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('move.page.first.section.element-2-title')?></h3>
            <p><?= lg('move.page.first.section.element-2-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
          <div class="circle">
            <i class="fa fa-list" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('move.page.first.section.element-3-title')?></h3>
            <p><?= lg('move.page.first.section.element-3-subtitle')?></p>
          </div>
        </div>
      </div>
        <img src="{{ asset('assets/img/move1.jpg') }}" alt="Benefits of Boxify's moving service" class="left img-fluid rounded" />
    </div>
  </div>
</section>
<!-- first Section -->











 <!-- second-section -->
<section class="second-section-move">
<br/>
 <br/>
  <div class="box">
    <div class="section">
      <img src="{{ asset('assets/img/move2.jpg')}}" alt="Move service " class="img-fluid left" />

      <div class="features">

        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3">
            <?= lg('move.page.second.section.heading-title')?>
          </h2>
        </div>

        <div class="feature">
        <div class="circle">
             <i class="fa fa-question-circle-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.second.section.element-1-title')?></h3>
            <p><?= lg('move.page.second.section.element-1-subtitle')?></p>
          </div>
        </div>


        <div class="feature">
        <div class="circle">
             <i class="fa fa-cube" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.second.section.element-2-title')?></h3>
            <p><?= lg('move.page.second.section.element-2-subtitle')?></p>
          </div>
        </div>

        <div class="feature">
        <div class="circle">
             <i class="fa fa-tv" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.second.section.element-3-title')?></h3>
            <p><?= lg('move.page.second.section.element-3-subtitle')?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br/>
 <br/>
</section>








 <!-- third-section -->

<section class="third-section-move">
  <div class="box">
    <div class="section">
      <div class="features">
        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3"><?= lg('move.page.third.section.heading-title')?></h2>
        </div>
        <div class="content-subtitle">
          <h5><?= lg('move.page.third.section.heading-subtitle')?></h5>
        </div>
        <div class="feature">

        <div class="circle">
             <i class="fa fa-building-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.third.section.element-1-title')?></h3>
            <p><?= lg('move.page.third.section.element-1-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-user-circle-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.third.section.element-2-title')?></h3>
            <p><?= lg('move.page.third.section.element-2-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-lock" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.third.section.element-3-title')?></h3>
            <p><?= lg('move.page.third.section.element-3-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-handshake-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('move.page.third.section.element-4-title')?></h3>
            <p><?= lg('move.page.third.section.element-4-subtitle')?></p>
          </div>
        </div>

        <div class="feature">
        <div class="circle">
             <i class="fa fa-suitcase" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('move.page.third.section.element-5-title')?></h3>
            <p><?= lg('move.page.third.section.element-5-subtitle')?></p>
          </div>
        </div>
      </div>
      <img src="{{ asset('assets/img/move6.jpg') }}" alt="Storage service " class="desktop"/>

    </div>
  </div>
  <br/>
 <br/>
</section>








 <!-- section-partners -->
 <section class="section-home-partners text-center">
        <div class="container">
			<h2><?= lg('move.page.partners.title')?></h2>
            <div class="carousel-partners">
                <div class="item">
                <a href="#">

					<!-- <a href="https://www.rtbf.be/info/societe/onpdp/pigeons-ou-pas-pigeons/detail_boxify-bruxelles-pour-stocker-votre-surplus-en-toute-securite?id=9474804" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_rtbf.jpg') }}" alt="RTBF - on est pas de pigeons" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="https://www.rtbf.be/info/societe/onpdp/pigeons-ou-pas-pigeons/detail_boxify-bruxelles-pour-stocker-votre-surplus-en-toute-securite?id=9474804" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_on-est-pas-des-pigeons.jpg') }}" alt="RTBF - on est pas de pigeons" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://www.lalibre.be/video/boxify-une-nouvelle-solution-bruxelloise-de-stockage-57e92273cd70f8c3926f0389" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_la-libre.jpg') }}" alt="La libre" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://www.dhnet.be/video/boxify-une-nouvelle-solution-bruxelloise-de-stockage-57e92273cd70f8c3926f0382" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_ladh.jpg') }}" alt="DH.BE" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://www.vivreici.be/article/detail_boxify-une-nouvelle-solution-de-stockage-bruxelloise-pour-les-entreprises-et-particuliers?id=102297" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_vivre-ici.jpg') }}" alt="Vivre Ici" />
					</a>
				</div>
                <div class="item">
                <a href="#">
                    <!-- <a href="https://www.solutions-magazine.com/boxify-reinvente-stockage-physique/" target="_blank"> -->
                        <img src="{{ asset('assets/img/partners/logo_digital-energy-solution.jpg') }}" alt="Solution Magazine" />
                    </a>
                </div>
                <div class="item">
                <a href="#">
                    <!-- <a href="https://www.dvo.be/artikel/53832-boxify-innoveert-met-flexibele-opslagdienst/" target="_blank"> -->
                        <img src="{{ asset('assets/img/partners/logo_dvo.jpg') }}" alt="DVO" />
                    </a>
                </div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://www.flanderstoday.eu/business/week-business-5-august  + https://nl.boxify.be/files/press/FlanderToday_Augustus16_2016-08-10.pdf" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_flanders-today.jpg') }}" alt="Flander Today" />
					</a>
				</div>
				<div class=item>
        <a href="#">
					<!-- <a href="http://onlinetouch.be/beci/2015-dot-10-brussel-metropool?html=true#/51/" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_brussel-metropole.jpg') }}" alt="Brussel Metropool" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://onlinetouch.be/beci/2015-dot-10-bruxelles-metropole?html=true#/51/" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_bruxelles-metropole.jpg') }}" alt="Bruxelles Metropole" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="https://fr.boxify.be/files/press/LaCapitale_Aout16_2016-08-20.pdf" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_la-capitale.jpg') }}" alt="La Capitale" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="https://www.youtube.com/watch?v=UpcopO6T_QY&feature=youtu.be" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_vivacite.jpg') }}" alt="Vivacité" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="http://www.rtl.be/info/video/593602.aspx" target="_blank"> -->
						<img src="{{ asset('assets/img/partners/logo_rtl-tvi.jpg') }}" alt="RTL TVI" />
					</a>
				</div>
				<div class="item">
        <a href="#">
					<!-- <a href="https://www.bruzz.be/samenleving/brusselse-start-boxify-stockeert-je-overbodige-spullen-2016-08-02" target="_blank"> -->
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
    </section><!-- / section-partners -->

















 <section id="form-contact">
        <div class="container">
        <h3 class="text-center mt-100"><?= $form['title']; ?></h3>
            <form class="form-contact col-xs-12 col-sm-8 col-sm-offset-2" action="#" method="post">
                @if($mailSent)
                    <div class="alert alert-success"><?= $form['thankyou']; ?></div>
                @endif

                <input type="hidden" name="_token" value="<?= csrf_token(); ?>"/>

                <div class="form-group">
                    <label for="name" class="sr-only"><?= lg("coverage.common.name") ?></label>
                    <input type="text" class="form-control" name="name" id="name"
                           placeholder="<?= lg("common.name") ?> *" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="sr-only"><?= lg("common.phone") ?></label>
                    <input type="text" class="form-control" name="phone" id="phone"
                           placeholder="<?= lg("common.phone") ?> *" required>
                </div>

                <div class="form-group">
                    <label for="email" class="sr-only"><?= lg("common.Email") ?></label>
                    <input type="email" class="form-control" name="email" id="email"
                           placeholder="<?= lg("common.Email") ?> *" required>
                </div>

                <div class="form-group">
                    <label for="business" class="sr-only"><?= lg("common.business") ?></label>
                    <input type="text" class="form-control" name="business" id="business"
                           placeholder="<?= lg("common.business") ?> *" required>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-xs-12 col-sm-4">
                            <label for="option_move"><?= lg('move.page.store.form-section-title-choice')  ?></label>
                        </div>




                        <div class="col-xs-6 col-sm-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="option_move"
                                       value="Yes"><?= lg('move.page.store.form-section-first-choice') ?>
                            </label>
                        </div>


                        <div class="col-xs-6 col-sm-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="option_other"
                                       value="Yes"><?= lg('move.page.store.form-section-second-choice') ?>
                            </label>
                        </div>






                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="message" id="message"
                              placeholder="<?= lg("common.Your message") ?> *" required></textarea>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit"><?= lg("common.Submit") ?></button>
                </div>
                <br/>
                <br/>
                <br/>

            </form>
        </div>
    </section>








@stop
@section('js')
<div class="modal fade" id="modal-coverage-map" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= lg('Coverage map') ?></h4>
                <p><?= lg("We serve a select area within Belgium. Explore the map below to see if you're in our local service.") ?>'</p>
            </div>
            <div class="modal-body">
                <div id="coverage-map"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">
                    <?= lg("coverage.Get started") ?>
                </button>
            </div>
        </div>
    </div>
</div>

@parent
@stop











