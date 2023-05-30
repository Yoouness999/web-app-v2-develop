<section class="section section-storage text-center blocked {{ ($from === 'pricing' ?: 'bg-gray-lighter-ultra') }}">
    <div class="container">
        @if ($from === 'storage')
            <h1>{{ lg('order.storage.title') }}</h1>
        @elseif ($from === 'pricing')
        @else
            <h2>{{ lg('order.storage.title') }}</h2>
        @endif

        <div class="divider divider--hidden hidden-xs" aria-hidden="true"></div>

        <form class="postal_code-form" action="{{ url('/order') }}" method="post">
            <div>
                <h4>{{ lg('pages/home.order_form.zip_code_title') }}</h4>

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
                        />
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" onclick="dataLayer.push({'event':'zipSearch'});">
                                {{ lg('pages/home.order_form.submit') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <form class="order-storage-form" action="{{ url('/order/storage') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="find_price_url" value="{{ url('/order/storage/find-price') }}">
            <input id="js-postal_code" type="hidden" name="postal_code" />

            <ul class="storing-duration toggle">
                @foreach ($storingDurations as $storingDuration)
                    <li>
                        <input
                            @if (($order && $order->isStoringDurationChecked($storingDuration)) || $storingDuration->slug == '-3_months') checked="checked" @endif
                            data-discount-percentage="{{ $storingDuration->discount_percentage }}"
                            id="{{ $storingDuration->slug }}"
                            name="storing_duration"
                            type="radio"
                            value="{{ $storingDuration->id }}"
                        />
                        <label for="{{ $storingDuration->slug }}">
                            {{ lg('order.storing-duration.' . $storingDuration->slug) }}
                            @if(!empty(lg('order.tooltips.' . $storingDuration->slug)))
                                <i class="fa fa-question-circle" data-toggle="tooltip" data-title="{{ lg('order.tooltips.' . $storingDuration->slug) }}"></i>
                            @endif
                        </label>
                    </li>
                @endforeach
            </ul>

            @if ($from === 'pricing')
                <div class="grid-plans" id="grid-plans">
                    <div class="row">
                        @foreach ($categories as $i => $category)
                            @foreach ($category->plans()->where('visible', 1)->get() as $plan)
                                <div class="col-sm-6 col-md-4 col-lg-3 item {{ $category->slug }}" id="plan-{{ $plan->id }}">
                                    <div class="plan" data-price="{{ $plan->price_per_month }}">
                                        <p class="image">
                                            <img src="{{ asset($plan->image) }}" alt="{{ $plan->slug }}" />
                                        </p>
                                        <p class="name">{{ $plan->name ?: $plan->slug }}</p>
                                        @if($plan->price_per_month)
                                            <p class="price">€<span class="value">--</span>/{{ lg('order.storage.price') }}</p>
                                            <p class="price-discount">€<span class="value"></span>/{{ lg('order.storage.price')  }}</p>
                                        @else
                                            <p>{{ lg('order.storage.contact-only') }}</p>
                                        @endif
                                        <p class="select-plan">
                                            @if($plan->price_per_month)
                                                <label class="btn btn-primary" for="field-plan-{{ $plan->id }}">
                                                    <?= lg('order.storage.select-plan-grid') ?>
                                                </label>
                                            @else
                                                <label class="btn btn-primary" for="field-plan-{{ $plan->id }}">
                                                    <?= lg('order.storage.plan.short.contact-only') ?>
                                                </label>
                                            @endif
                                            <input class="hidden" id="field-plan-{{ $plan->id }}" type="radio" name="plan" value="{{ $plan->id }}" />
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @else
                <?php /*<div class="storage-supplies form-group @if (data_get($order, 'plan.id') != 1) hide @endif">
                    <p class="title"><?= lg('order.calculator.storage-supplies.title') ?></p>

                    @foreach ($storageSuppliesCategory->items()->get() as $item)
                        <p class="item">
                            <input type="hidden" name="volumes[<?= $item->id ?>]" value="<?= $item->volume_m3 ?>" />
                            <span class="increment-wrapper">
                                <input type="text" name="items[<?= $item->id ?>]" id="item-<?= $item->slug ?>" @if ($order && $orderItem=$order->getItem($item->slug)) value="<?= $orderItem['quantity'] ?>" @else value="0" @endif autocomplete="off" />
                                <span class="increment-buttons">
                                    <button type="button" class="increment-add">+</button>
                                    <button type="button" class="increment-remove">-</button>
                                </span>
                            </span>
                            <label for="item-<?= $item->slug ?>">
                                @include('order.svg.items.' . $item->slug)
                                <?= $item->name ?>
                            </label>
                        </p>
                    @endforeach
                </div>*/ ?>

                <div class="carousel-plans loading" id="carousel-plans">
                    @if ($categoryBySlide == 1)
                        <div class="owl-carousel carousel-nav" data-target=".carousel-items">
                            @foreach ($categories as $i => $category)
                                <div class="item{{ $i == 0 ? ' active' : '' }}" data-target=".{{ $category->slug }}">
                                    {{ lg('order.storage.categories.' . $category->slug) }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="carousel-content owl-carousel" data-items="3">
                        @foreach ($categories as $i => $category)
                            @foreach ($category->plans()->where('visible', 1)->get()->sortBy('volume_m3') as $plan)
                                <div class="item {{ $category->slug }}" id="plan-{{ $plan->id }}">
                                    <div class="plan" data-price="{{ $plan->price_per_month }}">
                                        <div class="plan__heading">
                                            <p class="image">
                                                <img src="{{ asset($plan->image) }}" alt="{{ $plan->slug }}" />
                                            </p>
                                        </div>
                                        <div class="plan__body">
                                            <p class="name">{{ $plan->name ?: $plan->slug }}</p>
                                            @if($plan->price_per_month > 0)
                                                <p class="price"><span class="value">--</span>€/{{ lg('order.storage.price') }}</p>
                                                <p class="price-discount"><span class="value"></span>€/{{ lg('order.storage.price') }}</p>
                                            @else
                                                <p>{{ lg('order.storage.contact-only') }}</p>
                                            @endif
                                        </div>
                                        <div class="plan__footer">
                                            <p class="select-plan">
                                                @if($plan->price_per_month > 0)
                                                    <label class="btn btn-primary" for="field-plan-{{ $plan->id }}">
                                                        {{ lg('order.storage.select-plan') }}
                                                    </label>
                                                @else
                                                    <label class="btn btn-primary" for="field-plan-{{ $plan->id }}">
                                                        {{ lg('order.storage.plan.short.contact-only') }}
                                                    </label>
                                                @endif
                                                <input class="hidden" id="field-plan-{{ $plan->id }}" type="radio" name="plan" value="{{ $plan->id }}" />
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row calculator">
                <div class="text">
                    <p class="title">{{ lg('order.storage.calculator.title') }}</p>
                    <p class="content">{{ lg('order.storage.calculator.content') }}</p>
                </div>
                <div class="button">
                    <a class="btn btn-primary" href="{{ url('/order/calculator') }}">{{ lg('order.storage.calculator.button') }}</a>
                </div>
            </div>

            <div class="divider divider--hidden divider--x3"></div>

            <div class="row plans-detail">
                <div class="col-md-8 include">
                    <p class="title">{{ lg('order.storage.plans-detail.include.title') }}</p>
                    <ul>
                        @foreach ($assets as $asset)
                            <li>{{ $asset->name ?: $asset->slug }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4 contact">
                    <p class="title">{{ lg('order.storage.plans-detail.contact.title') }}</p>
                    <p class="content">{{ lg('order.storage.plans-detail.contact.content') }}</p>
                    <p class="phone">
                        {{ lg('order.storage.plans-detail.contact.phone') }} <a href="tel:+3223185916">+32 2 318 59 16</a>
                    </p>
                </div>
            </div>

            <div class="divider divider--hidden divider--x3"></div>
        </form>
    </div>
</section>
