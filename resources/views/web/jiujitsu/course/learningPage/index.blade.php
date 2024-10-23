{{-- @extends('web.jiujitsu.layouts.fullwidth',['appFooter' => true, 'appHeader' => true]) --}}
@extends(getTemplate() . '.layouts.fullwidth')

@push('styles_top')
    {{-- <link rel="stylesheet" href="/assets/default/learning_page/styles.css" /> --}}
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')
    {{-- @include('web.jiujitsu.course.learningPage.components.navbar') --}}

    <div class="relative grid grid-cols-4 gap-7">
        <div id="webinarDemoVideoPlayer" class="grow bg-info-light col-span-4 lg:col-span-3">
            @include('web.jiujitsu.course.learningPage.components.content')

            {{-- organization --}}
            @if ($course->creator_id != $course->teacher_id)
                @include('web.jiujitsu.course.youtube_instructor_profile', [
                    'courseTeacher' => $course->creator,
                ])
            @endif
            {{-- teacher --}}
            @include('web.jiujitsu.course.youtube_instructor_profile', [
                'courseTeacher' => $course->teacher,
            ])

            <div class="flex">
                @if (!empty($course->category))
                    <div class="mt-4 font-normal">{{ trans('public.in') }}
                        <a href="{{ $course->category->getUrl() }}" target="_blank"
                            class="link font-medium">{{ $course->category->title }}</a>
                    </div>
                @endif
                <div class="flex mt-4">
                    @include('web.jiujitsu.includes.webinar.rate', ['rate' => $course->getRate()])
                    <span class="text-sm ml-4">({{ $course->reviews->pluck('creator_id')->count() }}
                        {{ trans('public.ratings') }})</span>
                </div>
            </div>

            @include(getTemplate() . '.course.tabs.youtube_information')


            {{-- <div class="mt-10 border-t-2 border-gray">
                @include(getTemplate() . '.course.tabs.reviews')
            </div> --}}
        </div>

        <div class="col-span-4 lg:col-span-1 learning-page-tabs show" id="learning_tabs">
            @include('web.jiujitsu.course.learningPage.components.content_tab.index')
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var defaultItemType = '{{ request()->get('type') }}'
        var defaultItemId = '{{ request()->get('item') }}'
        var loadFirstContent =
            {{ (!empty($dontAllowLoadFirstContent) and $dontAllowLoadFirstContent) ? 'false' : 'true' }}; // allow to load first content when request item is empty

        var courseUrl = '{{ $course->getUrl() }}';

        // lang
        var pleaseWaitForTheContentLang = '{{ trans('update.please_wait_for_the_content_to_load') }}';
        var downloadTheFileLang = '{{ trans('update.download_the_file') }}';
        var downloadLang = '{{ trans('home.download') }}';
        var showHtmlFileLang = '{{ trans('update.show_html_file') }}';
        var showLang = '{{ trans('update.show') }}';
        var sessionIsLiveLang = '{{ trans('update.session_is_live') }}';
        var youCanJoinTheLiveNowLang = '{{ trans('update.you_can_join_the_live_now') }}';
        var passwordLang = '{{ trans('auth.password') }}';
        var joinTheClassLang = '{{ trans('update.join_the_class') }}';
        var coursePageLang = '{{ trans('update.course_page') }}';
        var quizPageLang = '{{ trans('update.quiz_page') }}';
        var sessionIsNotStartedYetLang = '{{ trans('update.session_is_not_started_yet') }}';
        var thisSessionWillBeStartedOnLang = '{{ trans('update.this_session_will_be_started_on') }}';
        var sessionIsFinishedLang = '{{ trans('update.session_is_finished') }}';
        var sessionIsFinishedHintLang = '{{ trans('update.this_session_is_finished_You_cant_join_it') }}';
        var goToTheQuizPageForMoreInformationLang = '{{ trans('update.go_to_the_quiz_page_for_more_information') }}';
        var downloadCertificateLang = '{{ trans('update.download_certificate') }}';
        var enjoySharingYourCertificateWithOthersLang = '{{ trans('update.enjoy_sharing_your_certificate_with_others') }}';
        var attachmentsLang = '{{ trans('public.attachments') }}';
        var checkAgainLang = '{{ trans('update.check_again') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var sendAssignmentSuccessLang = '{{ trans('update.send_assignment_success') }}';
        var saveAssignmentRateSuccessLang = '{{ trans('update.save_assignment_grade_success') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var changesSavedSuccessfullyLang = '{{ trans('update.changes_saved_successfully') }}';
        var oopsLang = '{{ trans('update.oops') }}';
        var somethingWentWrongLang = '{{ trans('update.something_went_wrong') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var cantStartQuizToastTitleLang = '{{ trans('public.request_failed') }}';
        var cantStartQuizToastMsgLang = '{{ trans('quiz.cant_start_quiz') }}';
        var learningPageEmptyContentTitleLang = '{{ trans('update.learning_page_empty_content_title') }}';
        var learningPageEmptyContentHintLang = '{{ trans('update.learning_page_empty_content_hint') }}';
        var expiredQuizLang = '{{ trans('update.expired_quiz') }}';

        $(document).ready(() => {
            $('body').on('click', '.js-course-direct-payment', function(e) {
                const $this = $(this);
                $this.addClass('loadingbar danger').prop('disabled', true);

                const $form = $this.closest('form');
                $form.attr('action', '/course/direct-payment');

                $form.trigger('submit');
            });
        })
    </script>
    <script type="text/javascript" src="/assets/default/vendors/dropins/dropins.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/learning_page/scripts.min.js"></script>

    @if (!empty($isForumPage) and $isForumPage or !empty($isForumAnswersPage) and $isForumAnswersPage)
        <script src="/assets/learning_page/forum.min.js"></script>
    @endif
@endpush
