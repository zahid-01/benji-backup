@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="site-top-banner search-top-banner opacity-04 relative">
        <img src="{{ getPageBackgroundSettings('blog') }}" class="img-cover" alt=""/>

        <div class="container h-100">
            <div class="row h-100 items-center justify-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="top-search-categories-form">
                        <h1 class="text-white text-3xl mb-15">{{ $pageTitle }}</h1>
                        <span class="course-count-badge py-5 px-10 text-white rounded">{{ $blogCount }} {{ trans('site.posts') }}</span>

                        <div class="search-input bg-white p-10 grow">
                            <form action="/blog" method="get">
                                <div class="form-group flex items-center m-0">
                                    <input type="text" name="search" class="form-control border-0" value="{{ request()->get('search') }}" placeholder="{{ trans('home.blog_search_placeholder') }}"/>
                                    <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-10 mt-md-40">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="row">
                    @foreach($blog as $post)
                        <div class="col-12 col-md-4 col-lg-6">
                            <div class="mt-6">
                                @include('web.jiujitsu.blog.grid-list',['post' => $post])
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-4">

                <div class="p-20 mt-6 rounded-sm shadow-lg border border-gray300">
                    <h3 class="category-filter-title font-20 font-bold text-dark-blue">{{ trans('categories.categories') }}</h3>

                    <div class="pt-15">
                        @foreach($blogCategories as $blogCategory)
                            <a href="{{ $blogCategory->getUrl() }}" class="text-sm text-dark-blue block mt-15">{{ $blogCategory->title }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="p-20 mt-6 rounded-sm shadow-lg border border-gray300">
                    <h3 class="category-filter-title font-20 font-bold text-dark-blue">{{ trans('site.popular_posts') }}</h3>

                    <div class="pt-15">

                        @foreach($popularPosts as $popularPost)
                            <div class="popular-post flex align-items-start mt-4">
                                <div class="popular-post-image rounded">
                                    <img src="{{ $popularPost->image }}" class="img-cover rounded" alt="{{ $popularPost->title }}">
                                </div>
                                <div class="popular-post-content flex flex-col ml-10">
                                    <a href="{{ $popularPost->getUrl() }}">
                                        <h3 class="text-dark-blue text-sm">{{ truncate($popularPost->title,50) }}</h3>
                                    </a>
                                    <span class="mt-auto text-sm text-slate-500">{{ dateTimeFormat($popularPost->created_at, 'j M Y') }}</span>
                                </div>
                            </div>
                        @endforeach

                        <a href="/blog" class="btn btn-sm btn-primary btn-block mt-6">{{ trans('home.view_all') }} {{ trans('site.posts') }}</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-4 mt-md-50 pt-30">
            {{ $blog->appends(request()->input())->links('vendor.pagination.panel') }}
        </div>

    </section>
@endsection
