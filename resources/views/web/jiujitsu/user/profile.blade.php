@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/persian-datepicker/persian-datepicker.min.css" />
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
@endpush


@section('content')
    <section class="site-top-banner relative rounded-lg max-h-60 overflow-hidden">
        <img src="{{ $user->getCover() }}" class="img-cover rounded-lg" alt=""  />
    </section>


    <section class="container">
        <div class="rounded-lg px-4 py-10 px-lg-50 relative user-profile-info bg-white">
            <div class="profile-info-box flex align-items-start justify-between">
                <div class="user-details flex items-center">
                    <div class="user-profile-avatar bg-gray200 relative">
                        <img src="{{ $user->getAvatar(190) }}" class="w-18 h-18 rounded-full"
                            alt="{{ $user['full_name'] }}" />

                        @if ($user->offline)
                            <span class="user-circle-badge unavailable flex items-center justify-center">
                                <i data-feather="slash" width="20" height="20" class="text-white"></i>
                            </span>
                        @elseif($user->verified)
                            <span class="user-circle-badge has-verified flex items-center justify-center">
                                <i data-feather="check" width="20" height="20"
                                    class="absolute bg-primary text-white rounded-full right-5 bottom-1 p-1"></i>
                            </span>
                        @endif
                    </div>
                    <div class="ml-4 lg:ml-10">
                        <h1 class="font-24 font-bold text-dark-blue">{{ $user['full_name'] }}</h1>
                        <span class="text-slate-500">{{ $user['headline'] }}</span>

                        <div class="stars-card flex items-center mt-1">
                            @include('web.jiujitsu.includes.webinar.rate', ['rate' => $userRates])
                        </div>
                        <?php
                        $aboutContent = (!empty($user) && empty($new_user)) ? $user->about : old('about');
                        $firstLine = strtok($aboutContent, "\n"); // Get the first line of the content
                        ?>
                        
                        <div class="w-full">
                            <div class="flex items-center mt-1 cursor-pointer w-full overflow-hidden" id="popupTrigger">
                                <span>
                                    {!! nl2br(e($firstLine)) !!} <!-- Display the first line, preserving line breaks -->
                                </span>
                            </div>
                        
                            <div x-show="isOpen" @click.away="isOpen = false" class="fixed inset-0 flex items-center justify-center">
                                <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
                                {{-- <div class="bg-white p-6 rounded-lg z-10" style="width: 500px; height: 500px;">
                                    <div class="relative">
                                        <span>{!! nl2br(e($aboutContent)) !!}</span>
                                        <button class="absolute top-end right-end m-0 p-2 bg-blue-500 text-red-600 rounded hover:bg-blue-700" id="closeModal">Close</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        
                       
                        
                        <div class="w-full mt-2 flex items-center">
                            <div class="flex flex-col followers-status">
                                <span class="font-20 font-bold text-dark-blue">{{ $userFollowers->count() }}</span>
                                <span class="text-sm text-slate-500">{{ trans('panel.followers') }}</span>
                            </div>

                            <div class="flex flex-col ml-25 pl-5 following-status">
                                <span class="font-20 font-bold text-dark-blue">{{ $userFollowing->count() }}</span>
                                <span class="text-sm text-slate-500">{{ trans('panel.following') }}</span>
                            </div>

                            <div class="flex flex-col ml-25 pl-5 following-status">
                                <span class="font-20 font-bold text-dark-blue">{{ $user->students_count }}</span>
                                <span class="text-sm text-slate-500">{{ trans('quiz.students') }}</span>
                            </div>

                            <div class="flex flex-col ml-25 pl-5 following-status">
                                <span class="font-20 font-bold text-dark-blue">{{ count($webinars) }}</span>
                                <span class="text-sm text-slate-500">{{ trans('webinars.classes') }}</span>
                            </div>
                        </div>

                        <div class="user-reward-badges flex flex-wrap items-center mt-4 gap-3">
                            @if (!empty($userBadges))
                                @foreach ($userBadges as $userBadge)
                                    <div class="mr-15 tooltip" data-toggle="tooltip" data-placement="bottom"
                                        data-html="true" data-tip="{!! !empty($userBadge->badge_id) ? nl2br($userBadge->badge->description) : nl2br($userBadge->description) !!}">
                                        <img src="{{ !empty($userBadge->badge_id) ? $userBadge->badge->image : $userBadge->image }}"
                                            width="32" height="32"
                                            alt="{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="user-actions flex flex-col">
                    <button type="button" id="followToggle" data-user-id="{{ $user['id'] }}"
                        class="btn btn-{{ (!empty($authUserIsFollower) and $authUserIsFollower) ? 'danger' : 'primary' }} btn-sm">
                        @if (!empty($authUserIsFollower) and $authUserIsFollower)
                            {{ trans('panel.unfollow') }}
                        @else
                            {{ trans('panel.follow') }}
                        @endif
                    </button>

                    @if ($user->public_message)
                        <button type="button"
                            class="js-send-message btn btn-border-white rounded btn-sm mt-15">{{ trans('site.send_message') }}</button>
                    @endif
                </div>
            </div>

            {{-- <div class="mt-14 border-top"></div>

            <div class="row mt-6 w-full flex items-center justify-around">
                <div class="col-6 col-md-3 user-profile-state flex flex-col items-center">
                    <div class="state-icon orange p-15 rounded-lg">
                        <img src="/assets/default/img/profile/students.svg" alt="">
                    </div>
                    <span class="font-20 text-dark-blue font-bold mt-5">{{ $user->students_count }}</span>
                    <span class="text-sm text-slate-500">{{ trans('quiz.students') }}</span>
                </div>

                <div class="col-6 col-md-3 user-profile-state flex flex-col items-center">
                    <div class="state-icon blue p-15 rounded-lg">
                        <img src="/assets/default/img/profile/webinars.svg" alt="">
                    </div>
                    <span class="font-20 text-dark-blue font-bold mt-5">{{ count($webinars) }}</span>
                    <span class="text-sm text-slate-500">{{  }}</span>
                </div>

                <div class="col-6 col-md-3 mt-4 mt-md-0 user-profile-state flex flex-col items-center">
                    <div class="state-icon green p-15 rounded-lg">
                        <img src="/assets/default/img/profile/reviews.svg" alt="">
                    </div>
                    <span class="font-20 text-dark-blue font-bold mt-5">{{ $user->reviewsCount() }}</span>
                    <span class="text-sm text-slate-500">{{ trans('product.reviews') }}</span>
                </div>


                <div class="col-6 col-md-3 mt-4 mt-md-0 user-profile-state flex flex-col items-center">
                    <div class="state-icon royalblue p-15 rounded-lg">
                        <img src="/assets/default/img/profile/appointments.svg" alt="">
                    </div>
                    <span class="font-20 text-dark-blue font-bold mt-5">{{ $appointments }}</span>
                    <span class="text-sm text-slate-500">{{ trans('site.appointments') }}</span>
                </div>

            </div> --}}
        </div>
    </section>

    <div class="container mt-6">
        <section class="px-10 mb-20 pt-5 relative" id="profile_tabs">
            <ul class="flex items-center tabs border-b border-slate-300" id="tabs-tab" role="tablist">

                <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="classes" data-parent="profile_tabs">
                    <a class="relative text-dark-blue font-medium font-16 {{ (empty(request()->get('tab')) or request()->get('tab') == 'webinars') ? 'active' : '' }}"
                        id="webinars-tab" data-toggle="tab" href="#webinars" role="tab" aria-controls="webinars"
                        aria-selected="false">{{ trans('panel.classes') }}</a>
                </li>

                <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="about" data-parent="profile_tabs">
                    <a class="relative text-dark-blue font-medium font-16 {{ (request()->get('tab') == 'about') ? 'active' : '' }}"
                        id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about"
                        aria-selected="true">{{ trans('site.about') }}</a>
                </li>
               

                {{-- @if ($user->isOrganization())
                    <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="instructors" data-parent="profile_tabs">
                        <a class="relative text-dark-blue font-medium font-16 {{ request()->get('tab') == 'instructors' ? 'active' : '' }}"
                            id="instructors-tab" data-toggle="tab" href="#instructors" role="tab"
                            aria-controls="instructors" aria-selected="false">{{ trans('home.instructors') }}</a>
                    </li>
                @endif --}}

                {{-- @if (!empty(getStoreSettings('status')) and getStoreSettings('status'))
                    <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="products" data-parent="profile_tabs">
                        <a class="relative text-dark-blue font-medium font-16 {{ request()->get('tab') == 'products' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#products" role="tab"
                            aria-controls="products" aria-selected="false">{{ trans('update.products') }}</a>
                    </li>
                @endif --}}

                {{-- <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="articles" data-parent="profile_tabs">
                    <a class="relative text-dark-blue font-medium font-16 {{ (request()->get('tab') == 'posts') ? 'active' : ''  }}" id="webinars-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">{{ trans('update.articles') }}</a>
                </li> --}}

                {{-- @if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status'))
                    <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="forum" data-parent="profile_tabs">
                        <a class="relative text-dark-blue font-medium font-16 {{ request()->get('tab') == 'forum' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#forum" role="tab" aria-controls="forum"
                            aria-selected="false">{{ trans('update.forum') }}</a>
                    </li>
                @endif --}}

                {{-- <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="badges" data-parent="profile_tabs">
                    <a class="relative text-dark-blue font-medium font-16 {{ request()->get('tab') == 'badges' ? 'active' : '' }}"
                        id="badges-tab" data-toggle="tab" href="#badges" role="tab" aria-controls="badges"
                        aria-selected="false">{{ trans('site.badges') }}</a>
                </li> --}}

                {{-- <li class="nav-item mr-20 mr-lg-50 change-tab" data-target="book_an_appointment" data-parent="profile_tabs">
                    <a class="relative text-dark-blue font-medium font-16 {{ (request()->get('tab') == 'appointments') ? 'active' : ''  }}" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="false">{{ trans('site.book_an_appointment') }}</a>
                </li> --}}
            </ul>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane content active" id="classes" role="tabpanel" aria-labelledby="webinars-tab">
                    @include('web.jiujitsu.user.profile_tabs.webinars')
                </div>

                <div class="tab-pane content hidden px-2 px-lg-50 {{ (empty(request()->get('tab')) or request()->get('tab') == 'about') ? 'show active' : '' }}"
                    id="about" role="tabpanel" aria-labelledby="about-tab">
                    @include('web.jiujitsu.user.profile_tabs.about')
                </div>

                

                {{-- @if ($user->isOrganization())
                    <div class="tab-pane content hidden" id="instructors" role="tabpanel"
                        aria-labelledby="instructors-tab">
                        @include('web.jiujitsu.user.profile_tabs.instructors')
                    </div>
                @endif --}}

                {{-- <div class="tab-pane content hidden" id="articles" role="tabpanel" aria-labelledby="posts-tab">
                    @include('web.jiujitsu.user.profile_tabs.posts')
                </div> --}}

                {{-- @if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status'))
                    <div class="tab-pane content hidden" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                        @include('web.jiujitsu.user.profile_tabs.forum')
                    </div>
                @endif --}}

                {{-- @if (!empty(getStoreSettings('status')) and getStoreSettings('status'))
                    <div class="tab-pane content hidden" id="products" role="tabpanel" aria-labelledby="products-tab">
                        @include('web.jiujitsu.user.profile_tabs.products')
                    </div>
                @endif --}}

                {{-- <div class="tab-pane content hidden" id="badges" role="tabpanel" aria-labelledby="badges-tab">
                    @include('web.jiujitsu.user.profile_tabs.badges')
                </div> --}}

                {{-- <div class="tab-pane content hidden {{ request()->get('tab') == 'appointments' ? 'show active' : '' }}"
                    id="book_an_appointment" role="tabpanel" aria-labelledby="appointments-tab">
                    @include('web.jiujitsu.user.profile_tabs.appointments')
                </div> --}}
            </div>
        </section>
    </div>

    @include('web.jiujitsu.user.send_message_modal')

@endsection

@push('scripts_bottom')
    <script>
        var unFollowLang = '{{ trans('panel.unfollow') }}';
        var followLang = '{{ trans('panel.follow') }}';
        var reservedLang = '{{ trans('meeting.reserved') }}';
        var availableDays = {{ json_encode($times) }};
        var messageSuccessSentLang = '{{ trans('site.message_success_sent') }}';
    </script>

    <script src="/assets/default/vendors/persian-datepicker/persian-date.js"></script>
    <script src="/assets/default/vendors/persian-datepicker/persian-datepicker.js"></script>

    <script src="/assets/default/js/parts/profile.min.js"></script>

    @if (!empty($user->live_chat_js_code) and !empty(getFeaturesSettings('show_live_chat_widget')))
        <script>
            (function() {
                "use strict"

                {!! $user->live_chat_js_code !!}
            })(jQuery)
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <script>
        var popupTrigger = document.getElementById('popupTrigger');
        var popupContent = document.getElementById('popupContent');
        var closeModalButton = document.getElementById('closeModal');
    
        popupTrigger.addEventListener('click', function () {
            popupContent.classList.toggle('hidden');
        });
    
        closeModalButton.addEventListener('click', function (e) {
            e.stopPropagation(); // Stop the click event from propagating
            popupContent.classList.add('hidden');
        });
    </script>
@endpush
