@php
    $checkSequenceContent = $assignment->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp

<div class="collapse collapse-arrow border border-slate-200 mt-6">
    <input type="checkbox" name="collapseChapterInner" />
    <div class="collapse-title flex font-medium items-center justify-between" role="tab"
        id="assignment_{{ $assignment->id }}">
        <div class="flex items-center" href="#collapseAssignment{{ $assignment->id }}"
            aria-controls="collapseAssignment{{ $assignment->id }}" data-parent="#{{ $accordionParent }}" role="button"
            data-toggle="collapse" aria-expanded="true">

            <span class="flex items-center justify-center mr-15">
                <i data-feather="feather" width="20" height="20" class="text-slate-500"></i>
            </span>

            <span class="font-bold text-black text-sm file-title ml-3"> {{ $assignment->title }}</span>
        </div>
    </div>

    <div id="collapseAssignment{{ $assignment->id }}" aria-labelledby="assignment_{{ $assignment->id }}"
        class="collapse-content" role="tabpanel">
        <div class="border-t border-slate-200 pt-8">
            <div class="text-slate-500">
                {!! nl2br(clean($assignment->description)) !!}
            </div>

            <div class="flex items-center justify-between py-4 mt-4 border-t border-slate-200">

                <div class="flex items-center">
                    <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                        <i data-feather="clock" width="18" height="18" class="text-slate-500 mr-5"></i>
                        <span class="line-height-1">{{ trans('update.min_grade') }}:
                            {{ $assignment->pass_grade }}</span>
                    </div>
                </div>

                <div class="">
                    @if (!empty($checkSequenceContent) and $sequenceContentHasError)
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray grow disabled js-sequence-content-error-modal"
                            data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
                            data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">{{ trans('public.read') }}</button>
                    @elseif(!empty($user) and $hasBought)
                        <a href="{{ $course->getLearningPageUrl() }}?type=assignment&item={{ $assignment->id }}"
                            target="_blank" class="course-content-btns btn btn-sm btn-primary">
                            {{ trans('public.read') }}
                        </a>
                    @else
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray disabled {{ empty($user) ? 'not-login-toast' : (!$hasBought ? 'not-access-toast' : '') }}">
                            {{ trans('public.read') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
