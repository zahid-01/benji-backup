@php
    $checkSequenceContent = $item->checkSequenceContent();
   $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp


<div class="{{ (!empty($checkSequenceContent) and $sequenceContentHasError) ? 'js-sequence-content-error-modal' : 'tab-item' }} p-10 cursor-pointer {{ $class ?? '' }}"
     data-type="{{ $type }}"
     data-id="{{ $item->id }}"
     data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
     data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}"
>

    <div class="flex items-center">
        <span class="chapter-icon bg-gray300 mr-10">
            <i data-feather="award" class="text-slate-500" width="16" height="16"></i>
        </span>

        <div class="grow">
            <span class="font-medium text-sm text-dark-blue block">{{ $item->title }}</span>

            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-500 block">
                    @if(!empty($item->time))
                        {{ $item->time .' '. trans('public.min') }}
                    @else
                        {{ trans('update.unlimited_time') }}
                    @endif

                    {{ ($item->quizQuestions ? ' | ' . (($item->display_limited_questions and !empty($item->display_number_of_questions)) ? $item->display_number_of_questions : $item->quizQuestions->count()) .' '. trans('public.questions') : '') }}
                </span>

                @if(!empty($quiz->result_status))
                    @if($quiz->result_status == 'passed')
                        <span class="text-sm text-primary">{{ trans('quiz.passed') }}</span>
                    @elseif($quiz->result_status == 'failed')
                        <span class="text-sm text-danger">{{ trans('quiz.failed') }}</span>
                    @elseif($quiz->result_status == 'waiting')
                        <span class="text-sm text-warning">{{ trans('quiz.waiting') }}</span>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
