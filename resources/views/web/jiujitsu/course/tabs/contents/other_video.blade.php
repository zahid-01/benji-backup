@php
    $canSale = ($course->canSale() and !$hasBought);
@endphp

<div class="mt-3">
    <div class="flex font-medium items-center justify-between" role="tab" id="files_{{ $file->id }}">
        @if ($file->price > 0)
            @if ($file->accessibility === 'free')
                <div class="items-center grid grid-cols-5 cursor-pointer">
                    <span class="flex items-center justify-center mr-15 col-span-2">
                        <a href="{{ url('/course/' . $file->slug) }}?file_id={{ $file->id }}" 
                            class="relative flex rounded-md overflow-hidden">
                            <img src="{{ $file->thumbnail }}" class="rounded-md w-full" alt="{{ $file->title }}" />
                        </a>
                    </span>
                    <span class="ml-3 col-span-3">
                        {{-- <span class="text-xs leading-3">{{ $file->webinar_name }}</span> --}}
                        <a href="{{ url('/course/' . $file->slug) }}?file_id={{ $file->id }}"
                            class="relative flex rounded-md overflow-hidden font-bold text-black text-sm file-title">
                            {{ $file->title }}
                        </a>
                    </span>
                </div>
            @else
                <form action="/cart/store" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="item_id" value="{{ $file->webinars_id }}">
                    <input type="hidden" name="item_name" value="webinar_id">

                    <div class="items-center grid grid-cols-5 js-course-direct-payment cursor-pointer">
                        <span class="flex items-center justify-center mr-15 col-span-2">
                            <a type="button" class="relative flex rounded-md overflow-hidden">
                                <img src="{{ $file->thumbnail }}" class="rounded-md w-full"
                                    alt="{{ $file->title }}" />
                                <div class="w-full h-full absolute bg-black/50">&nbsp;</div>
                                <img src="/assets/default/img/learning/lock.svg" alt=""
                                    class="inset-center absolute w-14 rounded-circle">
                            </a>
                        </span>
                        <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                            <a type="button">
                                {{ $file->title }}
                            </a>
                        </span>
                    </div>
                </form>
            @endif
        @else
            <div class="items-center grid grid-cols-5">
                <span class="flex items-center justify-center mr-15 col-span-2">
                    <a href="{{ url('/course/' . $file->slug) }}?file_id={{ $file->id }}" type="button"
                        class="relative flex rounded-md overflow-hidden">
                        <img src="{{ $file->thumbnail }}" class="rounded-md w-full" alt="{{ $file->title }}" />
                    </a>
                </span>
                <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                    <a href="{{ url('/course/' . $file->slug) }}?file_id={{ $file->id }}" type="button"
                        class="relative flex rounded-md overflow-hidden">
                        {{ $file->title }}
                    </a>
                </span>
            </div>
        @endif
    </div>
</div>
