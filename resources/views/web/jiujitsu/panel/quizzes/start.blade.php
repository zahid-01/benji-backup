@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')
    <div class="container">
        <section class="mt-14">
            <h2 class="font-bold font-16 text-dark-blue">{{ $quiz->title }}</h2>
            <p class="text-slate-500 text-sm mt-5">
                <a href="{{ $quiz->webinar->getUrl() }}" target="_blank" class="text-slate-500">{{ $quiz->webinar->title }}</a>
                | {{ trans('public.by') }}
                <span class="font-bold">
                    <a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class="text-sm"> {{ $quiz->creator->full_name }}</a>
                </span>
            </p>

            <div class="activities-container shadow-lg rounded-lg mt-25 p-20 p-lg-35">
                <div class="row">
                    <div class="col-6 col-md-3 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{  $quiz->pass_mark }}/{{  $quizQuestions->sum('grade') }}</strong>
                            <span class="font-16 text-slate-500">{{ trans('public.min') }} {{ trans('quiz.grade') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{ $attempt_count }}/{{ $quiz->attempt }}</strong>
                            <span class="font-16 text-slate-500">{{ trans('quiz.attempts') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/47.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold text-black mt-5">{{ $totalQuestionsCount }}</strong>
                            <span class="font-16 text-slate-500">{{ trans('public.questions') }}</span>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/clock.svg" width="64" height="64" alt="">
                            @if(!empty($quiz->time))
                                <strong class="text-3xl font-bold text-black mt-5">
                                    <div class="flex items-center timer ltr" data-minutes-left="{{ $quiz->time }}"></div>
                                </strong>
                            @else
                                <strong class="text-3xl font-bold text-black mt-5">{{ trans('quiz.unlimited') }}</strong>
                            @endif
                            <span class="font-16 text-slate-500">{{ trans('quiz.remaining_time') }}</span>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <section class="mt-6 quiz-form">
            <form action="/panel/quizzes/{{ $quiz->id }}/store-result" method="post" class="">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" class="form-control" placeholder=""/>
                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" class="form-control" placeholder=""/>

                @foreach($quizQuestions as $key => $question)

                    <fieldset class="question-step question-step-{{ $key + 1 }}">
                        <div class="rounded-lg shadow-lg py-25 px-20">
                            <div class="quiz-card">

                                <div class="flex items-center justify-between">
                                    <p class="text-slate-500 text-sm">
                                        <span>{{ trans('quiz.question_grade') }} : {{ $question->grade }} </span>
                                    </p>

                                    <div class="rounded-sm border border-gray200 p-15 text-slate-500">{{ $key + 1 }}/{{ $totalQuestionsCount }}</div>
                                </div>

                                @if(!empty($question->image) or !empty($question->video))
                                    <div class="quiz-question-media-card rounded-lg mt-10 mb-15">
                                        @if(!empty($question->image))
                                            <img src="{{ $question->image }}" class="img-cover rounded-lg" alt="">
                                        @else
                                            <video id="questionVideo{{ $question->id }}" oncontextmenu="return false;" controlsList="nodownload" class="video-js" controls preload="auto" width="100%" data-setup='{"fluid": true}'>
                                                <source src="{{ $question->video }}" type="video/mp4"/>
                                            </video>
                                        @endif
                                    </div>
                                @endif

                                <div class="">
                                    <h3 class="font-bold font-16 text-black">{{ $question->title }}</h3>
                                </div>

                                @if($question->type === \App\Models\QuizzesQuestion::$descriptive)
                                    <div class="form-group mt-8">
                                        <textarea name="question[{{ $question->id }}][answer]" rows="15" class="form-control"></textarea>
                                    </div>
                                @else
                                    <div class="question-multi-answers mt-8">
                                        @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                                            <div class="answer-item">
                                                <input id="asw-{{ $answer->id }}" type="radio" name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}">
                                                @if(!$answer->image)
                                                    <label for="asw-{{ $answer->id }}" class="answer-label font-16 text-dark-blue flex items-center justify-center">
                                                            <span class="answer-title">
                                                                {{ $answer->title }}
                                                            </span>
                                                    </label>
                                                @else
                                                    <label for="asw-{{ $answer->id }}" class="answer-label font-16 text-dark-blue flex items-center justify-center">
                                                        <div class="image-container">
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
                    <button type="button" class="previous btn btn-sm btn-primary mr-20">{{ trans('quiz.previous_question') }}</button>
                    <button type="button" class="next btn btn-sm btn-primary mr-auto">{{ trans('quiz.next_question') }}</button>
                    <button type="submit" class="finish btn btn-sm bg-red-600 text-white">{{ trans('public.finish') }}</button>
                </div>
            </form>
        </section>

    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
    <script src="/assets/default/js/parts/quiz-start.min.js"></script>
@endpush
