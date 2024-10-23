@foreach ($course->chapters as $chapter)
    @if (
        !empty($chapter->chapterItems) and count($chapter->chapterItems) or
            !empty($chapter->quizzes) and count($chapter->quizzes))
        <div class="">
            {{-- <div class="flex font-medium items-center justify-between">
                <div class="flex items-center">
                    <span class="chapter-icon mr-15">
                        <i data-feather="grid" class=""></i>
                    </span>
                    <span class="font-bold text-black text-sm ml-3">{{ $chapter->title }}</span>
                </div>
                <span class="mr-15 text-sm text-slate-500">
                    {{ $chapter->getTopicsCount(true) }} {{ trans('public.parts') }}
                    {{ !empty($chapter->getDuration()) ? ' - ' . convertMinutesToHourAndMinute($chapter->getDuration()) . ' ' . trans('public.hr') : '' }}
                </span>
            </div> --}}
            <div id="collapseChapter{{ $chapter->id }}"
                aria-labelledby="chapter_{{ $chapter->id }}" class="" role="tabpanel">
                <div class="panel-collapse">
                    @if (!empty($chapter->chapterItems) and count($chapter->chapterItems))
                        @foreach ($chapter->chapterItems as $chapterItem)
                            @if (
                                $chapterItem->type == \App\Models\WebinarChapterItem::$chapterSession and
                                    !empty($chapterItem->session) and
                                    $chapterItem->session->status == 'active')
                                {{-- @include('web.jiujitsu.course.tabs.contents.sessions', [
                                    'session' => $chapterItem->session,
                                    'accordionParent' => 'chaptersAccordion',
                                ]) --}}
                            @elseif(
                                $chapterItem->type == \App\Models\WebinarChapterItem::$chapterFile and
                                    !empty($chapterItem->file) and
                                    $chapterItem->file->status == 'active')
                                @include('web.jiujitsu.course.tabs.contents.files', [
                                    'file' => $chapterItem->file,
                                    'accordionParent' => 'chaptersAccordion',
                                ])
                            {{-- @elseif(
                                $chapterItem->type == \App\Models\WebinarChapterItem::$chapterTextLesson and
                                    !empty($chapterItem->textLesson) and
                                    $chapterItem->textLesson->status == 'active')
                                @include('web.jiujitsu.course.tabs.contents.text_lessons', [
                                    'textLesson' => $chapterItem->textLesson,
                                    'accordionParent' => 'chaptersAccordion',
                                ]) --}}
                            {{-- @elseif(
                                $chapterItem->type == \App\Models\WebinarChapterItem::$chapterAssignment and
                                    !empty($chapterItem->assignment) and
                                    $chapterItem->assignment->status == 'active')
                                @include('web.jiujitsu.course.tabs.contents.assignment', [
                                    'assignment' => $chapterItem->assignment,
                                    'accordionParent' => 'chaptersAccordion',
                                ]) --}}
                            {{-- @elseif(
                                $chapterItem->type == \App\Models\WebinarChapterItem::$chapterQuiz and
                                    !empty($chapterItem->quiz) and
                                    $chapterItem->quiz->status == 'active')
                                @include('web.jiujitsu.course.tabs.contents.quiz', [
                                    'quiz' => $chapterItem->quiz,
                                    'accordionParent' => 'chaptersAccordion',
                                ]) --}}
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endif
@endforeach
