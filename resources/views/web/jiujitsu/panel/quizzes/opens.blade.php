@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('quiz.filter_results') }}</h2>

        <div class="panel-section-card py-20 px-4 mt-4">
            <form action="/panel/quizzes/opens" method="get" class="row">
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
                                    <input type="text" name="from" autocomplete="off" class="form-control @if(!empty(request()->get('from'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('from','') }}"/>
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
                                    <input type="text" name="to" autocomplete="off" class="form-control @if(!empty(request()->get('to'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('to','') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('quiz.quiz_or_webinar') }}</label>
                                <input type="text" name="quiz_or_webinar" class="form-control" value="{{ request()->get('quiz_or_webinar','') }}"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.instructor') }}</label>
                                <input type="text" name="instructor" class="form-control" value="{{ request()->get('instructor','') }}"/>
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
            <h2 class="section-title">{{ trans('quiz.open_quizzes') }}</h2>
        </div>

        @if($quizzes->count() > 0)
            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                <tr>
                                    <th>{{ trans('public.instructor') }}</th>
                                    <th>{{ trans('quiz.quiz') }}</th>
                                    <th class="text-center">{{ trans('quiz.quiz_grade') }}</th>
                                    <th class="text-center">{{ trans('public.date') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($quizzes as $quiz)
                                    <tr>
                                        <td class="text-left">
                                            <div class="user-inline-avatar flex items-center">
                                                <div class="avatar bg-gray200">
                                                    <img src="{{ $quiz->creator->getAvatar() }}" class="img-cover" alt="">
                                                </div>
                                                <div class=" ml-2">
                                                    <span class="block text-dark-blue font-medium">{{ $quiz->creator->full_name }}</span>
                                                    <span class="mt-5 text-sm text-slate-500 block">{{ $quiz->creator->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <span class="block text-dark-blue font-medium">{{ $quiz->title }}</span>
                                            <span class="text-sm mt-5 text-slate-500 block">{{ $quiz->webinar->title }}</span>
                                        </td>
                                        <td class="text-dark-blue font-medium align-middle">{{ $quiz->quizQuestions->sum('grade') }}</td>


                                        <td class="text-dark-blue font-medium align-middle">{{ dateTimeFormat($quiz->created_at,'j M Y H:i')}}</td>

                                        <td class="align-middle text-right font-weight-normal">
                                            <div class="btn-group dropdown table-actions table-actions-lg table-actions-lg">
                                                <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="more-vertical" height="20"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="/panel/quizzes/{{ $quiz->id }}/start" class="webinar-actions block mt-10">{{ trans('public.start') }}</a>
                                                    <a href="{{ $quiz->webinar->getUrl() }}" target="_blank" class="webinar-actions block mt-10">{{ trans('webinars.webinar_page') }}</a>
                                                </div>
                                            </div>
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
                'file_name' => 'result.png',
                'title' => trans('quiz.quiz_result_no_result'),
                'hint' => trans('quiz.quiz_result_no_result_hint'),
            ])
        @endif
    </section>

    <div class="my-30">
        {{ $quizzes->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

@endpush
