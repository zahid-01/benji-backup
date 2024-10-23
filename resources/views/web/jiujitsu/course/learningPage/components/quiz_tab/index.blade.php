<div class="content-tab p-15 pb-50">
    @if(!empty($course->quizzes) and $course->quizzes->count())
        @foreach($course->quizzes as $quiz)
            @include('web.jiujitsu.course.learningPage.components.quiz_tab.quiz',['item' => $quiz, 'type' => 'quiz','class' => 'px-10 border border-gray200 rounded-sm mb-15'])
        @endforeach

    @else
        <div class="learning-page-forum-empty flex items-center justify-center flex-col">
            <div class="learning-page-forum-empty-icon flex items-center justify-center">
                <img src="/assets/default/img/learning/quiz-empty.svg" class="img-fluid" alt="">
            </div>

            <div class="flex items-center flex-col mt-10 text-center">
                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.learning_page_empty_quiz_title') }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-5 text-center">{{ trans('update.learning_page_empty_quiz_hint') }}</p>
            </div>
        </div>
    @endif
</div>
