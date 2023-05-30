<section>
    <h4 class="primary-color mt-10"><?= lg("common.Search") ?></h4>

    <form class="form" action="/blog/search" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
        <meta itemprop="target" content="<?= url('/blog/search') ?>?q={q}"/>
        <div class="input-group">
            <input class="form-control" type="text" name="q" value="{{ request()->get('q') }}" itemprop="query-input">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</section>

<section class="mt-25 mb-50">
    <h4 class="primary-color"><?= lg("common.Categories") ?></h4>
    <ul class="nav">
        @foreach(DM()->getCategories() as $key => $value)
            @if($value['parent_id'] == 1)
                <li><a href="/blog/search/<?= str_slug($value['name']); ?>?cat=<?= $key; ?>"><?= ucfirst($value['name']); ?></a></li>
            @endif
        @endforeach
    </ul>
</section>

@if(isset($content))
    <a href="/blog" class="btn btn-block btn-primary mt-50 mb-50">< <?= lg("common.Return") ?></a>
@endif

<!--<section class="mt-20">
    <h4 class="primary-color"><?= lg("common.Tags") ?></h4>
    <ul>
        @foreach(DM()->getTags() as $key => $value)
        <li><a href="?cat=<?= $key; ?>"><?= $value['name']; ?></a></li>
        @endforeach
        </ul>
    </section>-->








