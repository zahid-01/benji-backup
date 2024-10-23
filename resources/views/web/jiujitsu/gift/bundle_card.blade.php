<div class="gift-webinar-card bg-white">
    <figure>
        <div class="image-box">
            <a href="{{ $bundle->getUrl() }}">
                <img src="{{ $bundle->getImage() }}" class="img-cover" alt="{{ $bundle->title }}">
            </a>
        </div>

        <figcaption class="mt-10">
            <div class="user-inline-avatar flex items-center">
                <div class="avatar bg-gray200">
                    <img src="{{ $bundle->teacher->getAvatar() }}" class="img-cover" alt="{{ $bundle->teacher->full_name }}">
                </div>
                <a href="{{ $bundle->teacher->getProfileUrl() }}" target="_blank" class="user-name ml-2 text-sm">{{ $bundle->teacher->full_name }}</a>
            </div>

            <a href="{{ $bundle->getUrl() }}">
                <h3 class="mt-15 webinar-title font-bold font-16 text-dark-blue">{{ clean($bundle->title,'title') }}</h3>
            </a>

            @if($bundle->getRate())
                @include('web.jiujitsu.includes.webinar.rate',['rate' => $bundle->getRate()])
            @endif

            <div class="webinar-price-box mt-15">
                @if(!empty($bundle->price) and $bundle->price > 0)
                    @if($bundle->bestTicket() < $bundle->price)
                        <span class="real">{{ handlePrice($bundle->bestTicket()) }}</span>
                        <span class="off ml-10">{{ handlePrice($bundle->price) }}</span>
                    @else
                        <span class="real">{{ handlePrice($bundle->price) }}</span>
                    @endif
                @else
                    <span class="real text-sm">{{ trans('public.free') }}</span>
                @endif
            </div>
        </figcaption>
    </figure>
</div>
