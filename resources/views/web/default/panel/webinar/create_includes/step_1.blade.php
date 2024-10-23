@push('styles_top')
    {{-- <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css"> --}}
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" />
@endpush

{{-- <input type="hidden" name="locale" value="{{ getDefaultLocale() }}"> --}}
<input type="hidden" name="type" value="course">


<!-- @if ($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif -->
<div class="row mt-15">
    {{-- Left --}}
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label class="input-label">
                {{-- {{ trans('public.title') }} --}}
                Title of your course
            </label>
            <input type="text" name="title"
                value="{{ (!empty($webinar) and !empty($webinar->translate($locale))) ? $webinar->translate($locale)->title : old('title') }}"
                class="form-control @error('title')  is-invalid @enderror" placeholder="" />
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- <input type="hidden" name="slug" class="form-control @error('slug')  is-invalid @enderror" />
            @error('slug')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror --}}
        </div>
        <div class="form-group">
            <label class="input-label">
                {{ trans('public.price') }} for your course ({{ $currency }})
            </label>
            <input type="number" name="price"
                value="{{ (!empty($webinar) and !empty($webinar->price)) ? convertPriceToUserCurrency($webinar->price) : old('price') }}"
                class="form-control @error('price')  is-invalid @enderror"
                placeholder="{{ trans('public.0_for_free') }}" />
            @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="row">
            <div class="col-12 col-md-6">
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.category') }}</label>

                    <select id="categories" class="custom-select @error('category_id')  is-invalid @enderror"
                        name="category_id" required>
                        <option {{ (!empty($webinar) and !empty($webinar->category_id)) ? '' : 'selected' }} disabled>
                            {{ trans('public.choose_category') }}</option>
                        @foreach ($categories as $category)
                            @if (!empty($category->subCategories) and $category->subCategories->count() > 0)
                                <optgroup label="{{ $category->title }}">
                                    @foreach ($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            {{ (!empty($webinar) and $webinar->category_id == $subCategory->id or old('category_id') == $subCategory->id) ? 'selected' : '' }}>
                                            {{ $subCategory->title }}</option>
                                    @endforeach
                                </optgroup>
                            @else
                                <option value="{{ $category->id }}"
                                    {{ (!empty($webinar) and $webinar->category_id == $category->id or old('category_id') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div> --}}
        <div class="form-group">
            <label class="input-label">{{ trans('public.description') }} for your course</label>
            <textarea id="summernote" name="description" class="form-control @error('description')  is-invalid @enderror"
                rows="10">{!! (!empty($webinar) and !empty($webinar->translate($locale)))
                    ? $webinar->translate($locale)->description
                    : old('description') !!}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- <section class="mt-50">
            <div class="">
                <h2 class="section-title after-line">{{ trans('public.chapters') }}
                </h2>
            </div>

            <button type="button" class="js-add-chapter btn btn-primary btn-sm mt-15"
                data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}">{{ trans('public.new_chapter') }}</button>

            @include('web.default.panel.webinar.create_includes.accordions.chapter')
        </section> --}}
    </div>
    {{-- Right --}}
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label class="input-label">{{ trans('public.thumbnail_image') }} for your course</label>
            {{-- <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text panel-file-manager" data-input="thumbnail" data-preview="holder">
                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                    </button>
                </div>
                <input type="text" name="thumbnail" id="thumbnail" value="{{ !empty($webinar) ? $webinar->thumbnail : old('thumbnail') }}" class="form-control @error('thumbnail')  is-invalid @enderror" placeholder="{{ trans('forms.course_thumbnail_size') }}"/>
                @error('thumbnail')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>  --}}

            <div class="dropzone thumbnailDropzone">
                <div class="fallback">
                    <input name="file" value="{{ !empty($webinar) ? $webinar->thumbnail : old('thumbnail') }}"
                        class="form-control @error('thumbnail')  is-invalid @enderror" type="file" multiple
                        accept=".jpg, .jpeg, .png, .pdf" />
                </div>
                <button class="uploadButton d-none">Upload Files</button>
            </div>
            <input type="hidden" name="thumbnail" class="thumbnail"
                value="{{ !empty($webinar) ? $webinar->thumbnail : old('thumbnail') }}"
                class="d-none @error('thumbnail')  is-invalid @enderror"
                placeholder="{{ trans('forms.course_thumbnail_size') }}" />
            @error('thumbnail')
                <div class="text-danger text-sm mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <hr>
        <div class="form-group">
            <label class="input-label font-12">
                {{-- {{ trans('public.demo_video') }} {{ trans('public.source') }} --}}
                Your course preview video
            </label>
            <select name="video_demo_source" class="js-video-demo-source form-control">
                @foreach (\App\Models\Webinar::$videoDemoSource as $source)
                    <option value="{{ $source }}" @if (!empty($webinar) and $webinar->video_demo_source == $source) selected @endif>
                        {{ trans('update.file_source_' . $source) }}</option>
                @endforeach
            </select>

        </div>
        <div class="form-group">
            <div class="input-group js-video-demo-path-input">
                <div class="input-group-prepend">
                    <button type="button"
                        class="js-video-demo-path-upload input-group-text text-white panel-file-manager {{ (empty($webinar) or empty($webinar->video_demo_source) or $webinar->video_demo_source == 'upload') ? '' : 'd-none' }}"
                        data-input="demo_video" data-preview="holder">
                        <i data-feather="upload" width="18" height="18" class="text-white"></i>
                    </button>

                    <button type="button"
                        class="js-video-demo-path-links rounded-left input-group-text input-group-text-rounded-left text-white {{ (empty($webinar) or empty($webinar->video_demo_source) or $webinar->video_demo_source == 'upload') ? 'd-none' : '' }}">
                        <i data-feather="link" width="18" height="18" class="text-white"></i>
                    </button>
                </div>
                <input type="text" name="video_demo" id="demo_video"
                    value="{{ !empty($webinar) ? $webinar->video_demo : old('video_demo') }}"
                    class="form-control @error('video_demo')  is-invalid @enderror" />
                @error('video_demo')
                    <div class="text-danger text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="dropzone uploadVideoDropzone">
                <div class="fallback">
                    <input name="file" value="{{ !empty($webinar) ? $webinar->video_demo : old('video_demo') }}"
                        class="form-control @error('video_demo')  is-invalid @enderror" type="file"
                        accept=".mp4, .avi, .mov" multiple />
                </div>
                <button class="uploadVideoButton d-none">Upload Files</button>
            </div>
            <input type="hidden" name="video_demo" class="video_demo"
                value="{{ !empty($webinar) ? $webinar->video_demo : old('video_demo') }}"
                class="d-none @error('video_demo')  is-invalid @enderror"
                placeholder="{{ trans('forms.course_cover_size') }}" />

            @error('video_demo')
                <div class="text-danger text-sm mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <hr> --}}

        <div class="form-group">
            <label class="input-label">{{ trans('public.duration') }} ({{ trans('public.minutes') }})</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="timeInputGroupPrepend">
                        <i data-feather="clock" width="18" height="18" class="text-white"></i>
                    </span>
                </div>


                <input type="text" name="duration"
                    value="{{ (!empty($webinar) and !empty($webinar->duration)) ? $webinar->duration : old('duration') }}"
                    class="form-control @error('duration')  is-invalid @enderror" />
                @error('duration')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

    </div>

