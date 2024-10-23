<section class="p-15 m-15 border rounded-lg">
    <h3 class="font-20 font-bold text-black">{{ $courseForum->title }}</h3>

    <span class="block text-sm font-medium text-slate-500 mt-5">{{ trans('public.by') }} <span class="font-bold">{{ $courseForum->user->full_name }}</span> {{ trans('public.in') }} {{ dateTimeFormat($courseForum->created_at, 'j M Y | H:i') }}</span>

    <div class="mt-15 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item text-sm text-slate-500"><a href="{{ $course->getLearningPageUrl() }}">{{ $course->title }}</a></li>
                <li class="breadcrumb-item text-sm text-slate-500"><a href="{{ $course->getForumPageUrl() }}">{{ trans('update.forum') }}</a></li>
                <li class="breadcrumb-item text-sm text-slate-500 font-bold" aria-current="page">{{ $courseForum->title }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Load Question Card  --}}
@include('web.jiujitsu.course.learningPage.components.forum.forum_answer_card')

{{-- Load Answers Card  --}}
@if(!empty($courseForum) and count($courseForum->answers))
    @foreach($courseForum->answers as $courseForumAnswer)
        @include('web.jiujitsu.course.learningPage.components.forum.forum_answer_card',['answer' => $courseForumAnswer])
    @endforeach
@endif

{{-- Post Answer Card  --}}
<div class="mt-25">
    <h3 class="font-20 font-bold text-black px-15">{{ trans('update.write_a_reply') }}</h3>

    <form action="{{ $course->getForumPageUrl() }}/{{ $courseForum->id }}/answers" method="post">
        <div class="course-forum-answer-card py-15 m-15 rounded-lg">
            <div class="flex flex-wrap">
                <div class="col-12 col-md-3">
                    <div class="relative bg-info-light flex flex-col items-center justify-center rounded-lg w-full h-100 p-20">
                        <div class="user-avatar rounded-full">
                            <img src="{{ $user->getAvatar(72) }}" class="img-cover rounded-full" alt="{{ $user->full_name }}">
                        </div>
                        <h4 class="text-sm text-black mt-15 font-bold">{{ $user->full_name }}</h4>

                        <span class="px-10 py-5 mt-5 rounded-lg border bg-info-light text-center text-sm text-slate-500">
                        @if($user->isUser())
                                {{ trans('quiz.student') }}
                            @elseif($user->isTeacher())
                                {{ trans('panel.teacher') }}
                            @elseif($user->isOrganization())
                                {{ trans('home.organization') }}
                            @elseif($user->isAdmin())
                                {{ trans('panel.staff') }}
                            @endif
                    </span>
                    </div>
                </div>

                <div class="col-12 col-md-9 mt-15 mt-md-0">
                    <div class="form-group mb-0 h-100 w-full">
                        <textarea name="description" class="form-control h-100"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-right px-15">
                <button type="button" class="js-reply-course-question btn btn-primary btn-sm">{{ trans('update.post_reply') }}</button>
            </div>
        </div>
    </form>
</div>

{{-- Ask Modal For Edit Forum  --}}
@include('web.jiujitsu.course.learningPage.components.forum.ask_question_modal')

{{-- Edit Forum Answer Modal  --}}
@include('web.jiujitsu.course.learningPage.components.forum.edit_answer_modal')
