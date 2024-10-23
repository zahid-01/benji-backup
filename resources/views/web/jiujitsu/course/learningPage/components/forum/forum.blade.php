<section class="p-15 m-15 border rounded-lg">
    <div class="course-forum-top-stats flex flex-wrap flex-md-nowrap items-center justify-content-around">
        <div class="flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/47.svg" class="course-forum-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $questionsCount }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('public.questions') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/120.svg" class="course-forum-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $resolvedCount }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.resolved') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/119.svg" class="course-forum-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $openQuestionsCount }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.open_questions') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/39.svg" class="course-forum-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $commentsCount }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.answers') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-center pb-5 pb-md-0">
            <div class="flex flex-col items-center text-center">
                <img src="/assets/default/img/activity/49.svg" class="course-forum-top-stats__icon" alt="">
                <strong class="font-20 text-dark-blue font-bold mt-5">{{ $activeUsersCount }}</strong>
                <span class="text-sm text-slate-500 font-medium">{{ trans('update.active_users') }}</span>
            </div>
        </div>
    </div>

    <div class="container-fluid p-15 rounded-lg bg-info-light text-sm text-slate-500 mt-4">
        <div class="row items-center">
            <div class="col-12 col-lg-4">
                <div class="">
                    <h3 class="font-16 font-bold text-dark-blue">{{ trans('update.course_forum') }}</h3>
                    <span class="block text-sm font-medium text-slate-500 mt-1">{{ trans('update.communicate_others_and_ask_your_questions') }}</span>
                </div>
            </div>
            <div class="col-12 col-lg-5 mt-15 mt-lg-0">
                <form action="{{ request()->url() }}" method="get">
                    <div class="flex items-center">
                        <input type="text" name="search" class="form-control grow" value="{{ request()->get('search') }}" placeholder="{{ trans('update.search_in_this_forum') }}">
                        <button type="submit" class="btn btn-primary btn-sm ml-10 course-forum-search-btn">
                            <i data-feather="search" class="text-white" width="16" height="16"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-lg-3 mt-15 mt-lg-0 text-right">
                <button type="button" id="askNewQuestion" class="btn btn-primary btn-sm course-forum-search-btn">
                    <i data-feather="file" class="text-white" width="16" height="16"></i>
                    <span class="ml-1">{{ trans('update.ask_new_question') }}</span>
                </button>
            </div>
        </div>
    </div>
</section>

@if($forums and count($forums))
    @foreach($forums as $forum)
        <div class="course-forum-question-card p-15 m-15 border rounded-lg">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="flex align-items-start">
                        <div class="question-user-avatar">
                            <img src="{{ $forum->user->getAvatar(64) }}" class="img-cover rounded-full" alt="{{ $forum->user->full_name }}">
                        </div>
                        <div class="ml-10">
                            <a href="{{ $course->getForumPageUrl() }}/{{ $forum->id }}/answers" class="">
                                <h4 class="font-16 font-bold text-dark-blue">{{ $forum->title }}</h4>
                            </a>

                            <span class="block text-sm text-slate-500 mt-5">{{ trans('public.by') }} {{ $forum->user->full_name }} {{ trans('public.in') }} {{ dateTimeFormat($forum->created_at, 'j M Y | H:i') }}</span>

                            <p class="block text-sm text-slate-500 mt-10 white-space-pre-wrap">{{ $forum->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-15 mt-lg-0 border-left">
                    @if($course->isOwner($user->id))
                        <button type="button" data-action="{{ $course->getForumPageUrl() }}/{{ $forum->id }}/pinToggle" class="question-forum-pin-btn flex items-center justify-center">
                            <img src="/assets/default/img/learning/{{ $forum->pin ? 'un_pin' : 'pin' }}.svg" alt="pin icon" class="">
                        </button>
                    @endif


                    @if(!empty($forum->answers) and count($forum->answers))
                        <div class="py-15 row">
                            <div class="col-3">
                                <span class="block text-sm text-slate-500">{{ trans('public.answers') }}</span>
                                <span class="block text-sm text-dark mt-10">{{ $forum->answer_count }}</span>
                            </div>

                            <div class="col-3">
                                <span class="block text-sm text-slate-500">{{ trans('panel.users') }}</span>
                                <div class="answers-user-icons flex items-center">
                                    @if(!empty($forum->usersAvatars))
                                        @foreach($forum->usersAvatars as $userAvatar)
                                            <div class="user-avatar-card rounded-full">
                                                <img src="{{ $userAvatar->getAvatar(32) }}" class="img-cover rounded-full" alt="{{ $userAvatar->full_name }}">
                                            </div>
                                        @endforeach
                                    @endif

                                    @if(($forum->answers->groupBy('user_id')->count() - count($forum->usersAvatars)) > 0)
                                        <span class="answer-count flex items-center justify-center text-sm text-slate-500 rounded-full">+{{ $forum->answer_count - count($forum->usersAvatars) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6 relative">
                                <span class="block text-sm text-slate-500">{{ trans('update.last_activity') }}</span>
                                <span class="block text-sm text-dark mt-10">{{ dateTimeFormat($forum->lastAnswer->created_at,'j M Y | H:i') }}</span>
                            </div>
                        </div>

                        <div class="py-15 border-top relative">
                            <span class="block text-sm text-slate-500">{{ trans('update.last_answer') }}</span>

                            <div class="flex align-items-start mt-4">
                                <div class="last-answer-user-avatar">
                                    <img src="{{ $forum->lastAnswer->user->getAvatar(30) }}" class="img-cover rounded-full" alt="{{ $forum->lastAnswer->user->full_name }}">
                                </div>
                                <div class="ml-10">
                                    <h4 class="text-sm text-dark font-bold">{{ $forum->lastAnswer->user->full_name }}</h4>
                                    <p class="text-sm font-medium text-slate-500 mt-5">{!! truncate($forum->lastAnswer->description, 160) !!}</p>
                                </div>
                            </div>

                            @if(!empty($forum->resolved))
                                <div class="resolved-answer-badge flex items-center text-sm text-primary">
                            <span class="badge-icon flex items-center justify-center">
                                <i data-feather="check" width="20" height="20"></i>
                            </span>
                                    {{ trans('update.resolved') }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex flex-col justify-center text-center py-15 h-100">
                            <p class="text-slate-500 text-sm font-bold">{{ trans('update.be_the_first_to_answer_this_question') }}</p>

                            <div class="">
                                <a href="{{ $course->getForumPageUrl() }}/{{ $forum->id }}/answers" class="btn btn-primary btn-sm mt-15">{{ trans('public.answer') }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="learning-page-forum-empty flex items-center justify-center flex-col">
        <div class="learning-page-forum-empty-icon flex items-center justify-center">
            <img src="/assets/default/img/learning/forum-empty.svg" class="img-fluid" alt="">
        </div>

        <div class="flex items-center flex-col mt-10 text-center">
            <h3 class="font-20 font-bold text-dark-blue text-center"></h3>
            <p class="text-sm font-medium text-slate-500 mt-5 text-center">{{ trans('update.learning_page_empty_content_title_hint') }}</p>
        </div>
    </div>
@endif

@include('web.jiujitsu.course.learningPage.components.forum.ask_question_modal')
