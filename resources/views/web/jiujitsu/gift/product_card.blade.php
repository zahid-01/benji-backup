<div class="gift-webinar-card bg-white">
    <figure>
        <div class="image-box">
            <a href="{{ $product->getUrl() }}">
                <img src="{{ $product->thumbnail }}" class="img-cover" alt="{{ $product->title }}">
            </a>
        </div>

        <figcaption class="mt-10">
            <div class="user-inline-avatar flex items-center">
                <div class="avatar bg-gray200">
                    <img src="{{ $product->creator->getAvatar() }}" class="img-cover" alt="{{ $product->creator->full_name }}">
                </div>
                <a href="{{ $product->creator->getProfileUrl() }}" target="_blank" class="user-name ml-2 text-sm">{{ $product->creator->full_name }}</a>
            </div>

            <a href="{{ $product->getUrl() }}">
                <h3 class="mt-15 webinar-title font-bold font-16 text-dark-blue">{{ clean($product->title, 'title') }}</h3>
            </a>

            @if($product->getRate())
                @include('web.jiujitsu.includes.webinar.rate',['rate' => $product->getRate()])
            @endif

            <div class="webinar-price-box mt-15">
                @if(!empty($product->price) and $product->price > 0)
                    @if($product->getPriceWithActiveDiscountPrice() < $product->price)
                        <span class="real">{{ handlePrice($product->getPriceWithActiveDiscountPrice(), true, true, false, null, true, 'store') }}</span>
                        <span class="off ml-10">{{ handlePrice($product->price, true, true, false, null, true, 'store') }}</span>
                    @else
                        <span class="real">{{ handlePrice($product->price, true, true, false, null, true, 'store') }}</span>
                    @endif
                @else
                    <span class="real text-sm">{{ trans('public.free') }}</span>
                @endif
            </div>
        </figcaption>
    </figure>
</div>
