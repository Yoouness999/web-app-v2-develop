<?php
/**
 * @see \App\Http\Controllers\OrderController::postStorageFindPrice()
 *
 * @var $currentPlan \App\OrderPlan|null if user is not logged = null
 * @var $currentVolume float|null if user is not logged = null
 * @var $assets array
 */
?>

<section class="section-storage-confirmation section text-center" id="section-storage-{!! $plan->volume_m3 !!}">
<!-- # {!! $plan->id !!}/{!! $plan->volume_m3 !!} -->
    <div class="resume">
        <p class="title">{!! lg('order.storage.total') !!}</p>
        <p class="total">
            @if($newVolume < 1 && $plan)
                {!! str_replace(['m3', 'm<sup>3</sup>', 'm³'], '', strval($plan->name)) !!}m<sup>3</sup>
            @else
                {!! strval($newVolume) !!}m<sup>3</sup>
            @endif
        </p>

        <ul class="items">
            @foreach ($items as $item)
                <li>{!! $item->quantity !!} {!! $item->name !!}</li>
            @endforeach
        </ul>

        @if($currentPlan)
            @if($user && $user->plan)
                <p class="title">{!! shortcode(lg("order.storage.current-user-plan"), ['currentVolume' => $user->plan->volume_m3]) !!} {!! $user->plan->price_per_month !!}{!! lg('€/mo') !!}</p>
            @else
                <p class="title">{!! shortcode(lg("order.storage.current-plan"), ['currentVolume' => $currentVolume]) !!} {!! $currentPlan->price_per_month !!}{!! lg('€/mo') !!}</p>
            @endif
        @endif

        <button class="close" type="button"></button>
    </div>
    <div class="plan">
        <div class="wrapper">
            <div class="description">
                @if ($plan)
                    <input type="hidden" name="plan" value="{!! $plan->id !!}" />
                    <p class="title">{!! lg('order.storage.plan.title') !!}</p>
                    <p class="name">{!! str_replace(['m3', 'm<sup>3</sup>', 'm³'], '', $plan->name) !!}m<sup>3</sup></p>
                    <p class="include">{!! lg('order.storage.plan.includes.title') !!}</p>

                    <div class="row">
                        @if(count($assets))
                            @foreach (array_chunk($assets, round(count($assets) / 2)) as $assetsCol)
                                <div class="col-sm-6">
                                    <ul class="assets">
                                        @foreach ($assetsCol as $asset)
                                            <li>{!! $asset['name'] !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
            <div class="price-wrapper @if($priceWithDiscount) discount @endif">
                <p class="price">{!! implode('<span>.</span>', explode('.', $price)) !!}{!! lg('€/mo') !!}</p>
                <p class="price-discount">{!! implode('<span>.</span>', explode('.', $priceWithDiscount)) !!}{!! lg('€/mo') !!}</p>
                <p class="submit-wrapper">
                    <button class="btn btn-primary" type="submit" onclick="dataLayer.push({'event':'storage_confirmation'});">
                        @if ($plan && $plan->isContactOnly())
                            {!! lg('order.storage.plan.contact-only') !!}
                        @else
                            {!! lg('order.storage.plan.submit') !!}
                        @endif
                    </button>
                </p>
            </div>
        </div>
    </div>
</section>
