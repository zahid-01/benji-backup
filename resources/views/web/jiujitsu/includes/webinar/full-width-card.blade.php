<a href="{{ $webinar->getUrl() }}" class="flex gap-x-6 hover:opacity-70 {{ isset($class) ? $class : '' }}"
    data-webinar="{{ $webinar->id . '_webinar' }}">
    <figure class="w-full md:w-96 max-h-48 lg:h-48 relative rounded-xl">
        @if (method_exists($webinar, 'getImage'))
            <img src="{{ $webinar->getImage() }}" alt="{{ $webinar->title }}" class="rounded-xl h-full w-full" />
        @elseif ($webinar->thumbnail)
            <img src="{{ $webinar->thumbnail }}" alt="{{ $webinar->title }}" class="rounded-xl h-full w-full" />
        @endif
        <div class="badge bg-black80 text-white absolute bottom-3 right-2 border-0 rounded">
            {{ convertMinutesToHourAndMinute($webinar->duration) }}
        </div>
    </figure>
    <div class="flex w-full justify-between py-2">
        <div class="flex flex-col gap-2">
            <h2 class="card-title items-start line-clamp-2">
                {{ $webinar->title }}
            </h2>
            <div>
                {!! Str::limit(strip_tags($webinar->description), 200, '...') !!}
            </div>
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

            <div class="text-slate-600 text-sm font-light">{{ convertMinutesToHourAndMinute($webinar->duration) }}
                {{ trans('home.hours') }}</div>
        </div>

        <div class="flex gap-4">

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

        </div>



    </div>
</a>
