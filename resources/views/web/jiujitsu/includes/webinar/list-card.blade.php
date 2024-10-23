<a href="{{ $webinar->getUrl() }}" class="card hover:opacity-70 {{ isset($class) ? $class : '' }}"
    data-webinar="{{ $webinar->id . '_webinar' }}">
    <figure class="course-image">
        @if (method_exists($webinar, 'getImage'))
            <img src="{{ $webinar->getImage() }}" alt="{{ $webinar->title }}" class="rounded-xl h-full w-full" />
        @elseif ($webinar->thumbnail)
            <img src="{{ $webinar->thumbnail }}" alt="{{ $webinar->title }}" class="rounded-xl h-full w-full" />
        @endif
        <div class="badge bg-black80 text-white absolute bottom-3 right-2 border-0 rounded">
            {{ convertMinutesToHourAndMinute($webinar->duration) }}
        </div>
    </figure>
    <div class="card-body px-1 py-4">
        <h2 class="card-title min-h-12 items-start line-clamp-2">
            {{ $webinar->title }}
        </h2>
        @if (method_exists($webinar, 'getRate'))
            @include('web.jiujitsu.includes.webinar.rate', [
                'rate' => $webinar->getRate(),
            ])
        @endif

        @if ($webinar->teacher)
            <div class="text-textGray text-sm font-light">{{ $webinar->teacher->full_name }}</div>
        @elseif ($webinar->creator)
            <div class="text-textGray text-sm font-light">{{ $webinar->creator->full_name }}</div>
        @endif

        <div class="my-1 flex items-center gap-4">

            @if (!empty($webinar->price) and $webinar->price > 0)
                @if (method_exists($webinar, 'bestTicket') && $webinar->bestTicket() < $webinar->price)
                    <div class="flex items-center">
                        <span
                            class="text-primary text-3xl font-black">{{ handlePrice(method_exists($webinar, 'bestTicket') ? $webinar->bestTicket() : $webinar->price, true, true, false, null, true) }}</span>
                        <span
                            class="ml-2 text-xl text-textGray font-light line-through">{{ handlePrice($webinar->price) }}</span>
                    </div>
                @else
                    <span
                        class="text-primary text-3xl font-black">{{ handlePrice($webinar->price, true, true, false, null, true) }}</span>
                @endif
            @else
                <span class="text-primary text-3xl font-black">{{ trans('public.free') }}</span>
            @endif

            {{-- <span class="text-black text-xs font-bold">450+ Student Buy it!</span> --}}
        </div>

    </div>
</a>
