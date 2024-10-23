<div class="row">
    <div class="col-12">
        <div class="accordion-content-wrapper" id="certificateAccordion" role="tablist" aria-multiselectable="true">
            @foreach ($quizzes as $quiz)
                @if (!empty($quiz->certificate))
                    <div class="collapse collapse-arrow border border-slate-200 mt-6">
                        <input type="checkbox" name="collapseChapterInner" />
                        <div class="collapse-title flex font-medium items-center justify-between" role="tab"
                            id="quizCertificate_{{ $quiz->id }}">

                            <div class="flex items-center" href="#collapseQuizCertificate{{ $quiz->id }}"
                                aria-controls="collapseQuizCertificate{{ $quiz->id }}"
                                data-parent="#certificateAccordion" role="button" data-toggle="collapse"
                                aria-expanded="true">
                                <span class="chapter-icon chapter-content-icon mr-15">
                                    <i data-feather="award" width="20" height="20" class="text-slate-500"></i>
                                </span>

                                <span class="font-bold text-sm text-black block">{{ $quiz->title }}</span>
                            </div>

                        </div>

                        <div id="collapseQuizCertificate{{ $quiz->id }}"
                            aria-labelledby="quizCertificate_{{ $quiz->id }}" class="collapse-content" role="tabpanel">
                            <div class="border-t border-slate-200 pt-4">
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center">
                                        @if (!empty($quiz->result))
                                            <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                                                <i data-feather="calendar" width="18" height="18"
                                                    class="text-slate-500 mr-5"></i>
                                                <span
                                                    class="line-height-1">{{ dateTimeFormat($quiz->result->created_at, 'j M Y') }}</span>
                                            </div>
                                        @endif

                                        <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                                            <i data-feather="check-square" width="18" height="18"
                                                class="text-slate-500 mr-5"></i>
                                            <span class="line-height-1">{{ trans('update.passed_grade') }}:
                                                {{ $quiz->pass_mark }}/{{ $quiz->quizQuestions->sum('grade') }}</span>
                                        </div>
                                    </div>
                                    <div class="">
                                        @if (!empty($user) and $quiz->can_download_certificate and $hasBought)
                                            <a href="/panel/quizzes/results/{{ $quiz->result->id }}/showCertificate"
                                                target="_blank"
                                                class="course-content-btns btn btn-sm btn-primary">{{ trans('home.download') }}</a>
                                        @else
                                            <button type="button"
                                                class="course-content-btns btn btn-sm btn-gray disabled {{ empty($user) ? 'not-login-toast' : (!$hasBought ? 'not-access-toast' : (!$quiz->can_download_certificate ? 'can-not-download-certificate-toast' : '')) }}">
                                                {{ trans('home.download') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
