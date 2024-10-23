@php
    $hasCertificateItem=false;
@endphp

<div class="content-tab p-15 pb-50">
    @if($course->certificate)
        @php
            $hasCertificateItem = true;
        @endphp

        <div class="course-certificate-item cursor-pointer p-10 border border-gray200 rounded-sm mb-15" data-course-certificate="{{ !empty($courseCertificate) ? $courseCertificate->id : '' }}">
            <div class="flex items-center">
                <span class="chapter-icon bg-gray300 mr-10">
                    <i data-feather="award" class="text-slate-500" width="16" height="16"></i>
                </span>

                <div class="grow">
                    <span class="font-medium text-sm text-dark-blue block">{{ trans('update.course_certificate') }}</span>

                    <div class="flex items-center">
                        @if(!empty($courseCertificate))
                            <span class="text-sm text-slate-500">{{ trans("public.date") }}: {{ dateTimeFormat($courseCertificate->created_at, 'j F Y') }}</span>
                        @else
                            <span class="text-sm text-slate-500">{{ trans("update.not_achieve") }}</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if(!empty($course->quizzes) and count($course->quizzes))
        @foreach($course->quizzes as $courseQuiz)
            @if($courseQuiz->certificate)
                @php
                    $hasCertificateItem = true;
                @endphp

                <div class="certificate-item cursor-pointer p-10 border border-gray200 rounded-sm mb-15" data-result="{{ $courseQuiz->result ? $courseQuiz->result->id : '' }}">
                    <div class="flex items-center">
                        <span class="chapter-icon bg-gray300 mr-10">
                            <i data-feather="award" class="text-slate-500" width="16" height="16"></i>
                        </span>

                        <div class="grow">
                            <span class="font-medium text-sm text-dark-blue block">{{ $courseQuiz->title }}</span>

                            <div class="flex items-center">
                                <span class="text-sm text-slate-500">{{ $courseQuiz->pass_mark }}/{{ $courseQuiz->quizQuestions->sum('grade') }}</span>

                                @if(!empty($courseQuiz->result))
                                    <span class="text-sm text-slate-500 ml-10">{{ dateTimeFormat($courseQuiz->result->created_at, 'j M Y H:i') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        @endforeach
    @endif

    @if(!$hasCertificateItem)
        <div class="learning-page-forum-empty flex items-center justify-center flex-col">
            <div class="learning-page-forum-empty-icon flex items-center justify-center">
                <img src="/assets/default/img/learning/certificate-empty.svg" class="img-fluid" alt="">
            </div>

            <div class="flex items-center flex-col mt-10 text-center">
                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.learning_page_empty_certificate_title') }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-5 text-center">{{ trans('update.learning_page_empty_certificate_hint') }}</p>
            </div>
        </div>
    @endif
</div>
