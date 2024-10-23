@extends('web.jiujitsu.layouts.app')

@section('content')
    <section class="site-top-banner search-top-banner opacity-04 relative">
        <img src="{{ getPageBackgroundSettings('products_lists') }}" class="img-cover" alt=""/>

        <div class="container h-100">
            <div class="row h-100 items-center justify-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="top-search-categories-form">
                        <h1 class="text-white text-3xl mb-15">{{ trans('update.products') }}</h1>
                        <span class="course-count-badge py-5 px-10 text-white rounded">{{ $productsCount }} {{ trans('update.products') }}</span>

                        <div class="search-input bg-white p-10 grow">
                            <form action="{{ (!empty($isRewardProducts) and $isRewardProducts) ? '/reward-products' : '/products' }}" method="get">
                                <div class="form-group flex items-center m-0">
                                    <input type="text" name="search" class="form-control border-0" value="{{ request()->get('search') }}" placeholder="{{ trans('update.products_search_placeholder') }}"/>
                                    <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-6">
        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
            <form action="{{ (!empty($isRewardProducts) and $isRewardProducts) ? '/reward-products' : '/products' }}" method="get" id="filtersForm">

                @include('web.jiujitsu.products.includes.top_filters')

                <div class="row">
                    <div class="col-12 col-md-9">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-12 col-md-6 col-lg-4 mt-4">
                                    @include('web.jiujitsu.products.includes.card')
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-12 col-md-3">
                        @include('web.jiujitsu.products.includes.right_filters')
                    </div>
                </div>

            </form>

            <div class="mt-50 pt-30">
                {{ $products->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/products_lists.min.js"></script>
@endpush
