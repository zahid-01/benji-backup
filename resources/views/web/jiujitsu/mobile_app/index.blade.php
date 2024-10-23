@extends('web.jiujitsu.layouts.app', ['appFooter' => false, 'appHeader' => false, 'justMobileApp' => true])

@php
    $mobileAppSettings = getMobileAppSettings();
@endphp

@section('content')
    <section class="mobile-app-section my-50 relative">
        <div class="container mobile-app-section__container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h1 class="font-36 text-black font-bold">{!! nl2br(trans('update.download_mobile_app_and_enjoy')) !!}</h1>
                    <p class="mt-15 text-sm text-slate-500">{!! $mobileAppSettings['mobile_app_description'] ?? '' !!}</p>

                    @if(!empty($mobileAppSettings) and !empty($mobileAppSettings['mobile_app_buttons']))
                        <div class="mt-4 flex items-center flex-wrap">
                            @foreach($mobileAppSettings['mobile_app_buttons'] as $mobileAppButton)
                                <a href="{{ $mobileAppButton['link'] ?? '' }}" target="_blank" class="rounded-pill mobile-app__buttons btn btn-{{ $mobileAppButton['color'] ?? '' }} {{ (!empty($mobileAppButton['icon'])) ? 'has-icon' : '' }}">
                                    @if(!empty($mobileAppButton['icon']))
                                        <span class="mobile-app__button-icon rounded-full mr-10">
                                        <img src="{{ $mobileAppButton['icon'] }}" class="img-cover rounded-full" alt="{{ $mobileAppButton['title'] ?? '' }}">
                                    </span>
                                    @endif

                                    <span class="">{{ $mobileAppButton['title'] ?? '' }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mobile-app-section__image flex items-center justify-center">

            <div class="bubble-one"></div>
            <div class="bubble-two"></div>
            <div class="bubble-three"></div>

            <div class="mobile-app-section__image-hero">
                <img src="/assets/default/img/home/dot.png" class="mobile-app-section__dots" alt="dots">

                @if(!empty($mobileAppSettings['mobile_app_hero_image']))
                    <img src="{{ $mobileAppSettings['mobile_app_hero_image'] }}" class="img-cover" alt="trans('update.download_mobile_app_and_enjoy')">
                @endif
            </div>
        </div>
    </section>

@endsection
