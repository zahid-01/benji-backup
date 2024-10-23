@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" />
@endpush

@if ($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif

<section class="mt-50">
    <div class="">
        <h2 class="section-title after-line">{{ trans('public.chapters') }}</h2>
    </div>

    <button type="button" class="js-add-chapter btn btn-primary btn-sm mt-15"
        data-webinar-id="{{ $webinar->id }}">{{ trans('public.new_chapter') }}</button>

    @include('web.default.panel.webinar.create_includes.accordions.chapter')
</section>

@if ($webinar->isWebinar())
    <div id="newSessionForm" class="d-none">
        @include('web.default.panel.webinar.create_includes.accordions.session', ['webinar' => $webinar])
    </div>
@endif

<div id="newFileForm" class="d-none">
    @include('web.default.panel.webinar.create_includes.accordions.file', ['webinar' => $webinar])
</div>

@if (getFeaturesSettings('new_interactive_file'))
    <div id="newInteractiveFileForm" class="d-none">
        @include('web.default.panel.webinar.create_includes.accordions.new_interactive_file', [
            'webinar' => $webinar,
        ])
    </div>
@endif


<div id="newTextLessonForm" class="d-none">
    @include('web.default.panel.webinar.create_includes.accordions.text-lesson', ['webinar' => $webinar])
</div>

<div id="newQuizForm" class="d-none">
    @include('web.default.panel.webinar.create_includes.accordions.quiz', [
        'webinar' => $webinar,
        'quizInfo' => null,
        'webinarChapterPages' => true,
    ])
</div>

@if (getFeaturesSettings('webinar_assignment_status'))
    <div id="newAssignmentForm" class="d-none">
        @include('web.default.panel.webinar.create_includes.accordions.assignment', [
            'webinar' => $webinar,
        ])
    </div>
@endif

@include('web.default.panel.webinar.create_includes.chapter_modal')

@include('web.default.panel.webinar.create_includes.change_chapter_modal')


<section class="mt-20">
    <h2 class="section-title after-line mt-20">{{ trans('public.message_to_reviewer') }}</h2>
    <div class="row">
        <div class="col-12">
            <div class="form-group mt-15">
                <textarea name="message_for_reviewer" rows="10" class="form-control">{{ (!empty($webinar) and $webinar->message_for_reviewer) ? $webinar->message_for_reviewer : old('message_for_reviewer') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group mt-10">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="cursor-pointer input-label"
                        for="rulesSwitch">{{ trans('public.agree_rules') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="rules" class="custom-control-input "
                            id="rulesSwitch">
                        <label class="custom-control-label" for="rulesSwitch"></label>
                    </div>
                </div>

                @error('rules')
                    <div class="text-danger mt-10">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</section>

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script>
        var requestFailedLang = '{{ trans('public.request_failed') }}';
        var thisLiveHasEndedLang = '{{ trans('update.this_live_has_been_ended') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var quizzesSectionLang = '{{ trans('quiz.quizzes_section') }}';
    </script>

    <script src="/assets/default/js/panel/quiz.min.js"></script>
@endpush

@push('scripts_bottom2')
    <script>
        function initializeUploadVideoDropzone(containerClass, uploadButtonClass, inputClass) {

            // if (!document.querySelector("." + containerUploadClass).classList.contains("dz-clickable")) {
            var myDropzone = new Dropzone("." + containerClass, {
                url: "{{ route('panel_upload') }}",
                paramName: "file",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },

                acceptedFiles: ".mp4, .avi, .mov",
                init: function() {
                    this.on("success", function(file, response) {
                        if (response && response.thumbnail) {
                            var fileName = response.thumbnail;

                            // Extract the path after "/store"
                            var pathAfterStore = fileName.split('/store')[1];

                            // Update the input field value with the path after "/store"
                            document.querySelector("." + inputClass).value = "/store" +
                                pathAfterStore;

                        } else {
                            // console.error(
                            //     "Invalid response format or missing 'file' property",
                            //     response);
                            myDropzone.removeFile(file);
                            alert(response.error)
                        }


                    });

                }
            });

            // Trigger file upload dialog on button click
            document.querySelector("." + uploadButtonClass).addEventListener("click", function() {
                myDropzone.hiddenFileInput.click();
            });
            // }
        }
    </script>
@endpush
