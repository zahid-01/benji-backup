@php
    $checkSequenceContent = $quiz->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp


<div class="collapse collapse-arrow border border-slate-200 mt-6">
    <input type="checkbox" name="collapseChapterInner" />
    <div class="collapse-title flex font-medium items-center justify-between" role="tab" id="quiz_{{ $quiz->id }}">

        <div class="flex items-center" href="#collapseQuiz{{ !empty($tagId) }}{{ $quiz->id }}"
            aria-controls="collapseQuiz{{ !empty($tagId) }}{{ $quiz->id }}" data-parent="#{{ $accordionParent }}"
            role="button" data-toggle="collapse" aria-expanded="true">
            <span class="flex items-center justify-center mr-15">
                <span class="chapter-icon chapter-content-icon">
                    <i data-feather="file-text" width="20" height="20" class="text-slate-500"></i>
                </span>
            </span>

            <span class="font-bold text-black text-sm file-title ml-3">{{ $quiz->title }}</span>

        </div>

    </div>

    <div id="collapseQuiz{{ !empty($tagId) }}{{ $quiz->id }}" aria-labelledby="quiz_{{ $quiz->id }}"
        class="collapse-content" role="tabpanel">
        <div class="border-t border-slate-200 pt-8">
            <div class="flex items-center mt-4">
                <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                    <i data-feather="help-circle" width="18" height="18" class="text-slate-500 mr-5"></i>
                    <span class="line-height-1">{{ $quiz->quizQuestions->count() }}
                        {{ trans('public.questions') }}</span>
                </div>

                <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                    <i data-feather="clock" width="18" height="18" class="text-slate-500 mr-5"></i>
                    <span class="line-height-1">{{ $quiz->time }} {{ trans('public.min') }}</span>
                </div>

                <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                    <i data-feather="check-square" width="18" height="18" class="text-slate-500 mr-5"></i>
                    <span class="line-height-1">{{ trans('update.passed_grade') }}:
                        {{ $quiz->pass_mark }}/{{ $quiz->quizQuestions->sum('grade') }}</span>
                </div>

                <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                    <i data-feather="check-square" width="18" height="18" class="text-slate-500 mr-5"></i>
                    <span class="line-height-1">{{ trans('update.attempts') }}:
                        {{ (!empty($user) and !empty($quiz->result_count)) ? $quiz->result_count : '0' }}/{{ $quiz->attempt }}</span>
                </div>

                @if (!empty($user) and !empty($quiz->result_status))
                    <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                        <i data-feather="check-square" width="18" height="18" class="text-slate-500 mr-5"></i>
                        <div class="line-height-1 text-slate-500 text-sm text-center">
                            <span
                                class="@if ($quiz->result_status == 'passed') text-primary @elseif($quiz->result_status == 'failed') text-danger @else text-warning @endif">
                                @if ($quiz->result_status == 'passed')
                                    {{ trans('quiz.passed') }}
                                @elseif($quiz->result_status == 'failed')
                                    {{ trans('quiz.failed') }}
                                @elseif($quiz->result_status == 'waiting')
                                    {{ trans('quiz.waiting') }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endif

            </div>

            <div class="flex items-center justify-end py-4 mt-4 border-t border-slate-200">
                @if (!empty($user) and $quiz->can_try and $hasBought)
                    <a href="/panel/quizzes/{{ $quiz->id }}/start"
                        class="course-content-btns btn btn-sm btn-primary">{{ trans('quiz.quiz_start') }}</a>
                @else
                    <button type="button"
                        class="course-content-btns btn btn-sm btn-gray disabled {{ empty($user) ? 'not-login-toast' : (!$hasBought ? 'not-access-toast' : (!$quiz->can_try ? 'can-not-try-again-quiz-toast' : '')) }}">
                        {{ trans('quiz.quiz_start') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
