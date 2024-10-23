@extends(getTemplate() . '.layouts.app')

{{-- @push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
@endpush --}}

@section('content')
    <div class="w-full overflow-x-auto no-scrollbar relative h-12" id="scrollable-container">
        <div class="carousel-carousel flex absolute gap-4 top-0 left-0" id="scrollable-content">
            <div class="filter-courses active" data-tag="all_classes">
                All Courses
            </div>
            @foreach ($homeSections as $homeSection)
                @if (
                    $homeSection->name == \App\Models\HomeSection::$featured_classes and
                        !empty($featureWebinars) and
                        !$featureWebinars->isEmpty())
                    <div class="filter-courses" data-tag="featured_classes">
                        {{ trans('home.featured_classes') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$latest_bundles and
                        !empty($latestBundles) and
                        !$latestBundles->isEmpty())
                    <div class="filter-courses" data-tag="latest_bundles">
                        {{ trans('update.latest_bundles') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$upcoming_courses and
                        !empty($upcomingCourses) and
                        !$upcomingCourses->isEmpty())
                    <div class="filter-courses" data-tag="upcoming_courses">
                        {{ trans('update.upcoming_courses') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$latest_classes and
                        !empty($latestWebinars) and
                        !$latestWebinars->isEmpty())
                    <div class="filter-courses" data-tag="latest_classes">
                        {{ trans('home.latest_classes') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$best_rates and
                        !empty($bestRateWebinars) and
                        !$bestRateWebinars->isEmpty())
                    <div class="filter-courses" data-tag="best_rates">
                        {{ trans('home.best_rates') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$best_sellers and
                        !empty($bestSaleWebinars) and
                        !$bestSaleWebinars->isEmpty())
                    <div class="filter-courses" data-tag="best_sellers">
                        {{ trans('home.best_sellers') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$discount_classes and
                        !empty($hasDiscountWebinars) and
                        !$hasDiscountWebinars->isEmpty())
                    <div class="filter-courses" data-tag="discount_classes">
                        {{ trans('home.discount_classes') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$free_classes and
                        !empty($freeWebinars) and
                        !$freeWebinars->isEmpty())
                    <div class="filter-courses" data-tag="free_classes">
                        {{ trans('home.free_classes') }}
                    </div>
                @endif

                @if (
                    $homeSection->name == \App\Models\HomeSection::$store_products and
                        !empty($newProducts) and
                        !$newProducts->isEmpty())
                    <div class="filter-courses" data-tag="store_products">
                        {{ trans('update.store_products') }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-2 filter-tabs">
        @foreach ($homeSections as $homeSection)
            @if (
                $homeSection->name == \App\Models\HomeSection::$featured_classes and
                    !empty($featureWebinars) and
                    !$featureWebinars->isEmpty())
                @foreach ($featureWebinars as $feature)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $feature->webinar,
                        'class' => 'featured_classes all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$latest_bundles and
                    !empty($latestBundles) and
                    !$latestBundles->isEmpty())
                @foreach ($latestBundles as $latestBundle)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $latestBundle,
                        'class' => 'latest_bundles all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$upcoming_courses and
                    !empty($upcomingCourses) and
                    !$upcomingCourses->isEmpty())
                @foreach ($upcomingCourses as $upcomingCourse)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $upcomingCourse,
                        'class' => 'upcoming_courses all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$latest_classes and
                    !empty($latestWebinars) and
                    !$latestWebinars->isEmpty())
                @foreach ($latestWebinars as $latestWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $latestWebinar,
                        'class' => 'latest_classes all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$best_rates and
                    !empty($bestRateWebinars) and
                    !$bestRateWebinars->isEmpty())
                @foreach ($bestRateWebinars as $bestRateWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $bestRateWebinar,
                        'class' => 'best_rates all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$best_sellers and
                    !empty($bestSaleWebinars) and
                    !$bestSaleWebinars->isEmpty())
                @foreach ($bestSaleWebinars as $bestSaleWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $bestSaleWebinar,
                        'class' => 'best_sellers all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$discount_classes and
                    !empty($hasDiscountWebinars) and
                    !$hasDiscountWebinars->isEmpty())
                @foreach ($hasDiscountWebinars as $hasDiscountWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $hasDiscountWebinar,
                        'class' => 'discount_classes all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$free_classes and
                    !empty($freeWebinars) and
                    !$freeWebinars->isEmpty())
                @foreach ($freeWebinars as $freeWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $freeWebinar,
                        'class' => 'free_classes all_classes',
                    ])
                @endforeach
            @endif

            @if (
                $homeSection->name == \App\Models\HomeSection::$store_products and
                    !empty($newProducts) and
                    !$newProducts->isEmpty())
                @foreach ($newProducts as $newProduct)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $newProduct,
                        'class' => 'store_products all_classes',
                    ])
                @endforeach
            @endif
        @endforeach
    </div>
@endsection

@push('scripts_bottom')
    <script>
        hideDuplicates()
    </script>
@endpush
