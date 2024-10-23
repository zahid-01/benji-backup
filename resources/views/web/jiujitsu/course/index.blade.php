@extends(getTemplate() . '.layouts.fullwidth')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')
    {{-- <section class="rounded-md overflow-hidden {{ empty($activeSpecialOffer) ? 'not-active-special-offer' : '' }}">
        <img src="{{ $course->getImageCover() }}" class="rounded-md w-full" alt="{{ $course->title }}" />

        <div class="cover-content pt-40">
            <div class="container relative">
                @if (!empty($activeSpecialOffer))
                    @include('web.jiujitsu.course.special_offer')
                @endif
            </div>
        </div>
    </section> --}}

    <div class="grid grid-cols-4 w-full gap-7">
        <div class="col-span-4 lg:col-span-3">
            @if ($course->video_demo)
                <div class="learning-content-video-player">
                    <div id="webinarDemoVideoPlayer" class="relative webinarDemoVideoPlayer video-js"
                        data-video-path="{{ $course->video_demo_source == 'upload' ? url($course->video_demo) : $course->video_demo }}"
                        data-video-source="{{ $course->video_demo_source }}">
                    </div>
                </div>
            @endif

            {{-- organization --}}
            {{-- @if ($course->creator_id != $course->teacher_id)
                @include('web.jiujitsu.course.youtube_instructor_profile', [
                    'courseTeacher' => $course->creator,
                ])
            @endif --}}

            <div class="mt-4 text-2xl font-medium">{{ $course->title }}</div>
            {{-- teacher --}}
            @include('web.jiujitsu.course.youtube_instructor_profile', [
                'courseTeacher' => $course->teacher,
            ])

            <div class="lg:hidden my-5">
                @include(getTemplate() . '.course.tabs.youtube_content')
            </div>

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

            {{-- <div id="course-content">
                <div class="tabs bg-black text-white">
                    <a class="change-tab active" data-target="content"
                        data-parent="course-content">{{ trans('product.content') }}</a>
                    <a class="change-tab" data-target="reviews"
                        data-parent="course-content">{{ trans('product.reviews') }}</a>
                </div>

                <div class="tab-content" data-tabcontent="course">
                    <div class="content {{ request()->get('tab', '') == 'content' ? 'show active' : '' }}" id="content"
                        role="tabpanel" aria-labelledby="content-tab">
                        @include(getTemplate() . '.course.tabs.content')
                    </div>
                    <div class="content hidden {{ request()->get('tab', '') == 'reviews' ? 'show active' : '' }}"
                        id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="col-span-4 lg:col-span-1">
            {{-- <img src="{{ $course->getImageCover() }}" class="rounded-md w-full" alt="{{ $course->title }}" /> --}}
            <div class="hidden lg:inline-block">
                @include(getTemplate() . '.course.tabs.youtube_content')
            </div>

            <div class="shadow-lg rounded-xl overflow-hidden mt-7">
                {{-- <img src="{{ $course->getImage() }}" class="img-cover" alt=""> --}}
                {{-- @if ($course->video_demo)
                        <div id="webinarDemoVideoBtn"
                            data-video-path="{{ $course->video_demo_source == 'upload' ? url($course->video_demo) : $course->video_demo }}"
                            data-video-source="{{ $course->video_demo_source }}"
                            class="course-video-icon cursor-pointer flex items-center justify-center">
                            <i data-feather="play" width="25" height="25"></i>
                        </div>
                    @endif --}}
                <div class="m-5">
                    <form action="/cart/store" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $course->id }}">
                        <input type="hidden" name="item_name" value="webinar_id">

                        @if (!empty($course->tickets))
                            @foreach ($course->tickets as $ticket)
                                <div class="form-check mt-4">
                                    <input class="form-check-input" @if (!$ticket->isValid()) disabled @endif
                                        type="radio"
                                        data-discount-price="{{ handlePrice($ticket->getPriceWithDiscount($course->price, !empty($activeSpecialOffer) ? $activeSpecialOffer : null)) }}"
                                        value="{{ $ticket->isValid() ? $ticket->id : '' }}" name="ticket_id"
                                        id="courseOff{{ $ticket->id }}">
                                    <label class="form-check-label flex flex-col cursor-pointer"
                                        for="courseOff{{ $ticket->id }}">
                                        <span class="font-16 font-medium text-dark-blue">{{ $ticket->title }}
                                            @if (!empty($ticket->discount))
                                                ({{ $ticket->discount }}% {{ trans('public.off') }})
                                            @endif
                                        </span>
                                        <span class="text-sm text-slate-500">{{ $ticket->getSubTitle() }}</span>
                                    </label>
                                </div>
                            @endforeach
                        @endif

                        @if ($course->price > 0)
                            <div id="priceBox"
                                class="flex items-center justify-center mt-4 {{ !empty($activeSpecialOffer) ? ' flex-col ' : '' }}">
                                <div class="text-center">
                                    @php
                                        $realPrice = handleCoursePagePrice($course->price);
                                    @endphp
                                    <span id="realPrice" data-value="{{ $course->price }}"
                                        data-special-offer="{{ !empty($activeSpecialOffer) ? $activeSpecialOffer->percent : '' }}"
                                        class="block @if (!empty($activeSpecialOffer)) line-through @else text-3xl font-semibold text-primary @endif">
                                        {{ $realPrice['price'] }}
                                    </span>

                                    @if (!empty($realPrice['tax']) and empty($activeSpecialOffer))
                                        <span class="block text-sm text-slate-500">+ {{ $realPrice['tax'] }}
                                            {{ trans('cart.tax') }}</span>
                                    @endif
                                </div>

                                @if (!empty($activeSpecialOffer))
                                    <div class="text-center">
                                        @php
                                            $priceWithDiscount = handleCoursePagePrice($course->getPrice());
                                        @endphp
                                        <span id="priceWithDiscount" class="block text-3xl text-primary">
                                            {{ $priceWithDiscount['price'] }}
                                        </span>

                                        @if (!empty($priceWithDiscount['tax']))
                                            <span class="block text-sm text-slate-500">+
                                                {{ $priceWithDiscount['tax'] }}
                                                {{ trans('cart.tax') }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="flex items-center justify-center">
                                <span class="text-4xl font-semibold text-primary">{{ trans('public.free') }}</span>
                            </div>
                        @endif

                        @php
                            $canSale = ($course->canSale() and !$hasBought);
                        @endphp

                        <div class="mt-6 flex flex-col">
                            @if (!$canSale and $course->canJoinToWaitlist())
                                <button type="button" data-slug="{{ $course->slug }}"
                                    class="btn btn-primary {{ !empty($authUser) ? 'js-join-waitlist-user' : 'js-join-waitlist-guest' }}">{{ trans('update.join_waitlist') }}</button>
                            @elseif($hasBought or !empty($course->getInstallmentOrder()))
                                <a href="{{ $course->getLearningPageUrl() }}"
                                    class="btn btn-primary">{{ trans('update.go_to_learning_page') }}</a>
                            @elseif($course->price > 0)
                                <button type="button"
                                    class="btn btn-primary {{ $canSale ? 'js-course-add-to-cart-btn' : $course->cantSaleStatus($hasBought) . ' disabled ' }}">
                                    @if (!$canSale)
                                        {{ trans('update.disabled_add_to_cart') }}
                                    @else
                                        {{ trans('public.add_to_cart') }}
                                    @endif
                                </button>

                                @if ($canSale and $course->subscribe)
                                    <a href="/subscribes/apply/{{ $course->slug }}"
                                        class="btn btn-outline-primary btn-subscribe mt-4 @if (!$canSale) disabled @endif">{{ trans('public.subscribe') }}</a>
                                @endif

                                @if ($canSale and !empty($course->points))
                                    <a href="{{ !auth()->check() ? '/login' : '#' }}"
                                        class="{{ auth()->check() ? 'js-buy-with-point' : '' }} btn btn-outline-warning mt-4 {{ !$canSale ? 'disabled' : '' }}"
                                        rel="nofollow">
                                        {!! trans('update.buy_with_n_points', ['points' => $course->points]) !!}
                                    </a>
                                @endif

                                @if ($canSale and !empty(getFeaturesSettings('direct_classes_payment_button_status')))
                                    <button type="button" class="btn btn-outline btn-error mt-4 js-course-direct-payment">
                                        {{ trans('update.buy_now') }}
                                    </button>
                                @endif

                                @if (!empty($installments) and count($installments) and getInstallmentsSettings('display_installment_button'))
                                    <a href="/course/{{ $course->slug }}/installments"
                                        class="btn btn-outline-primary mt-4">
                                        {{ trans('update.pay_with_installments') }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ $canSale ? '/course/' . $course->slug . '/free' : '#' }}"
                                    class="btn btn-primary {{ !$canSale ? ' disabled ' . $course->cantSaleStatus($hasBought) : '' }}">{{ trans('public.enroll_on_webinar') }}</a>
                            @endif
                        </div>

                    </form>

                    @if (
                        !empty(getOthersPersonalizationSettings('show_guarantee_text')) and
                            getOthersPersonalizationSettings('show_guarantee_text'))
                        <div class="mt-8 flex items-center justify-center text-slate-500">
                            <i data-feather="thumbs-up" width="20" height="20"></i>
                            <span class="ml-2 text-sm">{{ getOthersPersonalizationSettings('guarantee_text') }}</span>
                        </div>
                    @endif

                    <div class="mt-10">
                        <strong
                            class="block text-black font-bold">{{ trans('webinars.this_webinar_includes', ['classes' => trans('webinars.' . $course->type)]) }}</strong>
                        @if ($course->isDownloadable())
                            <div class="mt-4 flex items-center text-slate-500">
                                <i data-feather="download-cloud" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('webinars.downloadable_content') }}</span>
                            </div>
                        @endif

                        @if ($course->certificate or $course->quizzes->where('certificate', 1)->count() > 0)
                            <div class="mt-4 flex items-center text-slate-500">
                                <i data-feather="award" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('webinars.official_certificate') }}</span>
                            </div>
                        @endif

                        @if ($course->quizzes->where('status', \App\models\Quiz::ACTIVE)->count() > 0)
                            <div class="mt-4 flex items-center text-slate-500">
                                <i data-feather="file-text" width="20" height="20"></i>
                                <span
                                    class="ml-2 text-sm font-medium">{{ trans('webinars.online_quizzes_count', ['quiz_count' => $course->quizzes->where('status', \App\models\Quiz::ACTIVE)->count()]) }}</span>
                            </div>
                        @endif

                        @if ($course->support)
                            <div class="mt-4 flex items-center text-slate-500">
                                <i data-feather="headphones" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('webinars.instructor_support') }}</span>
                            </div>
                        @endif
                    </div>

                    <div
                        class="mt-14 p-4 rounded-xl border border-slat-500 grid grid-flow-col items-center divide-x divide-slate-300">
                        @if ($course->isWebinar())
                            <div class="col">
                                <a href="{{ $course->addToCalendarLink() }}" target="_blank"
                                    class="flex flex-col items-center text-center text-slate-500">
                                    <i data-feather="calendar" width="20" height="20"></i>
                                    <span class="text-sm">{{ trans('public.reminder') }}</span>
                                </a>
                            </div>
                        @endif

                        <div class="col">
                            <a href="/favorites/{{ $course->slug }}/toggle" id="favoriteToggle"
                                class="flex flex-col items-center text-slate-500">
                                <i data-feather="heart" class="{{ !empty($isFavorite) ? 'text-red-600' : '' }}"
                                    width="20" height="20"></i>
                                <span class="text-sm">Whislist</span>
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
                        <button type="button" id="webinarReportBtn"
                            class="text-sm text-slate-500 link link-hover">{{ trans('webinars.report_this_webinar') }}</button>
                    </div>

                </div>
            </div>

            {{-- Cashback Alert --}}
            {{-- @include('web.jiujitsu.includes.cashback_alert', ['itemPrice' => $course->price]) --}}

            {{-- Gift Card --}}
            {{-- @if ($course->canSale() and !empty(getGiftsGeneralSettings('status')) and !empty(getGiftsGeneralSettings('allow_sending_gift_for_courses')))
                <a href="/gift/course/{{ $course->slug }}" class="flex items-center mt-6 rounded-lg border p-15">
                    <div class="size-40 flex-center rounded-full bg-gray200">
                        <i data-feather="gift" class="text-slate-500" width="20" height="20"></i>
                    </div>
                    <div class="ml-2">
                        <h4 class="text-sm font-bold text-slate-500">{{ trans('update.gift_this_course') }}
                        </h4>
                        <p class="text-sm text-slate-500">{{ trans('update.gift_this_course_hint') }}</p>
                    </div>
                </a>
            @endif --}}

            {{-- @if ($course->teacher->offline)
                <div class="rounded-lg shadow-lg mt-8 flex">
                    <div class="offline-icon offline-icon-left flex align-items-stretch">
                        <div class="flex items-center">
                            <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                        </div>
                    </div>

                    <div class="p-15">
                        <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                        <p class="text-sm font-medium text-slate-500 mt-15">{{ $course->teacher->offline_message }}
                        </p>
                    </div>
                </div>
            @endif --}}

            <div class="rounded-lg shadow-lg mt-8 px-6 py-8">
                <h3 class="sidebar-title text-black font-bold">
                    {{ trans('webinars.' . $course->type) . ' ' . trans('webinars.specifications') }}</h3>

                <div class="mt-6">
                    @if ($course->isWebinar())
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <i data-feather="calendar" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('public.start_date') }}:</span>
                            </div>
                            <span class="text-sm">{{ dateTimeFormat($course->start_date, 'j M Y | H:i') }}</span>
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between text-slate-500">
                        <div class="flex items-center">
                            <i data-feather="user" width="20" height="20"></i>
                            <span class="ml-2 text-sm font-medium">{{ trans('public.capacity') }}:</span>
                        </div>
                        @if (!is_null($course->capacity))
                            <span class="text-sm">{{ $course->capacity }} {{ trans('quiz.students') }}</span>
                        @else
                            <span class="text-sm">{{ trans('update.unlimited') }}</span>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center justify-between text-slate-500">
                        <div class="flex items-center">
                            <i data-feather="clock" width="20" height="20"></i>
                            <span class="ml-2 text-sm font-medium">{{ trans('public.duration') }}:</span>
                        </div>
                        <span
                            class="text-sm">{{ convertMinutesToHourAndMinute(!empty($course->duration) ? $course->duration : 0) }}
                            {{ trans('home.hours') }}</span>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-slate-500">
                        <div class="flex items-center">
                            <i data-feather="users" width="20" height="20"></i>
                            <span class="ml-2 text-sm font-medium">{{ trans('quiz.students') }}:</span>
                        </div>
                        <span class="text-sm">{{ $course->sales_count }}</span>
                    </div>

                    @if ($course->isWebinar())
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('public.sessions') }}:</span>
                            </div>
                            <span class="text-sm">{{ $course->sessions->count() }}</span>
                        </div>
                    @endif

                    @if ($course->isTextCourse())
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('webinars.text_lessons') }}:</span>
                            </div>
                            <span class="text-sm">{{ $course->textLessons->count() }}</span>
                        </div>
                    @endif

                    @if ($course->isCourse() or $course->isTextCourse())
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('public.files') }}:</span>
                            </div>
                            <span class="text-sm">{{ $course->files->count() }}</span>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('public.created_at') }}:</span>
                            </div>
                            <span class="text-sm">{{ dateTimeFormat($course->created_at, 'j M Y') }}</span>
                        </div>
                    @endif

                    @if (!empty($course->access_days))
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <i data-feather="alert-circle" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('update.access_period') }}:</span>
                            </div>
                            <span class="text-sm">{{ $course->access_days }} {{ trans('public.days') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- @if ($course->webinarPartnerTeacher->count() > 0)
                @foreach ($course->webinarPartnerTeacher as $webinarPartnerTeacher)
                    @include('web.jiujitsu.course.sidebar_instructor_profile', [
                        'courseTeacher' => $webinarPartnerTeacher->teacher,
                    ])
                @endforeach
            @endif --}}
            {{-- ./ teacher --}}

            {{-- tags --}}
            {{-- @if ($course->tags->count() > 0)
                <div class="rounded-lg tags-card shadow-lg mt-8 px-4 py-4">
                    <h3 class="sidebar-title font-16 text-black font-bold">{{ trans('public.tags') }}</h3>

                    <div class="flex flex-wrap mt-6 gap-3">
                        @foreach ($course->tags as $tag)
                            <a href=""
                                class="btn btn-sm text-sm text-slate-500 font-medium rounded">{{ $tag->title }}</a>
                        @endforeach
                    </div>
                </div>
            @endif --}}
            {{-- ads --}}
            {{-- @if (!empty($advertisingBannersSidebar) and count($advertisingBannersSidebar))
                <div class="row">
                    @foreach ($advertisingBannersSidebar as $sidebarBanner)
                        <div class="rounded-lg sidebar-ads mt-8 col-{{ $sidebarBanner->size }}">
                            <a href="{{ $sidebarBanner->link }}">
                                <img src="{{ $sidebarBanner->image }}" class="img-cover rounded-lg"
                                    alt="{{ $sidebarBanner->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif --}}

        </div>
    </div>

    <section
        class="grid grid-cols-4 gap-8 mt-4 {{ $course->type }} {{ ($hasBought or $course->isWebinar()) ? 'has-progress-bar' : '' }}">


        {{-- Ads Bannaer --}}
        {{-- @if (!empty($advertisingBanners) and count($advertisingBanners))
            <div class="mt-6 mt-md-50">
                <div class="row">
                    @foreach ($advertisingBanners as $banner)
                        <div class="col-{{ $banner->size }}">
                            <a href="{{ $banner->link }}">
                                <img src="{{ $banner->image }}" class="img-cover rounded-sm"
                                    alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif --}}
        {{-- ./ Ads Bannaer --}}
    </section>

    <div id="webinarReportModal" class="hidden text-left">
        <h3 class="text-lg font-bold">{{ trans('product.report_the_course') }}</h3>

        <form action="/course/{{ $course->id }}/report" method="post" class="mt-8">

            <div class="flex flex-col">
                <label class="text-dark-blue text-sm">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="select select-bordered w-full">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach (getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="flex flex-col mt-6">
                <label class="text-dark-blue text-sm"
                    for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="textarea textarea-bordered w-full" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-slate-500 mt-3 font-light">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-6 flex items-center justify-end">
                <button type="button"
                    class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button"
                    class="btn btn-sm bg-red-600 text-white ml-4 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>

    @include('web.jiujitsu.course.share_modal')
    @include('web.jiujitsu.course.buy_with_point_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
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
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var notLoginToastTitleLang = '{{ trans('public.not_login_toast_lang') }}';
        var notLoginToastMsgLang = '{{ trans('public.not_login_toast_msg_lang') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var canNotTryAgainQuizToastTitleLang = '{{ trans('public.can_not_try_again_quiz_toast_lang') }}';
        var canNotTryAgainQuizToastMsgLang = '{{ trans('public.can_not_try_again_quiz_toast_msg_lang') }}';
        var canNotDownloadCertificateToastTitleLang = '{{ trans('public.can_not_download_certificate_toast_lang') }}';
        var canNotDownloadCertificateToastMsgLang = '{{ trans('public.can_not_download_certificate_toast_msg_lang') }}';
        var sessionFinishedToastTitleLang = '{{ trans('public.session_finished_toast_title_lang') }}';
        var sessionFinishedToastMsgLang = '{{ trans('public.session_finished_toast_msg_lang') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var courseHasBoughtStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasBoughtStatusToastMsgLang = '{{ trans('site.you_bought_webinar') }}';
        var courseNotCapacityStatusToastTitleLang = '{{ trans('public.request_failed') }}';
        var courseNotCapacityStatusToastMsgLang = '{{ trans('cart.course_not_capacity') }}';
        var courseHasStartedStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasStartedStatusToastMsgLang = '{{ trans('update.class_has_started') }}';
        var joinCourseWaitlistLang = '{{ trans('update.join_course_waitlist') }}';
        var joinCourseWaitlistModalHintLang = "{{ trans('update.join_course_waitlist_modal_hint') }}";
        var joinLang = '{{ trans('footer.join') }}';
        var nameLang = '{{ trans('auth.name') }}';
        var emailLang = '{{ trans('auth.email') }}';
        var phoneLang = '{{ trans('public.phone') }}';
        var captchaLang = '{{ trans('site.captcha') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>

    {{-- Show demo video --}}
    <script>
        var webinarDemoVideoPlayer = $("#webinarDemoVideoPlayer");
        // var path = $(webinarDemoVideoPlayer).attr('data-video-path');
        // var source = $(webinarDemoVideoPlayer).attr('data-video-source');
        var path = "{{ $course->video_demo_source == 'upload' ? url($course->video_demo) : $course->video_demo }}";
        var source = "{{ $course->video_demo_source }}";
        var height = $(window).width() > 991 ? 480 : 264;
        var videoTagId = 'webinarDemoVideoPlayer';
        var _makeVideoPlayerHtml = makeVideoPlayerHtml(path, source, height, videoTagId),
            html = _makeVideoPlayerHtml.html,
            options = _makeVideoPlayerHtml.options;
        webinarDemoVideoPlayer.html(_makeVideoPlayerHtml.html);

        videojs(videoTagId, options)
    </script>

    @if (
        !empty($course->creator) and
            !empty($course->creator->getLiveChatJsCode()) and
            !empty(getFeaturesSettings('show_live_chat_widget')))
        <script>
            (function() {
                "use strict"

                {!! $course->creator->getLiveChatJsCode() !!}
            })(jQuery)
        </script>
    @endif
@endpush
