@if($user)
<a class="btn btn-primary" href="/user/pickup"><?= lg("common.Get Started") ?></a>
@else
<a class="btn btn-primary" href="/signup"><?= lg("common.Get Started") ?></a>
@endif
