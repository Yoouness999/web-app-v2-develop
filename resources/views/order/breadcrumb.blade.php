<section class="section-breadcrumb section text-center">
    <div class="container">
        <ul>
            @for ($i = 1; $i <= 5; $i++)
                <li @if ($step== $i) class="active" @endif>
                    <span class="number">{{ $i }}</span> <span><?= lg('order.breadcrumb.steps.' . $i) ?></span>
                </li>
            @endfor
        </ul>
    </div>
</section>
