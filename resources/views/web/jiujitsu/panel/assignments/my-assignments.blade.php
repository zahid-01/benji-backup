@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('update.assignment_statistics') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/homework.svg" width="64" height="64" alt="">
                        <strong class="text-3xl font-bold mt-5">{{ $courseAssignmentsCount }}</strong>
                        <span class="font-16 text-dark-blue text-slate-500 font-medium">{{ trans('update.course_assignments') }}</span>
                    </div>
                </div>

                <div class="col-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                        <strong class="text-3xl font-bold mt-5">{{ $pendingReviewCount }}</strong>
                        <span class="font-16 text-dark-blue text-slate-500 font-medium">{{ trans('update.pending_review') }}</span>
                    </div>
                </div>

                <div class="col-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/45.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $passedCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.passed') }}</span>
                    </div>
                </div>

                <div class="col-3 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/pin.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $failedCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('quiz.failed') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-25">
        <h2 class="section-title">{{ trans('update.filter_assignments') }}</h2>

        <div class="panel-section-card py-20 px-4 mt-4">
            <form action="/panel/assignments/my-assignments" method="get" class="row">
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
                                    <input type="text" name="from" autocomplete="off" class="form-control @if(!empty(request()->get('from'))) datepicker @else datefilter @endif"
                                           aria-describedby="dateInputGroupPrepend" value="{{ request()->get('from','') }}"/>
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
                                    <input type="text" name="to" autocomplete="off" class="form-control @if(!empty(request()->get('to'))) datepicker @else datefilter @endif"
                                           aria-describedby="dateInputGroupPrepend" value="{{ request()->get('to','') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                                <label class="input-label">{{ trans('product.course') }}</label>
                                <select name="webinar_id" class="form-control select2">
                                    <option value="">{{ trans('webinars.all_courses') }}</option>

                                    @foreach($webinars as $webinar)
                                        <option value="{{ $webinar->id }}" @if(request()->get('webinar_id') == $webinar->id) selected @endif>{{ $webinar->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.status') }}</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">{{ trans('public.all') }}</option>
                                    @foreach(\App\Models\WebinarAssignmentHistory::$assignmentHistoryStatus as $status)
                                        <option value="{{ $status }}" {{ (request()->get('status') == $status) ? 'selected' : '' }}>{{ trans('update.assignment_history_status_'.$status) }}</option>
                                    @endforeach
                                </select>
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
            <h2 class="section-title">{{ trans('update.my_assignments') }}</h2>
        </div>

        @if($assignments->count() > 0)

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th>{{ trans('update.title_and_course') }}</th>
                                    <th class="text-center">{{ trans('update.deadline') }}</th>
                                    <th class="text-center">{{ trans('update.first_submission') }}</th>
                                    <th class="text-center">{{ trans('update.last_submission') }}</th>
                                    <th class="text-center">{{ trans('update.attempts') }}</th>
                                    <th class="text-center">{{ trans('quiz.grade') }}</th>
                                    <th class="text-center">{{ trans('update.pass_grade') }}</th>
                                    <th class="text-center">{{ trans('public.status') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($assignments as $assignment)
                                    <tr>
                                        <td class="text-left">
                                            <span class="block font-16 font-medium text-dark-blue">{{ $assignment->title }}</span>
                                            <span class="block text-sm font-medium text-slate-500">{{ $assignment->webinar->title }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="font-medium">{{ !empty($assignment->deadline) ? dateTimeFormat($assignment->deadlineTime, 'j M Y') : '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ !empty($assignment->first_submission) ? dateTimeFormat($assignment->first_submission, 'j M Y | H:i') : '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ !empty($assignment->last_submission) ? dateTimeFormat($assignment->last_submission, 'j M Y | H:i') : '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ !empty($assignment->attempts) ? "{$assignment->usedAttemptsCount}/{$assignment->attempts}" : '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span>{{ (!empty($assignment->assignmentHistory) and !empty($assignment->assignmentHistory->grade)) ? $assignment->assignmentHistory->grade : '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span>{{ $assignment->pass_grade }}</span>
                                        </td>

                                        <td class="align-middle">
                                            @if(empty($assignment->assignmentHistory) or ($assignment->assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$notSubmitted))
                                                <span class="text-danger font-medium">{{ trans('update.assignment_history_status_not_submitted') }}</span>
                                            @else
                                                @switch($assignment->assignmentHistory->status)
                                                    @case(\App\Models\WebinarAssignmentHistory::$passed)
                                                    <span class="text-primary font-medium">{{ trans('quiz.passed') }}</span>
                                                    @break
                                                    @case(\App\Models\WebinarAssignmentHistory::$pending)
                                                    <span class="text-warning font-medium">{{ trans('public.pending') }}</span>
                                                    @break
                                                    @case(\App\Models\WebinarAssignmentHistory::$notPassed)
                                                    <span class="font-medium text-danger">{{ trans('quiz.failed') }}</span>
                                                    @break
                                                @endswitch
                                            @endif
                                        </td>


                                        <td class="align-middle text-right">

                                            <div class="btn-group dropdown table-actions">
                                                <button type="button" class="btn-ghost dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i data-feather="more-vertical" height="20"></i>
                                                </button>

                                                <div class="dropdown-menu menu-lg">
                                                    @if($assignment->webinar->checkUserHasBought())
                                                        <a href="{{ "{$assignment->webinar->getLearningPageUrl()}?type=assignment&item={$assignment->id}" }}" target="_blank"
                                                           class="webinar-actions block mt-10 font-weight-normal">{{ trans('update.view_assignment') }}</a>
                                                    @else
                                                        <a href="#!" class="not-access-toast webinar-actions block mt-10 font-weight-normal">{{ trans('update.view_assignment') }}</a>
                                                    @endif
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

            <div class="my-30">
                {{ $assignments->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        @else
            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'meeting.png',
                'title' => trans('update.my_assignments_no_result'),
                'hint' => nl2br(trans('update.my_assignments_no_result_hint_student')),
            ])
        @endif
    </section>

@endsection

@push('scripts_bottom')
    <script>
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
    </script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/js/panel/my_assignments.min.js"></script>
@endpush
