@extends(getTemplate() . '.layouts.fullwidth')

@push('styles_top')
@endpush


@section('content')
    @if (
        !empty($webinars) and count($webinars) or
            !empty($products) and count($products) or
            !empty($teachers) and count($teachers) or
            !empty($organizations) and count($organizations))
        <section class="site-top-banner search-top-banner opacity-04 relative">
            {{-- <img src="{{ getPageBackgroundSettings('search') }}" class="img-cover" alt=""/> --}}

            <div class="container h-100">
                <div class="row h-100 items-center justify-center text-center">
                    <div class="col-12 col-md-9 col-lg-7">
                        <div class="top-search-form">
                            <h1 class="text-3xl white-space-pre-wrap font-semibold">
                                {{ trans('site.result_find', ['count' => $resultCount, 'search' => request()->get('search')]) }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section class="flex justify-between items-center my-4">
            <div>
                <div class="dropdown dropdown-bottom">
                    <label tabindex="0" class="btn m-1 bg-white border-black"><span class="mr-2">
                            <!-- Use the desired Tailwind icon classes -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </span>Filter</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Item 1</a></li>
                        <li><a>Item 2</a></li>
                    </ul>
                </div>
                <div class="dropdown dropdown-bottom">
                    <label tabindex="0" class="btn m-1 bg-white border-black flex items-center"> <svg class="w-4 h-4 mr-2"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18">
                            </path>
                        </svg></i>Sort</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>A To Z</a></li>
                        <li><a>Z To A</a></li>
                    </ul>
                </div>
            </div>
            <p class="font-semibold text-slate-400">1 Result</p>
        </section> --}}

        <div class="container mt-8">
            @if (!empty($webinars) and count($webinars))
                <section>
                    <div class="grid divide-y">
                        @foreach ($webinars as $webinar)
                            @php
                                // echo "<pre>";
                                // print_r($webinar);
                                // exit;
                            @endphp
                            @include(getTemplate() . '.includes.webinar.full-width-card', [
                                'webinar' => $webinar,
                                'class' => 'py-6'
                            ])
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- @if (!empty($products) and count($products))
                <section class="mt-50">
                    <h2 class="font-24 font-bold text-black">{{ trans('update.products') }}</h2>

                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-6 col-lg-4 mt-6">
                                @include('web.jiujitsu.products.includes.card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif --}}

            {{-- @if (!empty($teachers) and count($teachers))
                <section class="mt-50">
                    <h2 class="font-24 font-bold text-black">{{ trans('panel.users') }}</h2>

                    <div class="row">
                        @foreach ($teachers as $teacher)
                            <div class="col-6 col-md-3 col-lg-2 mt-6">
                                <div class="user-search-card text-center flex flex-col items-center justify-center">
                                    <div class="user-avatar">
                                        <img src="{{ $teacher->getAvatar() }}" class="img-cover rounded-full"
                                            alt="{{ $teacher->full_name }}">
                                    </div>
                                    <a href="{{ $teacher->getProfileUrl() }}">
                                        <h4 class="font-16 font-bold text-dark-blue mt-10">{{ $teacher->full_name }}</h4>
                                        <span class="block text-sm text-slate-500 mt-5">{{ $teacher->bio }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif --}}

            {{-- @if (!empty($organizations) and count($organizations))
                <section class="mt-50">
                    <h2 class="font-24 font-bold text-black">{{ trans('home.organizations') }}</h2>

                    <div class="row">

                        @foreach ($organizations as $organization)
                            <div class="col-md-6 col-lg-3 mt-6">
                                <a href="{{ $organization->getProfileUrl() }}"
                                    class="home-organizations-card flex flex-col items-center justify-center">
                                    <div class="home-organizations-avatar">
                                        <img src="{{ $organization->getAvatar() }}" class="img-cover rounded-full"
                                            alt="{{ $organization->full_name }}">
                                    </div>
                                    <div class="mt-25 flex flex-col items-center justify-center">
                                        <h3 class="home-organizations-title">{{ $organization->full_name }}</h3>
                                        <p class="home-organizations-desc mt-10">{{ $organization->bio }}</p>
                                        <span
                                            class="home-organizations-badge badge mt-15">{{ $organization->getActiveWebinars(true) }}
                                            {{ trans('product.courses') }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif --}}
        </div>
    @else
        <div class="no-result status-failed my-50 flex items-center justify-center flex-col">
            <div class="no-result-logo">
                <img src="/assets/default/img/no-results/search.png" alt="">
            </div>
            <div class="container">
                <div class="row h-100 items-center justify-center text-center">
                    <div class="col-12 col-md-9 col-lg-7">
                        <div class="flex items-center flex-col mt-6 text-center w-full">
                            <h2>{{ trans('site.no_result_search') }}</h2>
                            <p class="mt-5 text-center white-space-pre-wrap">
                                {{ trans('site.no_result_search_hint', ['search' => request()->get('search')]) }}</p>

                            <div class="search-input bg-white p-10 mt-4 grow shadow-lg rounded-pill w-full">
                                <form action="/search" method="get">
                                    <div class="form-group flex items-center m-0">
                                        <input type="text" name="search" class="form-control border-0"
                                            value="{{ request()->get('search', '') }}"
                                            placeholder="{{ trans('home.slider_search_placeholder') }}" />
                                        <button type="submit"
                                            class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
