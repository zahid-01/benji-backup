@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

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


    <section class="mt-8">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('update.your_students_assignments') }}</h2>
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
                                    <th class="text-center">{{ trans('update.min_grade') }}</th>
                                    <th class="text-center">{{ trans('quiz.average') }}</th>
                                    <th class="text-center">{{ trans('update.submissions') }}</th>
                                    <th class="text-center">{{ trans('public.pending') }}</th>
                                    <th class="text-center">{{ trans('quiz.passed') }}</th>
                                    <th class="text-center">{{ trans('quiz.failed') }}</th>
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
                                            <span class="font-medium">{{ $assignment->min_grade ?? '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ $assignment->average_grade ?? '-' }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ $assignment->submissions }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="font-medium">{{ $assignment->pendingCount }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span>{{ $assignment->passedCount }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <span>{{ $assignment->failedCount }}</span>
                                        </td>

                                        <td class="align-middle">
                                            @switch($assignment->status)
                                                @case('active')
                                                <span class="text-dark-blue font-medium">{{ trans('public.active') }}</span>
                                                @break
                                                @case('inactive')
                                                <span class="text-danger font-medium">{{ trans('public.inactive') }}</span>
                                                @break
                                            @endswitch
                                        </td>


                                        <td class="align-middle text-right">

                                            <div class="btn-group dropdown table-actions">
                                                <button type="button" class="btn-ghost dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i data-feather="more-vertical" height="20"></i>
                                                </button>

                                                <div class="dropdown-menu menu-lg">
                                                    <a href="/panel/assignments/{{ $assignment->id }}/students?status=pending" target="_blank"
                                                       class="webinar-actions block mt-10 font-weight-normal">{{ trans('update.pending_review') }}</a>

                                                    <a href="/panel/assignments/{{ $assignment->id }}/students" target="_blank"
                                                       class="webinar-actions block mt-10 font-weight-normal">{{ trans('update.all_assignments') }}</a>
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
                'hint' => nl2br(trans('update.my_assignments_no_result_hint')),
            ])
        @endif
    </section>
@endsection

@push('scripts_bottom')

@endpush
