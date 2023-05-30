<!-- footer -->
<footer class="footer">

	<div class="container" itemscope itemtype="https://schema.org/Organization">

		<!-- first-row -->
		<div class="row first-row">
			<div class="col-md-6">
				<h4>
					<i class="fa fa-clock-o" aria-hidden="true"></i>
					<span class="text-primary"><?= lg("common.Helpcenter") ?></span>
					<?= lg("common.support.time") ?>
				</h4>
			</div>

			<div class="col-md-3 text-right">
				<h4 itemprop="telephone">
					<!-- <i class="fa fa-phone-square"></i> -->
					<?= lg("common.boxify_phone") ?>
				</h4>
			</div>

			<div class="col-md-3 text-right">
				<h4 itemprop="email">
					<i class="fa fa-envelope" aria-hidden="true"></i>
					<?= lg("common.boxify_email") ?>
				</h4>
			</div>
		</div><!-- / first-row -->

		<!-- second-row -->
		<div class="row second-row">
			<div class="col-md-3 col-sm-12">
				<a class="footer-brand" href="{{ url('/') }}">
                	<img src="/assets/img/boxify-logo.png" alt="Boxify">
				</a>
			</div>

			@if (isset($navigations['navbar']))
				@foreach ($navigations['navbar'] as $key => $value)
					<div class="<?= ($key == count($navigations['navbar']) - 1) ? 'col-md-2 col-xs-12' : 'col-md-2 col-sm-6 col-xs-6' ?>">
						<ul class="nav-footer">
							@foreach ($value as $k => $v)
								@if (isset($v['link']))
                                    @if(LEVEL_ENV != 3 || $v['link'] !== '/page/business')
									<li><a href="<?= url($v['link']) ?>" @if(array_key_exists('target', $v)) target="<?= $v['target'] ?>" @endif><?= $v['name'] ?></a></li>
                                    @endif
								@endif
							@endforeach
						</ul>
					</div>
				@endforeach
			@endif

			<div class="col-md-3 col-sm-12 col-xs-12">
				<h4 class="text-center"><?= lg("common.Connect with us") ?></h4>

				<ul class="list-social">
					<li>
						<a href="https://www.facebook.com/boxifybelgium" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-facebook fa-fw" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://www.instagram.com/boxify_belgium/" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-instagram fa-fw" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://twitter.com/boxify_belgium" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-twitter fa-fw" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://www.linkedin.com/company/boxify" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-linkedin fa-fw" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://www.pinterest.com/boxify/" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-pinterest-p fa-fw" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://yelp.be/biz/boxify-bruxelles" target="_blank" rel="external" itemprop="sameAs">
							<i class="fa fa-yelp fa-fw" aria-hidden="true"></i>
						</a>
					</li>
				</ul>
			</div>

		</div><!-- / second-row -->

		<!-- third-row -->
		<div class="row third-row">
			<div class="text-center">
				<h4>&copy; Boxify {{ date('Y') }}, <?= lg("Brussels") ?>, BE - <a href="/page/privacy"><?= lg("common.Privacy") ?></a>	</h4>
			</div>
		</div><!-- / third-row -->

	</div>

</footer><!-- / footer -->