</div>

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script>
        var requestFailedLang = '{{ trans('public.request_failed') }}';
        var thisLiveHasEndedLang = '{{ trans('update.this_live_has_been_ended') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var quizzesSectionLang = '{{ trans('quiz.quizzes_section') }}';
    </script>

    <script src="/assets/default/js/panel/quiz.min.js"></script>
    <script>
        var videoDemoPathPlaceHolderBySource = {
            upload: '{{ trans('update.file_source_upload_placeholder') }}',
            youtube: '{{ trans('update.file_source_youtube_placeholder') }}',
            vimeo: '{{ trans('update.file_source_vimeo_placeholder') }}',
            external_link: '{{ trans('update.file_source_external_link_placeholder') }}',
        }
    </script>
@endpush

@push('scripts_bottom2')
    <script>
        Dropzone.autoDiscover = false;

        function initializeDropzone(containerClass, uploadButtonClass, inputClass) {
            var myDropzone = new Dropzone("." + containerClass, {
                url: "{{ route('panel_upload') }}",
                paramName: "file",
                uploadMultiple: false,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                maxFilesize: 2, // MB
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                init: function() {



                    @if (@$webinar && method_exists(@$webinar, 'getImage'))
                        var thisDropzone = this;
                        var mockFile = {
                            name: 'Name Image',
                            size: 12345,
                            type: 'image/jpeg'
                        };
                        thisDropzone.emit("addedfile", mockFile);
                        thisDropzone.emit("success", mockFile);
                        thisDropzone.emit("thumbnail", mockFile, "{{ $webinar->getImage() }}")
                    @elseif (@$webinar && $webinar->thumbnail)
                        thisDropzone.emit("thumbnail", mockFile, "{{ $webinar->thumbnail }}")
                    @endif

                    this.on("success", function(file, response) {
                        console.log(response);
                        var fileName = response.thumbnail;

                        // Extract the path after "/store"
                        var pathAfterStore = fileName.split('/store')[1];

                        // Update the input field value with the path after "/store"
                        document.querySelector("." + inputClass).value = "/store" + pathAfterStore;


                    });
                }
            });

            // Trigger file upload dialog on button click
            document.querySelector("." + uploadButtonClass).addEventListener("click", function() {
                myDropzone.hiddenFileInput.click();
            });
        }

        // Initialize Dropzone for thumbnail
        initializeDropzone("thumbnailDropzone", "uploadButton", "thumbnail");

        // Initialize Dropzone for cover image
        // initializeDropzone("coverImageDropzone", "uploadCoverButton", "cover_image");
    </script>
    <script>
        Dropzone.autoDiscover = false;

        function initializeVideoDropzone(containerClass, uploadButtonClass, inputClass) {
            var myDropzone = new Dropzone("." + containerClass, {
                url: "{{ route('panel_upload') }}",
                paramName: "file",
                uploadMultiple: false,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },

                acceptedFiles: ".mp4, .avi, .mov",
                init: function() {



                    @if (@$webinar && $webinar->video_demo)
                        var thisDropzone = this;
                        var mockFile = {
                            name: 'Name Image',
                            size: 12345,
                            type: 'image/jpeg'
                        };
                        thisDropzone.emit("addedfile", mockFile);
                        thisDropzone.emit("success", mockFile);
                        thisDropzone.emit("video_demo", mockFile, "{{ $webinar->video_demo }}")
                    @endif

                    this.on("success", function(file, response) {
                        console.log(response);
                        if (response && response.thumbnail) {
                            var fileName = response.thumbnail;

                            // Extract the path after "/store"
                            var pathAfterStore = fileName.split('/store')[1];

                            // Update the input field value with the path after "/store"
                            document.querySelector("." + inputClass).value = "/store" + pathAfterStore;
                        } else {
                            console.error("Invalid response format or missing 'video_demo' property",
                                response);
                        }

                    });
                }
            });

            // Trigger file upload dialog on button click
            document.querySelector("." + uploadButtonClass).addEventListener("click", function() {
                myDropzone.hiddenFileInput.click();
            });
        }

        initializeVideoDropzone("uploadVideoDropzone", "uploadVideoButton", "video_demo");
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Show the upload section by default
            $('.uploadVideoDropzone').show();
            $('.js-video-demo-path-input').hide();

            // Listen for changes in the dropdown
            $('select[name="video_demo_source"]').change(function() {
                // Get the selected value
                var selectedSource = $(this).val();

                // Hide all sections
                $('.uploadVideoDropzone').hide();
                $('.js-video-demo-path-input').hide();

                // Show the relevant section based on the selected value
                if (selectedSource === 'upload') {
                    $('.uploadVideoDropzone').next('input[type="hidden"]').attr('name', "video_demo");
                    $('.uploadVideoDropzone').show();
                } else {
                    $('.uploadVideoDropzone').next('input[type="hidden"]').attr('name', "");
                    $('.js-video-demo-path-input').show();
                }
            });
        });
    </script>
@endpush
