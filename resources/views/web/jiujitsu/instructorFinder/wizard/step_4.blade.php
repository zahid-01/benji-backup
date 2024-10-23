@php
    $days = ['saturday', 'sunday','monday','tuesday','wednesday','thursday','friday'];
@endphp

@push('styles_top')
    <link rel="stylesheet" href="/assets/vendors/wrunner-html-range-slider-with-2-handles/css/wrunner-default-theme.css">
@endpush

<div class="wizard-step-1">
    <h3 class="font-20 text-dark font-bold">{{ trans('update.meeting_time') }}</h3>

    <span class="block mt-6 text-slate-500 wizard-step-num">
        {{ trans('update.step') }} 4/4
    </span>

    <span class="block font-16 font-medium mt-6">{{ trans('update.what_time_is_better_for_the_meeting') }}</span>

    <div class="mb-30 custom-control custom-checkbox mt-6 full-checkbox w-full">
        <input type="checkbox" name="flexible_date" value="1" class="custom-control-input" id="date">
        <label class="custom-control-label text-sm w-full" for="date">{{ trans('update.im_flexible') }}</label>
    </div>

    <div id="dateTimeCard">
        <div class="mb-30 form-group flex items-center flex-wrap">
            @foreach($days as $day)
                <div class="wizard-custom-checkbox">
                    <input type="radio" name="day[]" value="{{ $day }}" id="{{ $day }}" {{ (request()->get('day') == $day) ? 'checked' : '' }}/>
                    <label for="{{ $day }}" class="cursor-pointer">{{ trans('panel.'.$day) }}</label>
                </div>
            @endforeach
        </div>

        <div
            class="range"
            id="timeRange"
            data-minLimit="0"
            data-maxLimit="23"
        >
            <input type="hidden" name="min_time" value="0">
            <input type="hidden" name="max_time" value="23">

        </div>
    </div>
</div>

@push('scripts_bottom')
    <script src="/assets/vendors/wrunner-html-range-slider-with-2-handles/js/wrunner-jquery.js"></script>
@endpush
