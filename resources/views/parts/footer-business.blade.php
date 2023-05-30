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
					<?= lg("business.phone") ?>
				</h4>
			</div>

			<div class="col-md-3 text-right">
				<h4 itemprop="email">
					<i class="fa fa-envelope" aria-hidden="true"></i>
					<?= lg("business.email") ?>
				</h4>
			</div>
		</div>
		<!-- / first-row -->

		<!-- second-row -->
		<div class="row second-row">
			<div class="col-md-3 col-sm-12">
				<a class="footer-brand" href="{{ url('/page/business') }}">
                	<img src="/assets/img/boxify-logo.png" alt="Boxify">
				</a>
			</div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <ul class="nav-footer">
                    <li>
                        <a href="/page/move"><?= lg("business.menu.navbar.move") ?></a>
                    </li>
                    <li>
                        <a href="/page/business"><?= lg("business.menu.navbar.archive") ?></a>
                    </li>
                    <li>
                        <a href="/page/merchandise"><?= lg("business.menu.navbar.merchandise") ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <ul class="nav-footer">
                    <li>
                        <a href="/page/terms"><?= lg("business.menu.navbar.terms") ?></a>
                    </li>
                    <li>
                        <a href="/page/storage-rules"><?= lg("business.menu.navbar.storagerule") ?></a>
                    </li>
                    <li>
                        <a href="/page/faq"><?= lg("business.menu.navbar.faq") ?></a>
                    </li>
                    <li>
                        <a href="/page/about"><?= lg("business.menu.navbar.about") ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-12">
                <ul class="nav-footer">
                    <li>
                        <a href="/page/contact"><?= lg("business.menu.navbar.contact") ?></a>
                    </li>
                </ul>
            </div>

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
