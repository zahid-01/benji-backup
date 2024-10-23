@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')
    <section class="course-cover-container {{ empty($activeSpecialOffer) ? 'not-active-special-offer' : '' }}">
        <img src="{{ $bundle->getImageCover() }}" class="img-cover course-cover-img" alt="{{ $bundle->title }}"/>

        <div class="cover-content pt-40">
            <div class="container relative">
                @if(!empty($activeSpecialOffer))
                    @include('web.jiujitsu.course.special_offer')
                @endif
            </div>
        </div>
    </section>

    <section class="container course-content-section {{ $bundle->type }}">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">
                    <div class="course-body-on-cover text-white">
                        <h1 class="text-3xl course-title">
                            {{ clean($bundle->title, 't') }}
                        </h1>
                        <span class="block font-16 mt-10">{{ trans('public.in') }} <a href="{{ $bundle->category->getUrl() }}" target="_blank" class="font-medium text-decoration-underline text-white">{{ $bundle->category->title }}</a></span>

                        <div class="flex items-center">
                            @include('web.jiujitsu.includes.webinar.rate',['rate' => $bundle->getRate()])
                            <span class="ml-10 mt-15 text-sm">({{ $bundle->reviews->pluck('creator_id')->count() }} {{ trans('public.ratings') }})</span>
                        </div>

                        <div class="mt-15">
                            <span class="text-sm">{{ trans('public.created_by') }}</span>
                            <a href="{{ $bundle->teacher->getProfileUrl() }}" target="_blank" class="text-decoration-underline text-white text-sm font-medium">{{ $bundle->teacher->full_name }}</a>
                        </div>
                    </div>

                    <div class="mt-4 pt-20  mt-md-40 pt-md-40">
                        <ul class="nav nav-tabs bg-secondary rounded-sm p-15 flex items-center justify-between" id="tabs-tab" role="tablist">
                            <li class="nav-item">
                                <a class="relative text-sm text-white {{ (empty(request()->get('tab','')) or request()->get('tab','') == 'information') ? 'active' : '' }}" id="information-tab"
                                   data-toggle="tab" href="#information" role="tab" aria-controls="information"
                                   aria-selected="true">{{ trans('product.information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="relative text-sm text-white {{ (request()->get('tab','') == 'content') ? 'active' : '' }}" id="content-tab" data-toggle="tab"
                                   href="#content" role="tab" aria-controls="content"
                                   aria-selected="false">{{ trans('product.content') }} ({{ $bundle->bundleWebinars->count() }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="relative text-sm text-white {{ (request()->get('tab','') == 'reviews') ? 'active' : '' }}" id="reviews-tab" data-toggle="tab"
                                   href="#reviews" role="tab" aria-controls="reviews"
                                   aria-selected="false">{{ trans('product.reviews') }} ({{ $bundle->reviews->count() > 0 ? $bundle->reviews->pluck('creator_id')->count() : 0 }})</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade {{ (empty(request()->get('tab','')) or request()->get('tab','') == 'information') ? 'show active' : '' }} " id="information" role="tabpanel"
                                 aria-labelledby="information-tab">
                                @include('web.jiujitsu.bundle.tabs.information')
                            </div>
                            <div class="tab-pane fade {{ (request()->get('tab','') == 'content') ? 'show active' : '' }}" id="content" role="tabpanel" aria-labelledby="content-tab">
                                @include('web.jiujitsu.bundle.tabs.content')
                            </div>
                            <div class="tab-pane fade {{ (request()->get('tab','') == 'reviews') ? 'show active' : '' }}" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                @include('web.jiujitsu.bundle.tabs.reviews')
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="course-content-sidebar col-12 col-lg-4 mt-25 mt-lg-0">
                <div class="rounded-lg shadow-lg">
                    <div class="course-img {{ $bundle->video_demo ? 'has-video' :'' }}">

                        <img src="{{ $bundle->getImage() }}" class="img-cover" alt="">

                        @if($bundle->video_demo)
                            <div id="webinarDemoVideoBtn"
                                 data-video-path="{{ $bundle->video_demo_source == 'upload' ?  url($bundle->video_demo) : $bundle->video_demo }}"
                                 data-video-source="{{ $bundle->video_demo_source }}"
                                 class="course-video-icon cursor-pointer flex items-center justify-center">
                                <i data-feather="play" width="25" height="25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="px-20 pb-30">
                        <form action="/cart/store" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="item_id" value="{{ $bundle->id }}">
                            <input type="hidden" name="item_name" value="bundle_id">

                            @if(!empty($bundle->tickets))
                                @foreach($bundle->tickets as $ticket)

                                    <div class="form-check mt-4">
                                        <input class="form-check-input" @if(!$ticket->isValid()) disabled @endif type="radio"
                                               data-discount="{{ $ticket->discount }}"
                                               data-currency
                                               value="{{ ($ticket->isValid()) ? $ticket->id : '' }}"
                                               name="ticket_id"
                                               id="courseOff{{ $ticket->id }}">
                                        <label class="form-check-label flex flex-col cursor-pointer" for="courseOff{{ $ticket->id }}">
                                            <span class="font-16 font-medium text-dark-blue">{{ $ticket->title }} @if(!empty($ticket->discount))
                                                    ({{ $ticket->discount }}% {{ trans('public.off') }})
                                                @endif</span>
                                            <span class="text-sm text-slate-500">{{ $ticket->getSubTitle() }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                            @if($bundle->price > 0)
                                <div id="priceBox" class="flex items-center justify-center mt-4 {{ !empty($activeSpecialOffer) ? ' flex-col ' : '' }}">
                                    <div class="text-center">
                                        @php
                                            $realPrice = handleCoursePagePrice($bundle->price);
                                        @endphp
                                        <span id="realPrice" data-value="{{ $bundle->price }}"
                                              data-special-offer="{{ !empty($activeSpecialOffer) ? $activeSpecialOffer->percent : ''}}"
                                              class="block @if(!empty($activeSpecialOffer)) font-16 text-slate-500 line-through @else text-3xl text-primary @endif">
                                            {{ $realPrice['price'] }}
                                        </span>

                                        @if(!empty($realPrice['tax']) and empty($activeSpecialOffer))
                                            <span class="block text-sm text-slate-500">+ {{ $realPrice['tax'] }} tax</span>
                                        @endif
                                    </div>

                                    @if(!empty($activeSpecialOffer))
                                        <div class="text-center">
                                            @php
                                                $priceWithDiscount = handleCoursePagePrice($bundle->getPrice());
                                            @endphp
                                            <span id="priceWithDiscount"
                                                  class="block text-3xl text-primary">
                                                {{ $priceWithDiscount['price'] }}
                                            </span>

                                            @if(!empty($priceWithDiscount['tax']))
                                                <span class="block text-sm text-slate-500">+ {{ $priceWithDiscount['tax'] }} tax</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center justify-center mt-4">
                                    <span class="font-36 text-primary">{{ trans('public.free') }}</span>
                                </div>
                            @endif

                            @php
                                $canSale = ($bundle->canSale() and !$hasBought);
                            @endphp

                            <div class="mt-4 flex flex-col">
                                @if($hasBought or !empty($bundle->getInstallmentOrder()))
                                    <button type="button" class="btn btn-primary" disabled>{{ trans('panel.purchased') }}</button>
                                @elseif($bundle->price > 0)
                                    <button type="{{ $canSale ? 'submit' : 'button' }}" @if(!$canSale) disabled @endif class="btn btn-primary">
                                        @if(!$canSale)
                                            {{ trans('update.disabled_add_to_cart') }}
                                        @else
                                            {{ trans('public.add_to_cart') }}
                                        @endif
                                    </button>

                                    @if($canSale and $bundle->subscribe)
                                        <a href="/subscribes/apply/bundle/{{ $bundle->slug }}" class="btn btn-outline-primary btn-subscribe mt-4 @if(!$canSale) disabled @endif">{{ trans('public.subscribe') }}</a>
                                    @endif

                                    @if($canSale and !empty($bundle->points))
                                        <a href="{{ !(auth()->check()) ? '/login' : '#' }}" class="{{ (auth()->check()) ? 'js-buy-with-point' : '' }} btn btn-outline-warning mt-4 {{ (!$canSale) ? 'disabled' : '' }}" rel="nofollow">
                                            {!! trans('update.buy_with_n_points',['points' => $bundle->points]) !!}
                                        </a>
                                    @endif

                                    @if($canSale and !empty(getFeaturesSettings('direct_bundles_payment_button_status')))
                                        <button type="button" class="btn btn-outline-danger mt-4 js-bundle-direct-payment">
                                            {{ trans('update.buy_now') }}
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ $canSale ? '/bundles/'. $bundle->slug .'/free' : '#' }}" class="btn btn-primary @if(!$canSale) disabled @endif">{{ trans('update.enroll_on_bundle') }}</a>
                                @endif
                            </div>

                        </form>

                        @if(!empty(getOthersPersonalizationSettings('show_guarantee_text')) and getOthersPersonalizationSettings('show_guarantee_text'))
                            <div class="mt-4 flex items-center justify-center text-slate-500">
                                <i data-feather="thumbs-up" width="20" height="20"></i>
                                <span class="ml-2 text-sm">{{ getOthersPersonalizationSettings('guarantee_text') }}</span>
                            </div>
                        @endif

                        <div class="mt-14 p-10 rounded-sm border row items-center favorites-share-box">

                            <div class="col">
                                <a href="/bundles/{{ $bundle->slug }}/favorite" id="favoriteToggle" class="flex flex-col items-center text-slate-500">
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
                    </div>
                </div>

                {{-- Cashback Alert --}}
                @include('web.jiujitsu.includes.cashback_alert',['itemPrice' => $bundle->price])

                {{-- Gift Card --}}
                @if($bundle->canSale() and !empty(getGiftsGeneralSettings('status')) and !empty(getGiftsGeneralSettings('allow_sending_gift_for_bundles')))
                    <a href="/gift/bundle/{{ $bundle->slug }}" class="flex items-center mt-6 rounded-lg border p-15">
                        <div class="size-40 flex-center rounded-full bg-gray200">
                            <i data-feather="gift" class="text-slate-500" width="20" height="20"></i>
                        </div>
                        <div class="ml-2">
                            <h4 class="text-sm font-bold text-slate-500">{{ trans('update.gift_this_bundle') }}</h4>
                            <p class="text-sm text-slate-500">{{ trans('update.gift_this_bundle_hint') }}</p>
                        </div>
                    </a>
                @endif

                @if($bundle->teacher->offline)
                    <div class="rounded-lg shadow-lg mt-8 flex">
                        <div class="offline-icon offline-icon-left flex align-items-stretch">
                            <div class="flex items-center">
                                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                            </div>
                        </div>

                        <div class="p-15">
                            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                            <p class="text-sm font-medium text-slate-500 mt-15">{{ $bundle->teacher->offline_message }}</p>
                        </div>
                    </div>
                @endif

                <div class="rounded-lg shadow-lg mt-8 px-4 py-20">
                    <h3 class="sidebar-title font-16 text-black font-bold">{{ trans('update.bundle_specifications') }}</h3>

                    <div class="mt-6">
                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <i data-feather="clock" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('public.duration') }}:</span>
                            </div>
                            <span class="text-sm">{{ convertMinutesToHourAndMinute($bundle->getBundleDuration()) }} {{ trans('home.hours') }}</span>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <i data-feather="users" width="20" height="20"></i>
                                <span class="ml-2 text-sm font-medium">{{ trans('quiz.students') }}:</span>
                            </div>
                            <span class="text-sm">{{ $bundle->sales_count }}</span>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('product.courses') }}:</span>
                            </div>
                            <span class="text-sm">{{ $bundle->bundleWebinars->count() }}</span>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-slate-500">
                            <div class="flex items-center">
                                <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                <span class="ml-2 text-sm font-medium">{{ trans('public.created_at') }}:</span>
                            </div>
                            <span class="text-sm">{{ dateTimeFormat($bundle->created_at,'j M Y') }}</span>
                        </div>

                        @if(!empty($bundle->access_days))
                            <div class="mt-4 flex items-center justify-between text-slate-500">
                                <div class="flex items-center">
                                    <i data-feather="alert-circle" width="20" height="20"></i>
                                    <span class="ml-2 text-sm font-medium">{{ trans('update.access_period') }}:</span>
                                </div>
                                <span class="text-sm">{{ $bundle->access_days }} {{ trans('public.days') }}</span>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- organization --}}
                @if($bundle->creator_id != $bundle->teacher_id)
                    @include('web.jiujitsu.course.sidebar_instructor_profile', ['courseTeacher' => $bundle->creator])
                @endif
                {{-- teacher --}}
                @include('web.jiujitsu.course.sidebar_instructor_profile', ['courseTeacher' => $bundle->teacher])
                {{-- ./ teacher --}}

                {{-- tags --}}
                @if($bundle->tags->count() > 0)
                    <div class="rounded-lg tags-card shadow-lg mt-8 px-4 py-20">
                        <h3 class="sidebar-title font-16 text-black font-bold">{{ trans('public.tags') }}</h3>

                        <div class="flex flex-wrap mt-10">
                            @foreach($bundle->tags as $tag)
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

    @include('web.jiujitsu.bundle.share_modal')
    @include('web.jiujitsu.bundle.buy_with_point_modal')
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

    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>
@endpush
