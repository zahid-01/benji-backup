@extends(getTemplate().'.layouts.app')

@section('content')
    <div class="container">
        <section class="mt-14">
            <h2 class="font-bold font-16 text-dark-blue">{{ $quiz->title }}</h2>
            <p class="text-slate-500 text-sm mt-5">
                <a href="{{ $quiz->webinar->getUrl() }}" target="_blank" class="text-slate-500">{{ $quiz->webinar->title }}</a>
                | {{ trans('public.by') }}
                <span class="font-bold">
                    <a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class=""> {{ $quiz->creator->full_name }}</a>
                </span>
            </p>

            <div class="activities-container shadow-lg rounded-lg mt-25 p-20 p-lg-35">
                <div class="row">
                    <div class="col-6 col-md-3 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{ $quiz->pass_mark }}/{{ $questionsSumGrade }}</strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('public.min') }} {{ trans('quiz.grade') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{ $numberOfAttempt }}/{{ $quiz->attempt }}</strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.attempts') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/45.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{ $quizResult->user_grade }}/{{  $questionsSumGrade }}</strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.your_grade') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/44.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-{{ ($quizResult->status == 'passed') ? 'primary' : ($quizResult->status == 'waiting' ? 'warning' : 'danger') }} mt-5">
                                {{ trans('quiz.'.$quizResult->status) }}
                            </strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('public.status') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="mt-6 quiz-form">
            <form action="{{ !empty($newQuizStart) ? '/panel/quizzes/'. $newQuizStart->quiz->id .'/update-result' : '' }} " method="post">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_result_id" value="{{ !empty($newQuizStart) ? $newQuizStart->id : ''}}" class="form-control" placeholder=""/>
                <input type="hidden" name="attempt_number" value="{{  $numberOfAttempt }}" class="form-control" placeholder=""/>
                <input type="hidden" class="js-quiz-question-count" value="{{ $quizQuestions->count() }}"/>

                @foreach($quizQuestions as $key => $question)

                    <fieldset class="question-step question-step-{{ $key + 1 }}">
                        <div class="rounded-lg shadow-lg py-25 px-20">
                            <div class="quiz-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold font-16 text-black">{{ $question->title }}?</h3>
                                        <p class="text-slate-500 text-sm mt-5">
                                            <span>{{ trans('quiz.question_grade') }} : {{ $question->grade }}</span> | <span>{{ trans('quiz.your_grade') }} : {{ (!empty($userAnswers[$question->id]) and !empty($userAnswers[$question->id]["grade"])) ? $userAnswers[$question->id]["grade"] : 0 }}</span>
                                        </p>
                                    </div>

                                    <div class="rounded-sm border border-gray200 p-15 text-slate-500">{{ $key + 1 }}/{{ $quizQuestions->count() }}</div>
                                </div>
                                @if($question->type === \App\Models\QuizzesQuestion::$descriptive)

                                    <div class="form-group mt-8">
                                        <label class="input-label text-black">{{ trans('quiz.student_answer') }}</label>
                                        <textarea name="question[{{ $question->id }}][answer]" rows="10" disabled class="form-control">{{ (!empty($userAnswers[$question->id]) and !empty($userAnswers[$question->id]["answer"])) ? $userAnswers[$question->id]["answer"] : '' }}</textarea>
                                    </div>

                                    <div class="form-group mt-8">
                                        <label class="input-label text-black">{{ trans('quiz.correct_answer') }}</label>
                                        <textarea rows="10" name="question[{{ $question->id }}][correct_answer]" @if(empty($newQuizStart) or $newQuizStart->quiz->creator_id != $authUser->id) disabled @endif class="form-control">{{ $question->correct }}</textarea>
                                    </div>

                                    @if(!empty($newQuizStart) and $newQuizStart->quiz->creator_id == $authUser->id)
                                        <div class="form-group mt-8">
                                            <label class="font-16 text-black">{{ trans('quiz.grade') }}</label>
                                            <input type="text" name="question[{{ $question->id }}][grade]" value="{{ (!empty($userAnswers[$question->id]) and !empty($userAnswers[$question->id]["grade"])) ? $userAnswers[$question->id]["grade"] : 0 }}" class="form-control">
                                        </div>
                                    @endif

                                @else
                                    <div class="question-multi-answers mt-8">
                                        @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                                            <div class="answer-item">
                                                @if($answer->correct)
                                                    <span class="badge badge-primary correct">{{ trans('quiz.correct') }}</span>
                                                @endif

                                                <input id="asw-{{ $answer->id }}" type="radio" disabled name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}" {{ (!empty($userAnswers[$question->id]) and (int)$userAnswers[$question->id]["answer"] === $answer->id) ? 'checked' : '' }}>

                                                @if(!$answer->image)
                                                    <label for="asw-{{ $answer->id }}" class="answer-label font-16 flex text-dark-blue items-center justify-center ">
                                                        <span class="answer-title">
                                                            {{ $answer->title }}
                                                            @if(!empty($userAnswers[$question->id]) and (int)$userAnswers[$question->id]["answer"] ===  $answer->id)
                                                                <span class="block">({{ trans('quiz.student_answer') }})</span>
                                                            @endif
                                                        </span>
                                                    </label>
                                                @else
                                                    <label for="asw-{{ $answer->id }}" class="answer-label font-16 flex items-center text-dark-blue justify-center ">
                                                        <div class="image-container">
                                                            @if(!empty($userAnswers[$question->id]) and (int)$userAnswers[$question->id]["answer"] ===  $answer->id)
                                                                <span class="selected text-sm">{{ trans('quiz.student_answer') }}</span>
                                                            @endif
                                                            <img src="{{ config('app_url') . $answer->image }}" class="img-cover" alt="">
                                                        </div>
                                                    </label>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </fieldset>

                @endforeach

                <div class="flex items-center mt-6">
                    <button type="button" disabled class="previous btn btn-sm btn-primary mr-20">{{ trans('quiz.previous_question') }}</button>
                    <button type="button" class="next btn btn-primary btn-sm mr-auto">{{ trans('quiz.next_question') }}</button>

                    @if(!empty($newQuizStart))
                        <button type="submit" class="finish btn btn-sm bg-red-600 text-white">{{ trans('public.finish') }}</button>
                    @endif
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/quiz-start.min.js"></script>
@endpush
