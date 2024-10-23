@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')
    <section class="course-cover-container bg-gray200">
        <img src="{{ $upcomingCourse->getImageCover() }}" class="img-cover course-cover-img" alt="{{ $upcomingCourse->title }}"/>
    </section>

    <section class="container course-content-section">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">
                    <div class="upcoming-course-body-on-cover flex flex-col text-white pb-15">
                        <h1 class="text-3xl">
                            {{ clean($upcomingCourse->title, 't') }}
                        </h1>


                        @if(!empty($upcomingCourse->category))
                            <span class="block font-16 mt-10">{{ trans('public.in') }} <a href="{{ $upcomingCourse->category->getUrl() }}" target="_blank" class="font-medium text-decoration-underline text-white">{{ $upcomingCourse->category->title }}</a></span>
                        @endif

                        <div class="mt-15">
                            <span class="text-sm">{{ trans('public.created_by') }}</span>
                            <a href="{{ $upcomingCourse->teacher->getProfileUrl() }}" target="_blank" class="text-decoration-underline text-white text-sm font-medium">{{ $upcomingCourse->teacher->full_name }}</a>
                        </div>

                        <div class="mt-auto">
                            @if(!empty($followingUsers) and count($followingUsers))
                                <div class="flex items-center mt-14">
                                    <div class="flex items-center overlay-avatars">
                                        @foreach($followingUsers as $followingUser)
                                            <div class="overlay-avatars__item size-40 rounded-full">
                                                <img src="{{ $followingUser->user->getAvatar(40) }}" alt="{{ $followingUser->full_name }}" class="img-cover rounded-full">
                                            </div>
                                        @endforeach

                                        @if($followingUsersCount - $followingUsers->count() > 0)
                                            <div class="overlay-avatars__count size-40 rounded-full flex items-center justify-center text-sm text-slate-500">
                                                +{{ $followingUsersCount - $followingUsers->count() }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-2">
                                        <span class="block text-sm font-bold text-white">{{ $followingUsersCount }} {{ trans('panel.users') }}</span>
                                        <span class="block text-sm text-white">{{ trans('update.are_following_this_upcoming_course') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        @include('web.jiujitsu.upcoming_courses.tabs.information')
                    </div>
                </div>
            </div>

            <div class="course-content-sidebar col-12 col-lg-4 mt-25 mt-lg-0">
                <div class="rounded-lg shadow-lg">
                    <div class="course-img {{ $upcomingCourse->video_demo ? 'has-video' :'' }}">

                        <img src="{{ $upcomingCourse->getImage() }}" class="img-cover" alt="">

                        @if($upcomingCourse->video_demo)
                            <div id="webinarDemoVideoBtn"
                                 data-video-path="{{ $upcomingCourse->video_demo_source == 'upload' ?  url($upcomingCourse->video_demo) : $upcomingCourse->video_demo }}"
                                 data-video-source="{{ $upcomingCourse->video_demo_source }}"
                                 class="course-video-icon cursor-pointer flex items-center justify-center">
                                <i data-feather="play" width="25" height="25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="px-20 pb-30">

                        @if(!empty($upcomingCourse->webinar_id))
                            <a href="{{ $upcomingCourse->webinar->getUrl() }}" class="btn btn-primary btn-block mt-4">{{ trans('update.view_course') }}</a>
                        @else
                            @if(!empty($authUser))
                                <button type="button" class="js-follow-upcoming-course btn btn-primary btn-block mt-4" data-path="/upcoming_courses/{{ $upcomingCourse->slug }}/toggleFollow">
                                    {{ $followed ? trans('update.unfollow_course') : trans('update.follow_course') }}
                                </button>
                            @else
                                <a href="/login" class="btn btn-primary btn-block mt-4">{{ trans('update.follow_course') }}</a>
                            @endif
                        @endif

                        <div class="mt-4 flex items-center justify-center text-slate-500">
                            <i data-feather="bell" width="20" height="20"></i>
                            <span class="ml-2 text-sm">{{ trans('update.youll_get_notified_about_course_publish') }}</span>
                        </div>

                        <div class="mt-8">
                            <strong class="block text-black font-bold">{{ trans('update.this_course_includes') }}:</strong>

                            @if($upcomingCourse->downloadable)
                                <div class="mt-4 flex items-center text-slate-500">
                                    <i data-feather="download-cloud" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('webinars.downloadable_content') }}</span>
                                </div>
                            @endif

                            @if($upcomingCourse->certificate)
                                <div class="mt-4 flex items-center text-slate-500">
                                    <i data-feather="award" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('webinars.official_certificate') }}</span>
                                </div>
                            @endif

                            @if($upcomingCourse->include_quizzes)
                                <div class="mt-4 flex items-center text-slate-500">
                                    <i data-feather="file-text" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('quiz.quizzes') }}</span>
                                </div>
                            @endif

                            @if($upcomingCourse->support)
                                <div class="mt-4 flex items-center text-slate-500">
                                    <i data-feather="headphones" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('webinars.instructor_support') }}</span>
                                </div>
                            @endif

                            @if($upcomingCourse->forum)
                                <div class="mt-4 flex items-center text-slate-500">
                                    <i data-feather="headphones" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('update.course_forum') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-14 p-10 rounded-sm border row items-center favorites-share-box">
                            @if(!empty($upcomingCourse->publish_date))
                                <div class="col">
                                    <a href="{{ $upcomingCourse->addToCalendarLink() }}" target="_blank" class="flex flex-col items-center text-center text-slate-500">
                                        <i data-feather="calendar" width="20" height="20"></i>
                                        <span class="text-sm">{{ trans('public.reminder') }}</span>
                                    </a>
                                </div>
                            @endif

                            <div class="col">
                                <a href="/upcoming_courses/{{ $upcomingCourse->slug }}/favorite" id="favoriteToggle" class="flex flex-col items-center text-slate-500">
                                    <i data-feather="heart" class="{{ !empty($isFavorite) ? 'favorite-active' : '' }}" width="20" height="20"></i>
                                    <span class="text-sm">{{ trans('panel.favorite') }}</span>
                                </a>
                            </div>

                            <div class="col">
                                <a href="#" class="js-share-course flex flex-col items-center text-slate-500">
                                    <i data-feather="share-2" width="20" height="20"></i>
                                    <span class="text-sm">{{ trans('public.share') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <button type="button" id="webinarReportBtn" class="text-sm text-slate-500 btn-ghost">{{ trans('update.report_this_course') }}</button>
                        </div>
                    </div>
                </div>

                @if($upcomingCourse->teacher->offline)
                    <div class="rounded-lg shadow-lg mt-8 flex">
                        <div class="offline-icon offline-icon-left flex align-items-stretch">
                            <div class="flex items-center">
                                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                            </div>
                        </div>

                        <div class="p-15">
                            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                            <p class="text-sm font-medium text-slate-500 mt-15">{{ $upcomingCourse->teacher->offline_message }}</p>
                        </div>
                    </div>
                @endif

                <div class="rounded-lg shadow-lg mt-8 px-4 py-20">
                    <h3 class="sidebar-title font-16 text-black font-bold">{{ trans('update.course_specifications') }}</h3>

                    <div class="mt-6">
                        @if(!empty($upcomingCourse->publish_date))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="calendar" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('update.publish_date') }}:</span>
                                </div>
                                <span class="text-sm">{{ dateTimeFormat($upcomingCourse->publish_date, 'j M Y | H:i') }}</span>
                            </div>
                        @endif

                        @if(!empty($upcomingCourse->duration))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="clock" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('public.duration') }}:</span>
                                </div>
                                <span class="text-sm">{{ convertMinutesToHourAndMinute($upcomingCourse->duration) }} {{ trans('home.hours') }}</span>
                            </div>
                        @endif

                        @if(!empty($upcomingCourse->sections))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="layers" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('update.sections') }}:</span>
                                </div>
                                <span class="text-sm">{{ $upcomingCourse->sections }}</span>
                            </div>
                        @endif

                        @if(!empty($upcomingCourse->parts))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="film" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('public.parts') }}:</span>
                                </div>
                                <span class="text-sm">{{ $upcomingCourse->parts }}</span>
                            </div>
                        @endif

                        @if(!empty($upcomingCourse->capacity))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="users" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('public.capacity') }}:</span>
                                </div>
                                <span class="text-sm">{{ $upcomingCourse->capacity }}</span>
                            </div>
                        @endif


                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <i data-feather="tag" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('public.price') }}:</span>
                            </div>
                            <span class="text-sm">{{ (!empty($upcomingCourse->price) and $upcomingCourse->price > 0) ? handlePrice($upcomingCourse->price) : trans('public.free') }}</span>
                        </div>

                        @if(!empty($upcomingCourse->course_progress))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="trending-up" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('update.progress') }}:</span>
                                </div>
                                <span class="text-sm">{{ $upcomingCourse->course_progress }}%</span>
                            </div>

                            <div class="progress upcoming-course-progress mt-15">
                                <span class="progress-bar {{ ($upcomingCourse->course_progress < 50) ? 'less-50' : '' }}" style="width: {{ $upcomingCourse->course_progress }}%"></span>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- organization --}}
                @if($upcomingCourse->creator_id != $upcomingCourse->teacher_id)
                    @include('web.jiujitsu.course.sidebar_instructor_profile', ['courseTeacher' => $upcomingCourse->creator])
                @endif
                {{-- teacher --}}
                @include('web.jiujitsu.course.sidebar_instructor_profile', ['courseTeacher' => $upcomingCourse->teacher])
                {{-- ./ teacher --}}

                {{-- tags --}}
                @if($upcomingCourse->tags->count() > 0)
                    <div class="rounded-lg tags-card shadow-lg mt-8 px-4 py-20">
                        <h3 class="sidebar-title font-16 text-black font-bold">{{ trans('public.tags') }}</h3>

                        <div class="flex flex-wrap mt-10">
                            @foreach($upcomingCourse->tags as $tag)
                                <a href="" class="tag-item bg-gray200 p-5 text-sm text-slate-500 font-medium rounded">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ads --}}
                @if(!empty($advertisingBannersSidebar) and count($advertisingBannersSidebar))
                    <div class="row">
                        @foreach($advertisingBannersSidebar as $sidebarBanner)
                            <div class="rounded-lg sidebar-ads mt-8 col-{{ $sidebarBanner->size }}">
                                <a href="{{ $sidebarBanner->link }}">
                                    <img src="{{ $sidebarBanner->image }}" class="img-cover rounded-lg" alt="{{ $sidebarBanner->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>

        {{-- Ads Bannaer --}}
        @if(!empty($advertisingBanners) and count($advertisingBanners))
            <div class="mt-6 mt-md-50">
                <div class="row">
                    @foreach($advertisingBanners as $banner)
                        <div class="col-{{ $banner->size }}">
                            <a href="{{ $banner->link }}">
                                <img src="{{ $banner->image }}" class="img-cover rounded-sm" alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- ./ Ads Bannaer --}}
    </section>

    <div id="webinarReportModal" class="hidden">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('product.report_the_course') }}</h3>

        <form action="/upcoming_courses/{{ $upcomingCourse->id }}/report" method="post" class="mt-25">

            <div class="form-group">
                <label class="text-dark-blue text-sm">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="form-control">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach(getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label class="text-dark-blue text-sm" for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="form-control" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-slate-500 font-16">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-6 flex items-center justify-end">
                <button type="button" class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>

    @include('web.jiujitsu.course.share_modal',['course' => $upcomingCourse])
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var reportFailLang = '{{ trans('panel.report_fail') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var copyLang = '{{ trans('public.copy') }}';
        var copiedLang = '{{ trans('public.copied') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/upcoming_course_show.min.js"></script>
@endpush
