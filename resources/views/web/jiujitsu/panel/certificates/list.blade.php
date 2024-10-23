@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('quiz.certificates_statistics') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-6 col-lg-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/56.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $activeQuizzes }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.active_certificates') }}</span>
                    </div>
                </div>

                <div class="col-6 col-lg-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/57.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $achievementsCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.student_achievements') }}</span>
                    </div>
                </div>

                <div class="col-6 col-lg-3 flex items-center justify-center mt-5 mt-lg-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/60.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $failedResults }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.failed_students') }}</span>
                    </div>
                </div>

                <div class="col-6 col-lg-3 flex items-center justify-center mt-5 mt-lg-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/hours.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $avgGrade }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.average_grade') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-25">
        <h2 class="section-title">{{ trans('quiz.filter_certificates') }}</h2>

        <div class="panel-section-card py-20 px-4 mt-4">
            <form action="" method="get" class="row">
                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.from') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="dateInputGroupPrepend">
                                            <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="from" autocomplete="off" class="form-control @if(!empty(request()->get('from'))) datepicker @else datefilter @endif" value="{{ request()->get('from','') }}" aria-describedby="dateInputGroupPrepend"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.to') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="dateInputGroupPrepend">
                                            <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="to" autocomplete="off" class="form-control @if(!empty(request()->get('to'))) datepicker @else datefilter @endif" value="{{ request()->get('to','') }}" aria-describedby="dateInputGroupPrepend"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="input-label">{{ trans('product.course') }}</label>
                                <select name="webinar_id" class="form-control">
                                    <option value="all">{{ trans('webinars.all_courses') }}</option>

                                    @foreach($userWebinars as $userWebinar)
                                        <option value="{{ $userWebinar->id }}" @if(request()->get('webinar_id','') == $userWebinar->id) selected @endif>{{ $userWebinar->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('quiz.quiz') }}</label>
                                        <select id="quizFilter" name="quiz_id" class="form-control" @if(empty(request()->get('quiz_id'))) disabled @endif>
                                            <option value="all">{{ trans('quiz.all_quizzes') }}</option>

                                            @foreach($userAllQuizzes as $userQuiz)
                                                <option value="{{ $userQuiz->id }}" data-webinar-id="{{ $userQuiz->webinar_id }}" @if(request()->get('quiz_id','') == $userQuiz->id) selected @else class="hidden" @endif>{{ $userQuiz->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('quiz.grade') }}</label>
                                        <input type="text" name="grade" value="{{ request()->get('grade','') }}" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2 flex items-center justify-end">
                    <button type="submit" class="btn btn-sm btn-primary w-full mt-2">{{ trans('public.show_results') }}</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mt-8">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('quiz.active_certificates') }}</h2>
        </div>

        @if(!empty($quizzes) and count($quizzes))
            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th>{{ trans('quiz.quiz') }}</th>
                                    <th class="text-center">{{ trans('quiz.grade') }}</th>
                                    <th class="text-center">{{ trans('quiz.average') }}</th>
                                    <th class="text-center">{{ trans('quiz.generated_certificates') }}</th>
                                    <th class="text-center">{{ trans('public.date') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($quizzes as $quiz)
                                    <tr>
                                        <td class="text-left">
                                            <span class="block text-dark-blue font-medium">{{ $quiz->title }}</span>
                                            <span class="block mt-5 text-sm text-slate-500">{{ !empty($quiz->webinar) ? $quiz->webinar->title : trans('update.delete_item') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-dark-blue font-medium">{{ $quiz->pass_mark }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-dark-blue font-medium">{{ round($quiz->avg_grade, 2) }}</span>
                                        </td>
                                        <td class="text-dark-blue font-medium align-middle">{{ count($quiz->certificates) }}</td>
                                        <td class="align-middle">
                                            <span class="text-dark-blue font-medium">{{ dateTimeFormat($quiz->created_at, 'j M Y') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'certificate.png',
                'title' => trans('quiz.certificates_no_result'),
                'hint' => nl2br(trans('quiz.certificates_no_result_hint')),
            ])
        @endif
    </section>

    <div class="my-30">
        {{ $quizzes->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

    <script src="/assets/default/js/panel/certificates.min.js"></script>
@endpush

