@if ($faqs)
    <div class="order-faq text-center">
        <p class="title"><?= lg('order.faq.title') ?></p>

        <div class="row">
            @foreach ($faqs as $key => $faq)
                @if (is_array($faq))
                    @if ($key % 2 == 0)
                        <div class="col-md-5 text-left">
                    @else
                        <div class="col-md-5 col-md-offset-1 text-left">
                    @endif
                        <p class="faq-title"><?= $faq['title'] ?></p>
                        <p class="faq-content"><?= $faq['content'] ?></p>
                    </div>

                    @if (count($faqs) > 2 && $key % 2 == 0 && count($faqs) > $key + 1)
                        </div>
                        <div class="divider divider--hidden divider--x3"></div>
                        <div class="row">
                    @endif
                @endif
            @endforeach
        </div>
    </div>
@endif
