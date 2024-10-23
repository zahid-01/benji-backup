@php
    $showLoading = true;

    if(
        (!empty($noticeboards) and $noticeboards) or
        !empty($assignment) or
        (!empty($isForumPage) and $isForumPage) or
        (!empty($isForumAnswersPage) and $isForumAnswersPage)
    ) {
        $showLoading = false;
    }
@endphp

<div class="learning-content" id="learningPageContent">

    @if(!empty($isForumAnswersPage) and $isForumAnswersPage)
        @include('web.jiujitsu.course.learningPage.components.forum.forum_answers')
    @elseif(!empty($isForumPage) and $isForumPage)
        @include('web.jiujitsu.course.learningPage.components.forum.forum')
    @elseif(!empty($noticeboards) and $noticeboards)
        @include('web.jiujitsu.course.learningPage.components.noticeboards')
    @elseif(!empty($assignment))
        @include('web.jiujitsu.course.learningPage.components.assignment')
    @endif

    <div class="learning-content-loading items-center justify-center flex-col w-full h-100 {{ $showLoading ? 'flex' : 'hidden' }}">
        <img src="/assets/default/img/loading.gif" alt="">
        <p class="mt-10">{{ trans('update.please_wait_for_the_content_to_load') }}</p>
    </div>
</div>
