@php
    $userLanguages = !empty($generalSettings['site_language']) ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])] : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }

@endphp

<div class="top-navbar flex border-bottom">
    <div class="container flex justify-between flex-col flex-lg-row">
        <div class="top-contact-box border-bottom flex flex-col flex-md-row items-center justify-center">

            @if(getOthersPersonalizationSettings('platform_phone_and_email_position') == 'header')
                <div class="flex items-center justify-center mr-15 mr-md-30">
                    @if(!empty($generalSettings['site_phone']))
                        <div class="flex items-center py-10 py-lg-0 text-dark-blue text-sm">
                            <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_phone'] }}
                        </div>
                    @endif

                    @if(!empty($generalSettings['site_email']))
                        <div class="border-left mx-5 mx-lg-15 h-100"></div>

                        <div class="flex items-center py-10 py-lg-0 text-dark-blue text-sm">
                            <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_email'] }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex items-center justify-between justify-content-md-center">

                {{-- Currency --}}
                @include('web.jiujitsu.includes.top_nav.currency')


                @if(!empty($localLanguage) and count($localLanguage) > 1)
                    <form action="/locale" method="post" class="mr-15 mx-md-20">
                        {{ csrf_field() }}

                        <input type="hidden" name="locale">

                        @if(!empty($previousUrl))
                            <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
                        @endif

                        <div class="language-select">
                            <div id="localItems"
                                 data-selected-country="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) }}"
                                 data-countries='{{ json_encode($localLanguage) }}'
                            ></div>
                        </div>
                    </form>
                @else
                    <div class="mr-15 mx-md-20"></div>
                @endif


                <form action="/search" method="get" class="form-inline my-2 my-lg-0 navbar-search relative">
                    <input class="form-control mr-5 rounded" type="text" name="search" placeholder="{{ trans('navbar.search_anything') }}" aria-label="Search">

                    <button type="submit" class="btn-ghost flex items-center justify-center search-icon">
                        <i data-feather="search" width="20" height="20" class="mr-10"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="xs-w-full flex items-center justify-between ">
            <div class="flex">

                @include(getTemplate().'.includes.shopping-cart-dropdwon')

                <div class="border-left mx-5 mx-lg-15"></div>

                @include(getTemplate().'.includes.notification-dropdown')
            </div>

            {{-- User Menu --}}
            @include('web.jiujitsu.includes.top_nav.user_menu')
        </div>
    </div>
</div>


@push('scripts_bottom')
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
@endpush
