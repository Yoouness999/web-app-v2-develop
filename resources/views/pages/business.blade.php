<?php
    $businessPage = true;
?>

@extends('layouts.default')


@section('content')




<div id="businessCarousel" class="carousel slide animated fadeIn" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="page-banner page-banner-lg">
                <img class="sr-only" src="{{ asset('assets/img/bg-b2B_header.jpg') }}" alt="Boxify archiving storage service Banner">
                <div class="background-banner mobile" style="background-image: url({{ asset('assets/img/bg-b2B_header_mobile.jpg') }})"></div>
                <div class="background-banner desktop" style="background-image: url({{ asset('assets/img/bg-b2B_header.jpg') }})"></div>
                <div class="page-banner-content">
                    <h1><?= lg('archive.storage.page.header.title')?></h1>
                    <h2><?= lg('archive.storage.page.header.subtitle')?></h2>
                    <a class="btn btn-primary" href="#form-contact"><?= lg('archive.storage.page.header.button')?></a>
                </div>
            </div>
        </div>
    </div>









 <!-- stepper-advantage-section -->

<section class="stepper-advantage-section-merchandise text-center">
  <div class="container black" style="display: flex; flex-direction: row; justify-content: space-between;">
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/xuhnd2ap.png?w=48" alt="<?= lg('archive.storage.page.advantage.security')?>" />
        </p>
        <h3 class="title"><?= lg('archive.storage.page.advantage.security')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/6d5fio4d.png?w=48" alt="<?= lg('archive.storage.page.advantage.capacity')?>" />
        </p>
        <h3 class="title"><?= lg('archive.storage.page.advantage.capacity')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/t7e72zjw.png?w=48" alt="<?= lg('archive.storage.page.advantage.conservation')?>" />
        </p>
        <h3 class="title"><?= lg('archive.storage.page.advantage.conservation')?></h3>
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/4n26c7rj.png?w=48" alt="<?= lg('archive.storage.page.advantage.delivery')?>" />
        </p>
        <h3 class="title"><?= lg('archive.storage.page.advantage.delivery')?></h3>
      </div>
    </div>
    <!-- <div class="col-12 col-md-3 d-flex flex-column align-items-center">
      <div class="item">
        <p class="image">
          <img src="https://landen.imgix.net/uhtii1k9o5x3/assets/4n26c7rj.png?w=48" alt="<?= lg('archive.storage.page.advantage-pay')?>" />
        </p>
        <h3 class="title"><?= lg('archive.storage.page.advantage-pay')?></h3>
      </div>
    </div> -->
  </div>
</section>


<!-- //Services Section -->







 <!-- benefits-section -->

<section class="benefits-section-arch">
  <div class="box">
    <div class="section">
      <div class="features">
        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3"><?= lg('archive.storage.page.benefits.heading.title')?></h2>
        </div>


        <div class="feature">

        <div class="circle">
             <i class="fa fa-get-pocket" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('archive.storage.page.benefits.security.title')?></h3>
            <p><?= lg('archive.storage.page.benefits.security.subtitle')?></p>
          </div>
        </div>
        <div class="feature">

        <div class="circle">
             <i class="fa fa-globe" style="color: #ffffff;" aria-hidden="true"></i>
          </div>


          <div class="feature-info">
            <h3><?= lg('archive.storage.page.benefits.environmental.title')?></h3>
            <p><?= lg('archive.storage.page.benefits.environmental.subtitle')?></p>
          </div>
        </div>
        <div class="feature">

        <div class="circle">
             <i class="fa fa-laptop" style="color: #ffffff;" aria-hidden="true"></i>
          </div>

          <div class="feature-info">
            <h3><?= lg('archive.storage.page.benefits.inventory.title')?></h3>
            <p><?= lg('archive.storage.page.benefits.inventory.subtitle')?></p>
          </div>
        </div>
      </div>
      <img src="{{ asset('assets/img/benefits-section.jpeg') }}" alt="" class="left img-fluid rounded" />
    </div>
  </div>
</section>
<!-- benefits Section -->











 <!-- archiving-section -->
<section class="archiving-section-arch">
<br/>
 <br/>
  <div class="box">
    <div class="section">
      <img src="{{ asset('assets/img/archiving-section.jpeg') }}" alt="" class="img-fluid left" />

      <div class="features">

        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3">
            <?= lg('archive.storage.page.archiving.heading.title')?>
          </h2>
        </div>

        <div class="feature">
        <div class="circle">
             <i class="fa fa-question-circle-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.archiving.analysis.title')?></h3>
            <p><?= lg('archive.storage.page.archiving.analysis.subtitle')?></p>
          </div>
        </div>


        <div class="feature">
        <div class="circle">
             <i class="fa fa-cube" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.archiving.boxes.title')?></h3>
            <p><?= lg('archive.storage.page.archiving.boxes.subtitle')?></p>
          </div>
        </div>

        <div class="feature">
        <div class="circle">
             <i class="fa fa-tv" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.archiving.indexing.title')?></h3>
            <p><?= lg('archive.storage.page.archiving.indexing.subtitle')?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br/>
 <br/>
</section>








 <!-- service-section -->

<section class="service-section-arch ">
  <div class="box">
    <div class="section">
      <div class="features">
        <div class="content-title">
          <h2 class="w3l-title-main mb-lg-4 mb-3"><?= lg('archive.storage.page.service.heading.title')?></h2>
        </div>
        <div class="content-subtitle">
          <h5><?= lg('archive.storage.page.service.heading.subtitle')?></h5>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-building-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.service.solution.title')?></h3>
            <p><?= lg('archive.storage.page.service.solution.subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-user-circle-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.service.collaborators.title')?></h3>
            <p><?= lg('archive.storage.page.service.collaborators-subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-lock" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.service.discretion.title')?></h3>
            <p><?= lg('archive.storage.page.service.discretion.subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-handshake-o" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.service.logistic.title')?></h3>
            <p><?= lg('archive.storage.page.service.logistic.subtitle')?></p>
          </div>
        </div>
        <div class="feature">
        <div class="circle">
             <i class="fa fa-suitcase" style="color: #ffffff;" aria-hidden="true"></i>
          </div>
          <div class="feature-info">
            <h3><?= lg('archive.storage.page.service.developing.title')?></h3>
            <p><?= lg('archive.storage.page.service.developing.subtitle')?></p>
          </div>
        </div>
      </div>
      <img src="{{ asset('assets/img/service-section.jpg') }}" class="desktop"/>
      <!-- <img src="{{ asset('assets/img/service-section-m.jpeg') }}" class="mobile"/>     -->
    </div>
  </div>
  <br/>
 <br/>

</section>











  <!-- section-partners -->
  <br/>
 <br/>
  <section
  class="section-home-partners text-center">
        <div class="container">
			<h2><?= lg('archive.storage.page.partners.title')?></h2>
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















    <!-- form-contact -->

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
                            <label for="option_documents"><?= $form['Je veux stocker'] ?></label>
                        </div>


                        <div class="col-xs-6 col-sm-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="option_documents"
                                       value="Yes"><?= $form['stock_documents'] ?>
                            </label>
                        </div>


                        <div class="col-xs-6 col-sm-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="option_objects"
                                       value="Yes"><?= $form['stock_objects'] ?>
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











