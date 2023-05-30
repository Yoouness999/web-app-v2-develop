<!-- section-cta -->
<section class="section-cta section bg-primary text-center">

	<h3><?= lg("common.Ready to store?") ?></h3>

	@if($user)
		<a class="btn btn-primary btn-outline" href="/user/pickup"><?= lg("Get Started") ?></a>
	@else
		<a class="btn btn-primary btn-outline" href="/signup"><?= lg("common.Get Started") ?></a>
	@endif

</section><!-- / section-cta -->
