<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl = (in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages) or !empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1);
@endphp

<head>
    @include('web.jiujitsu.includes.metas')
    <title>
        {{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? ' | ' . $generalSettings['site_name'] : '' }}
    </title>
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    @vite('resources/css/app.css')
    @stack('styles_top')
    @stack('scripts_top')
    <style>
        {!! !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : '' !!} {!! getThemeFontsSettings() !!} {!! getThemeColorsSettings() !!}
    </style>
</head>

<body class="@if ($isRtl) rtl @endif">

    <div id="app"
        class="{{ (!empty($floatingBar) and $floatingBar->position == 'top' and $floatingBar->fixed) ? 'has-fixed-top-floating-bar px-3' : 'px-3' }}">

        @if (!isset($appHeader))
            @include('web.jiujitsu.includes.navbar')
        @endif

        @if (!empty($justMobileApp))
            @include('web.jiujitsu.includes.mobile_app_top_nav')
        @endif

        <div class="container mx-auto">
            <div class="w-full">
                @yield('content')
            </div>
        </div>

        {{-- @if (!isset($appFooter))
            @include('web.jiujitsu.includes.footer')
        @endif --}}

        {{-- @include('web.jiujitsu.includes.advertise_modal.index') --}}

        @if (!empty($floatingBar) and $floatingBar->position == 'bottom')
            {{-- @include('web.jiujitsu.includes.floating_bar') --}}
        @endif
    </div>
    <!-- Template JS File -->
    <script src="/assets/default/js/app.js"></script>
    <script src="/assets/jiujitsu/js/custom.js"></script>
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
    {{-- <script src="/assets/default/vendors/moment.min.js"></script> --}}
    {{-- <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script> --}}
    <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
    {{-- <script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script> --}}

    @if (empty($justMobileApp) and checkShowCookieSecurityDialog())
        {{-- @include('web.jiujitsu.includes.cookie-security') --}}
    @endif


    <script>
        var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
        var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
        var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
        var deleteAlertCancel = '{{ trans('public.cancel') }}';
        var deleteAlertSuccess = '{{ trans('public.success') }}';
        var deleteAlertFail = '{{ trans('public.fail') }}';
        var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
        var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
        var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
        var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
    </script>

    @if (session()->has('toast'))
        <script>
        (function () {
            "use strict";

            $.toast({
                heading: '{{ session()->get('toast')['title'] ?? '' }}',
                text: '{{ session()->get('toast')['msg'] ?? '' }}',
                bgColor: '@if (session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
                textColor: 'white',
                hideAfter: 10000,
                position: 'bottom-right',
                icon: '{{ session()->get('toast')['status'] }}'
            });
        })(jQuery)
    </script>
    @endif

    @stack('styles_bottom')
    @stack('scripts_bottom')

    <script src="/assets/default/js/parts/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session()->has('registration_package_limited'))
            (function() {
                "use strict";

                handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
            })(jQuery)

            {{ session()->forget('registration_package_limited') }}
        @endif

        {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}
    </script>
</body>

</html>
