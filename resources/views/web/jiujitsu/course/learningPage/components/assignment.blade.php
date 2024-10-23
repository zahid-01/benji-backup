<section class="p-15 m-15 border rounded-lg">
    <div class="assignment-top-stats flex flex-wrap flex-md-nowrap items-center justify-content-around">
        <div class="assignment-top-stats__item flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/calendar.svg" class="assignment-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">
                    @if($assignmentDeadline)
                        {{ is_bool($assignmentDeadline) ? trans('update.unlimited') : trans('update.n_day', ['day' => ceil($assignmentDeadline)]) }}
                    @else
                        <span class="text-danger">{{ trans('panel.expired') }}</span>
                    @endif
                </strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.deadline') }}</span>
            </div>
        </div>

        <div class="assignment-top-stats__item flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/homework.svg" class="assignment-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">
                    @if(!empty($assignment->attempts))
                        {{ $submissionTimes }}/{{ $assignment->attempts  }}
                    @else
                        {{ trans('update.unlimited') }}
                    @endif
                </strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.submission_times') }}</span>
            </div>
        </div>

        <div class="assignment-top-stats__item flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/45.svg" class="assignment-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $assignmentHistory->grade ?? 0 }}/{{ $assignment->grade }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('quiz.your_grade') }}</span>
            </div>
        </div>

        <div class="assignment-top-stats__item flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/58.svg" class="assignment-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $assignment->pass_grade }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.min_grade') }}</span>
            </div>
        </div>

        <div class="assignment-top-stats__item flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/88.svg" class="assignment-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ trans('update.assignment_history_status_'.$assignmentHistory->status) }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('public.status') }}</span>
            </div>
        </div>
    </div>

    <div class="p-15 rounded-lg bg-info-light text-sm text-slate-500 mt-4">{!! $assignment->description !!}</div>
</section>

