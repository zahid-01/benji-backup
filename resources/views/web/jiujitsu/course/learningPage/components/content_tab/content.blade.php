@php
    $icon = '';
    $hintText= '';

    if ($type == \App\Models\WebinarChapter::$chapterSession) {
        $icon = 'video';
        $hintText = dateTimeFormat($item->date, 'j M Y  H:i') . ' | ' . $item->duration . ' ' . trans('public.min');
    } elseif ($type == \App\Models\WebinarChapter::$chapterFile) {
        $hintText = trans('update.file_type_'.$item->file_type) . ($item->volume > 0 ? ' | '.$item->getVolume() : '');

        $icon = $item->getIconByType();
    } elseif ($type == \App\Models\WebinarChapter::$chapterTextLesson) {
        $icon = 'file-text';
        $hintText= $item->study_time . ' ' . trans('public.min');
    }

    $checkSequenceContent = $item->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp

<div class="items-center grid mb-3 p-2 rounded-lg grid-cols-5 cursor-pointer {{ (!empty($checkSequenceContent) and $sequenceContentHasError) ? 'js-sequence-content-error-modal' : 'tab-item' }}"
     data-type="{{ $type }}"
     data-id="{{ $item->id }}"
     data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
     data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}"
>

        <span class="flex items-center justify-center mr-15 col-span-2">
            {{-- <i data-feather="{{ $icon }}" class="text-slate-500" width="16" height="16"></i> --}}
            <img src="{{ $course->getImageCover() }}" class="rounded-md w-full" alt="{{ $course->title }}" />
        </span>

    <div class="font-bold text-black text-sm file-title ml-3 col-span-3">
        <div class="">
            <span class="font-medium text-sm text-dark-blue block">{{ $item->title }}</span>
            {{-- <span class="text-sm text-slate-500 block">{{ $hintText }}</span> --}}
        </div>


        <div class="tab-item-info mt-15">
            {{-- <p class="text-sm text-slate-500 block">
                @php
                    $description = !empty($item->description) ? $item->description : (!empty($item->summary) ? $item->summary : '');
                @endphp

                {!! truncate($description, 150) !!}
            </p> --}}

            {{-- <div class="flex items-center justify-between mt-15">
                <label class="mb-0 mr-10 cursor-pointer font-weight-normal text-sm text-dark-blue" for="readToggle{{ $type }}{{ $item->id }}">{{ trans('public.i_passed_this_lesson') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" @if($sequenceContentHasError) disabled @endif id="readToggle{{ $type }}{{ $item->id }}" data-item-id="{{ $item->id }}" data-item="{{ $type }}_id" value="{{ $item->webinar_id }}" class="js-passed-lesson-toggle custom-control-input" @if(!empty($item->checkPassedItem())) checked @endif>
                    <label class="custom-control-label" for="readToggle{{ $type }}{{ $item->id }}"></label>
                </div>
            </div> --}}
        </div>
    </div>
</div>
