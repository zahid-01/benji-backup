@php
    $checkSequenceContent = $file->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp

@php
    $canSale = ($course->canSale() and !$hasBought);
@endphp
@if (in_array($file->file_type, config('jiujitsu.supported_videos_storage')))
    <div class="mt-3">
        <div class="flex font-medium items-center justify-between" role="tab" id="files_{{ $file->id }}">

            @if (!$canSale and $course->canJoinToWaitlist())
                <div class="items-center grid grid-cols-5">
                    <span class="flex items-center justify-center mr-15 col-span-2">
                        <a type="button" data-slug="{{ $course->slug }}">
                            <img src="{{ $course->getImageCover() }}" class="rounded-md w-full"
                                alt="{{ $course->title }}" />
                        </a>
                    </span>
                    <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                        <a href="{{ $canSale ? '/course/' . $course->slug . '/free' : '#' }}">
                            {{ $file->title }}
                        </a>
                    </span>
                </div>
            @elseif($hasBought or !empty($course->getInstallmentOrder()))
                <div class="items-center grid grid-cols-5">
                    <span class="flex items-center justify-center mr-15 col-span-2">
                        <a href="{{ $course->getLearningPageUrl() }}">
                            <img src="{{ $course->getImageCover() }}" class="rounded-md w-full"
                                alt="{{ $course->title }}" />
                        </a>
                    </span>
                    <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                        <a href="{{ $course->getLearningPageUrl() }}">
                            {{ $file->title }}
                        </a>
                    </span>
                </div>
            @elseif($course->price > 0)
                @if ($file->accessibility === 'free')
                    <div class="items-center grid grid-cols-5 cursor-pointer">
                        <span class="flex items-center justify-center mr-15 col-span-2">
                            <a type="button" class="relative flex rounded-md overflow-hidden">
                                <img src="{{ $course->getImageCover() }}" class="rounded-md w-full"
                                    alt="{{ $course->title }}" />
                            </a>
                        </span>
                        <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                            <a type="button">
                                {{ $file->title }}
                            </a>
                        </span>
                    </div>
                @else
                    <form action="/cart/store" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $course->id }}">
                        <input type="hidden" name="item_name" value="webinar_id">

                        <div class="items-center grid grid-cols-5 js-course-direct-payment cursor-pointer">
                            <span class="flex items-center justify-center mr-15 col-span-2">
                                <a type="button" class="relative flex rounded-md overflow-hidden">
                                    <img src="{{ $course->getImageCover() }}" class="rounded-md w-full"
                                        alt="{{ $course->title }}" />
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
                        <a href="{{ $canSale ? '/course/' . $course->slug . '/free' : '#' }}">
                            <img src="{{ $course->getImageCover() }}" class="rounded-md w-full"
                                alt="{{ $course->title }}" />
                        </a>
                    </span>
                    <span class="font-bold text-black text-sm file-title ml-3 col-span-3">
                        <a href="{{ $canSale ? '/course/' . $course->slug . '/free' : '#' }}">
                            {{ $file->title }}
                        </a>
                    </span>
                </div>
            @endif

            {{-- <span class="chapter-icon chapter-content-icon">
                    <i data-feather="{{ $file->getIconByType() }}" width="20" height="20"
                        class="text-slate-500"></i>
        </span> --}}
        </div>
    </div>
@endif

{{-- 
    <div id="collapseFiles{{ $file->id }}" aria-labelledby="files_{{ $file->id }}" class=""
        role="tabpanel"> --}}
{{-- <div class="border-t border-slate-200 pt-8"> --}}
{{-- <div class="text-slate-500">
                {!! nl2br(clean($file->description)) !!}
            </div> --}}

{{-- @if (!empty($user) and $hasBought)
                <div class="flex items-center mt-4">
                    <label class="mb-0 mr-10 cursor-pointer font-medium"
                        for="fileReadToggle{{ $file->id }}">{{ trans('public.i_passed_this_lesson') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" @if ($sequenceContentHasError) disabled @endif
                            id="fileReadToggle{{ $file->id }}" data-file-id="{{ $file->id }}"
                            value="{{ $course->id }}" class="js-file-learning-toggle custom-control-input"
                            @if (!empty($file->checkPassedItem())) checked @endif>
                        <label class="custom-control-label" for="fileReadToggle{{ $file->id }}"></label>
                    </div>
                </div>
            @endif --}}

{{-- <div class="flex items-center justify-between py-4 mt-4 border-t border-slate-200">

                <div class="flex items-center">
                    <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                        <i data-feather="download-cloud" width="18" height="18" class="text-slate-500 mr-5"></i>
                        <span class="line-height-1">{{ $file->volume > 0 ? $file->getVolume() : '-' }}</span>
                    </div>
                </div>

                <div class="">
                    @if (!empty($checkSequenceContent) and $sequenceContentHasError)
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray grow disabled js-sequence-content-error-modal"
                            data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
                            data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">{{ trans('public.play') }}</button>
                    @elseif($file->accessibility == 'paid')
                        @if (!empty($user) and $hasBought)
                            @if ($file->downloadable)
                                <a href="{{ $course->getUrl() }}/file/{{ $file->id }}/download"
                                    class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('home.download') }}
                                </a>
                            @else
                                <a href="{{ $course->getLearningPageUrl() }}?type=file&item={{ $file->id }}"
                                    target="_blank" class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </a>
                            @endif
                        @else
                            <button type="button"
                                class="course-content-btns btn btn-sm btn-gray disabled {{ empty($user) ? 'not-login-toast' : (!$hasBought ? 'not-access-toast' : '') }}">
                                @if ($file->downloadable)
                                    {{ trans('home.download') }}
                                @else
                                    {{ trans('public.play') }}
                                @endif
                            </button>
                        @endif
                    @else
                        @if ($file->downloadable)
                            <a href="{{ $course->getUrl() }}/file/{{ $file->id }}/download"
                                class="course-content-btns btn btn-sm btn-primary">
                                {{ trans('home.download') }}
                            </a>
                        @else
                            @if (!empty($user) and $hasBought)
                                <a href="{{ $course->getLearningPageUrl() }}?type=file&item={{ $file->id }}"
                                    target="_blank" class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </a>
                            @elseif($file->storage == 'upload_archive')
                                <a href="/course/{{ $course->slug }}/file/{{ $file->id }}/showHtml"
                                    target="_blank" class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </a>
                            @elseif(in_array($file->storage, ['iframe', 'google_drive', 'dropbox']))
                                <a href="/course/{{ $course->slug }}/file/{{ $file->id }}/play" target="_blank"
                                    class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </a>
                            @elseif($file->isVideo())
                                <button type="button" data-id="{{ $file->id }}" data-title="{{ $file->title }}"
                                    class="js-play-video course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </button>
                            @else
                                <a href="{{ $file->file }}" target="_blank"
                                    class="course-content-btns btn btn-sm btn-primary">
                                    {{ trans('public.play') }}
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
            </div> --}}
{{-- </div> --}}
{{-- </div> --}}
