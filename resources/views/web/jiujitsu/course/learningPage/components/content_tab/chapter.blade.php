@if (!empty($course->chapters) and count($course->chapters))
    <div class="accordion-content-wrapper" id="chapterAccordion" role="tablist" aria-multiselectable="true">
        @foreach ($course->chapters as $chapter)


                {{-- <div class="collapse-title flex items-center justify-between p-3" role="tab"
                    id="chapter_{{ $chapter->id }}">
                    <div class="flex items-center" href="#collapseChapter{{ $chapter->id }}"
                        aria-controls="collapseChapter{{ $chapter->id }}" data-parent="#chapterAccordion"
                        role="button" data-toggle="collapse" aria-expanded="true">
                        <span class="flex bg-primary w-10 h-10 rounded-full mr-3 justify-center items-center text-white">
                            <i data-feather="grid" class="" width="20" height="20"></i>
                        </span>

                        <div class="">
                            <span class="font-bold text-sm text-dark-blue block">{{ $chapter->title }}</span>

                            <span class="text-sm text-slate-500 block">
                                {{ $chapter->getTopicsCount(true) }} {{ trans('public.topic') }}
                            </span>
                        </div>
                    </div>
                </div> --}}

                {{-- <div id="collapseChapter{{ $chapter->id }}" aria-labelledby="chapter_{{ $chapter->id }}"
                    class="collapse" role="tabpanel"> --}}


                        @if (!empty($chapter->chapterItems) and count($chapter->chapterItems))
                            @foreach ($chapter->chapterItems as $chapterItem)
                                @if (
                                    $chapterItem->type == \App\Models\WebinarChapterItem::$chapterSession and
                                        !empty($chapterItem->session) and
                                        $chapterItem->session->status == 'active')
                                    @include(
                                        'web.jiujitsu.course.learningPage.components.content_tab.content',
                                        ['item' => $chapterItem->session, 'type' => 'session']
                                    )
                                @elseif(
                                    $chapterItem->type == \App\Models\WebinarChapterItem::$chapterFile and
                                        !empty($chapterItem->file) and
                                        $chapterItem->file->status == 'active')
                                    @include(
                                        'web.jiujitsu.course.learningPage.components.content_tab.content',
                                        ['item' => $chapterItem->file, 'type' => 'file']
                                    )
                                @elseif(
                                    $chapterItem->type == \App\Models\WebinarChapterItem::$chapterTextLesson and
                                        !empty($chapterItem->textLesson) and
                                        $chapterItem->textLesson->status == 'active')
                                    @include(
                                        'web.jiujitsu.course.learningPage.components.content_tab.content',
                                        ['item' => $chapterItem->textLesson, 'type' => 'text_lesson']
                                    )
                                @elseif(
                                    $chapterItem->type == \App\Models\WebinarChapterItem::$chapterAssignment and
                                        !empty($chapterItem->assignment) and
                                        $chapterItem->assignment->status == 'active')
                                    @include(
                                        'web.jiujitsu.course.learningPage.components.content_tab.assignment-content-tab',
                                        ['item' => $chapterItem->assignment]
                                    )
                                @elseif(
                                    $chapterItem->type == \App\Models\WebinarChapterItem::$chapterQuiz and
                                        !empty($chapterItem->quiz) and
                                        $chapterItem->quiz->status == 'active')
                                    @include('web.jiujitsu.course.learningPage.components.quiz_tab.quiz', [
                                        'item' => $chapterItem->quiz,
                                        'type' => 'quiz',
                                    ])
                                @endif
                            @endforeach
                        @endif

                {{-- </div> --}}

        @endforeach
    </div>
    <div class="hidden lg:inline-block">
        @include(getTemplate() . '.course.tabs.youtube_content')
    </div>
@endif
