@php
    $cardUser = !empty($answer) ? $answer->user : $courseForum->user;
@endphp

<div class="course-forum-answer-card py-15 m-15 rounded-lg {{ (!empty($answer) and $answer->resolved) ? 'resolved' : '' }}">
    <div class="flex flex-wrap">
        <div class="col-12 col-md-3">
            <div class="relative bg-info-light flex flex-col items-center justify-center rounded-lg w-full h-100 p-20">
                <div class="user-avatar rounded-full {{ (!empty($answer) and $cardUser->isTeacher()) ? 'is-instructor' : '' }}">
                    <img src="{{ $cardUser->getAvatar(72) }}" class="img-cover rounded-full" alt="{{ $cardUser->full_name }}">
                </div>
                <h4 class="text-sm text-black mt-15 font-bold">{{ $cardUser->full_name }}</h4>

                <span class="px-10 py-5 mt-5 rounded-lg border bg-info-light text-center text-sm text-slate-500">
                    @if($cardUser->isUser())
                        {{ trans('quiz.student') }}
                    @elseif($cardUser->isTeacher())
                        {{ trans('public.instructor') }}
                    @elseif($cardUser->isOrganization())
                        {{ trans('home.organization') }}
                    @elseif($cardUser->isAdmin())
                        {{ trans('panel.staff') }}
                    @endif
                </span>

                @if(!empty($answer) and $answer->pin)
                    <span class="pinned-icon flex items-center justify-center">
                        <img src="/assets/default/img/learning/un_pin.svg" alt="pin icon" class="">
                    </span>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-9 mt-15 mt-md-0">
            <div class="flex flex-col justify-between h-100">
                <div class="">
                    <p class="text-sm text-slate-500 block white-space-pre-wrap">{{ !empty($answer) ? $answer->description : $courseForum->description }}</p>

                    @if(empty($answer) and !empty($courseForum->attach))
                        <div class="mt-25 d-inline-block">
                            <a href="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/downloadAttach" target="_blank" class="flex items-center text-slate-500 bg-info-light border px-10 py-5 rounded-pill">
                                <i data-feather="paperclip" class="text-slate-500" width="16" height="16"></i>
                                <span class="ml-2 text-sm text-slate-500">{{ trans('update.attachment') }}</span>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-between mt-15 pt-15 border-top">
                    <span class="text-sm font-medium text-slate-500">{{ dateTimeFormat(!empty($answer) ? $answer->created_at : $courseForum->created_at,'j M Y | H:i') }}</span>

                    <div class="flex items-center">
                        @if(empty($answer) and $user->id == $courseForum->user_id)
                            <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/edit" class="js-edit-forum btn-ghost text-sm font-medium text-slate-500">{{ trans('public.edit') }}</button>
                        @elseif(!empty($answer))
                            @if($course->isOwner($user->id))
                                @if($answer->pin)
                                    <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers/{{ $answer->id }}/un_pin" class="js-btn-answer-un_pin btn-ghost text-sm font-medium text-warning">{{ trans('update.un_pin') }}</button>
                                @else
                                    <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers/{{ $answer->id }}/pin" class="js-btn-answer-pin btn-ghost text-sm font-medium text-slate-500">{{ trans('update.pin') }}</button>
                                @endif
                            @endif

                            @if($course->isOwner($user->id) or $user->id == $courseForum->user_id)
                                @if($answer->resolved)
                                    <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers/{{ $answer->id }}/mark_as_not_resolved" class="js-btn-answer-mark_as_not_resolved btn-ghost text-sm font-medium text-slate-500 ml-20">{{ trans('update.mark_as_not_resolved') }}</button>
                                @else
                                    <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers/{{ $answer->id }}/mark_as_resolved" class="js-btn-answer-mark_as_resolved btn-ghost text-sm font-medium text-slate-500 ml-20">{{ trans('update.mark_as_resolved') }}</button>
                                @endif
                            @endif

                            @if($user->id == $answer->user_id)
                                <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers/{{ $answer->id }}/edit" class="js-edit-forum-answer btn-ghost text-sm font-medium text-slate-500 ml-20">{{ trans('public.edit') }}</button>
                            @endif

                            @if($answer->resolved)
                                <div class="resolved-answer-badge flex items-center ml-25 text-primary text-sm">
                                    <span class="badge-icon flex items-center justify-center">
                                        <i data-feather="check" width="20" height="20"></i>
                                    </span>
                                    {{ trans('update.resolved') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
