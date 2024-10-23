<div class="content-tab p-15 pb-50">

    @if(
        (empty($sessionsWithoutChapter) or !count($sessionsWithoutChapter)) and
        (empty($textLessonsWithoutChapter) or !count($textLessonsWithoutChapter)) and
        (empty($filesWithoutChapter) or !count($filesWithoutChapter)) and
        (empty($course->chapters) or !count($course->chapters))
    )
        <div class="learning-page-forum-empty flex items-center justify-center flex-col">
            <div class="learning-page-forum-empty-icon flex items-center justify-center">
                <img src="/assets/default/img/learning/content-empty.svg" class="img-fluid" alt="">
            </div>

            <div class="flex items-center flex-col mt-10 text-center">
                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.learning_page_empty_content_title') }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-5 text-center">{{ trans('update.learning_page_empty_content_hint') }}</p>
            </div>
        </div>
    @else
        @if(!empty($sessionsWithoutChapter) and count($sessionsWithoutChapter))
            @foreach($sessionsWithoutChapter as $session)
                @include('web.jiujitsu.course.learningPage.components.content_tab.content',['item' => $session, 'type' => \App\Models\WebinarChapter::$chapterSession])
            @endforeach
        @endif

        @if(!empty($textLessonsWithoutChapter) and count($textLessonsWithoutChapter))
            @foreach($textLessonsWithoutChapter as $textLesson)
                @include('web.jiujitsu.course.learningPage.components.content_tab.content',['item' => $textLesson, 'type' => \App\Models\WebinarChapter::$chapterTextLesson])
            @endforeach
        @endif

        @if(!empty($filesWithoutChapter) and count($filesWithoutChapter))
            @foreach($filesWithoutChapter as $file)
                @include('web.jiujitsu.course.learningPage.components.content_tab.content',['item' => $file, 'type' => \App\Models\WebinarChapter::$chapterFile])
            @endforeach
        @endif

        @if(!empty($course->chapters) and count($course->chapters))
            @include('web.jiujitsu.course.learningPage.components.content_tab.chapter')
        @endif

    @endif
</div>