@if(!empty($assignment->attachments) and count($assignment->attachments))
    <section class="mt-25 container-fluid">
        <h2 class="section-title">{{ trans('public.attachments') }}</h2>

        <div class="row">
            @foreach($assignment->attachments as $attachment)
                <div class="col-6 col-lg-3 mt-10">
                    <a href="{{ $attachment->getDownloadUrl() }}" target="_blank" class="flex items-center p-10 border rounded-sm">
                        <span class="chapter-icon bg-gray300 mr-10">
                            <i data-feather="file" class="text-slate-500" width="16" height="16"></i>
                        </span>

                        <div class="">
                            <h4 class="text-sm text-slate-500 font-bold">{{ $attachment->title }}</h4>
                            <span class="text-sm text-slate-500">{{ $attachment->getFileSize() }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif

<section class="mt-25 container-fluid">
    <h2 class="section-title">{{ trans('update.assignment_history') }}</h2>

    <section class=" p-10 my-10 border rounded-lg">
        <div class="row">
            <div class="col-12 col-lg-4">
                @if(
                    $user->id != $assignment->creator_id and
                    (
                        $assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$passed or
                        $assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$notPassed or
                        !$assignmentDeadline or
                        (
                            !$checkHasAttempts and !empty($assignment->attempts) and $submissionTimes >= $assignment->attempts
                        )
                    )
                )
                    <div class="flex items-center justify-center flex-col bg-info-light p-10 rounded-sm border h-100">
                        <div class="learning-page-assignment-history-status-icon flex items-center justify-center">
                            @if($assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$passed)
                                <img src="/assets/default/img/learning/assignment_passed.svg" class="img-fluid" alt="">
                            @elseif($assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$notPassed)
                                <img src="/assets/default/img/learning/no_assignment.svg" class="img-fluid" alt="">
                            @else
                                <img src="/assets/default/img/learning/assignment_pending.svg" class="img-fluid" alt="">
                            @endif
                        </div>

                        <div class="flex items-center flex-col mt-10 text-center">
                            @if($assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$passed)
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.assignment_passed_title') }}</h3>
                                <p class="mt-5 text-slate-500 text-sm text-center">{{ trans('update.assignment_passed_desc') }}</p>
                            @elseif($assignmentHistory->status == \App\Models\WebinarAssignmentHistory::$notPassed)
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.assignment_not_passed_title') }}</h3>
                                <p class="mt-5 text-slate-500 text-sm text-center">{{ trans('update.assignment_not_passed_desc') }}</p>
                            @elseif(!$assignmentDeadline)
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.assignment_deadline_error_title') }}</h3>
                                <p class="mt-5 text-slate-500 text-sm text-center">{{ trans('update.assignment_deadline_error_desc') }}</p>
                            @else
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.assignment_submission_error_title') }}</h3>
                                <p class="mt-5 text-slate-500 text-sm text-center">{{ trans('update.assignment_submission_error_desc') }}</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-info-light p-10 rounded-sm border">
                        <h4 class="font-16 font-bold text-dark-blue">
                            @if($user->id == $assignment->creator_id)
                                {{ trans('update.reply_to_the_conversation') }}
                            @else
                                {{ trans('update.send_assignment') }}
                            @endif
                        </h4>

                        <form method="post" action="/course/assignment/{{ $assignment->id }}/history/{{ $assignmentHistory->id }}/message">
                            {{ csrf_field() }}
                            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                            <input type="hidden" name="assignment_history_id" value="{{ $assignmentHistory->id }}">
                            @if($user->id == $assignment->creator_id)
                                <input type="hidden" name="student_id" value="{{ $assignmentHistory->student_id }}">
                            @endif

                            <div class="form-group">
                                <label class="input-label">{{ trans('public.description') }}</label>
                                <textarea rows="6" name="description" class="form-control"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label class="input-label">{{ trans('update.file_title') }} ({{ trans('public.optional') }})</label>
                                <input name="file_title" class="form-control"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label class="input-label">{{ trans('update.attach_a_file') }} ({{ trans('public.optional') }})</label>

                                <div class="flex items-center">
                                    <div class="input-group mr-10">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text panel-file-manager" data-input="assignmentAttachmentInput" data-preview="holder">
                                                <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="file_path" id="assignmentAttachmentInput" value="" class="form-control" placeholder="{{ trans('update.assignment_attachments_placeholder') }}"/>
                                    </div>

                                    <button type="button" class="js-save-history-message btn btn-primary btn-sm">{{ trans('update.send') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($user->id == $assignment->creator_id)
                        <div class="bg-info-light p-10 rounded-sm border mt-15">
                            <h4 class="font-16 font-bold text-dark-blue">{{ trans('update.rate_the_assignment') }}</h4>

                            <form method="post" action="/course/assignment/{{ $assignment->id }}/history/{{ $assignmentHistory->id }}/setGrade">
                                <input type="hidden" name="student_id" value="{{ $assignmentHistory->student_id }}">

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.assignments_grade') }}</label>
                                    <div class="flex align-items-start">
                                        <div class="mr-10 w-full">
                                            <input name="grade" class="form-control" placeholder="{{ trans('update.pass_grade') }}: {{ $assignment->pass_grade }}"/>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <button type="button" class="js-save-history-rate btn btn-primary btn-sm">{{ trans('public.submit') }}</button>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-500">{{ trans('update.by_submitting_the_grade_you_the_assignment_will_be_closed') }}</p>
                            </form>
                        </div>
                    @endif
                @endif
            </div>

            <div class="col-12 col-lg-8 border-left">

                <div class="h-100">

                    @if(!empty($assignmentHistory->messages) and count($assignmentHistory->messages))
                        @foreach($assignmentHistory->messages as $message)
                            <div class="assignment-attachments-post p-15 border rounded-sm mb-15">
                                <div class="flex items-center">
                                    <div class="user-avatar rounded-full">
                                        <img src="{{ $message->sender->getAvatar(50) }}" class="img-cover rounded-full" alt="{{ $message->sender->full_name }}">
                                    </div>
                                    <div class="ml-10">
                                        <h4 class="text-sm font-medium text-dark-blue">{{ $message->sender->full_name }}</h4>
                                        <span class="block text-sm text-slate-500">{{ dateTimeFormat($message->created_at, 'j M Y | H:i') }}</span>
                                    </div>
                                </div>
                                <div class="mt-15 text-sm text-slate-500">
                                    {!! $message->message !!}
                                </div>

                                @if(!empty($message->file_path))
                                    <div class="flex flex-wrap items-center mt-10">
                                        <a href="{{ $message->getDownloadUrl($assignment->id) }}" target="_blank" class="flex items-center text-slate-500 bg-info-light border px-10 py-5 rounded-pill mr-10 mt-5">
                                            <i data-feather="paperclip" class="text-slate-500" width="16" height="16"></i>
                                            <span class="ml-2 text-sm text-slate-500">{{ !empty($message->file_title) ? $message->file_title : trans('update.attachment') }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center flex-col h-100">
                            <div class="learning-page-assignment-history-status-icon flex items-center justify-center">
                                <img src="/assets/default/img/learning/no_assignment.svg" class="img-fluid" alt="">
                            </div>

                            <div class="flex items-center flex-col mt-10 text-center">
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.no_assignment') }}</h3>
                                <p class="mt-5 text-slate-500 text-sm text-center">{{ trans('update.submit_your_assignment_and_evaluate_your_learning') }}</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</section>
