@extends('web.jiujitsu.layouts.app')

@section('content')
    <div class="container">
        <section class="topics-title-section mt-6 mt-md-50 px-20 px-md-30 py-25 py-md-35 rounded-lg">
            <h1 class="text-3xl font-bold text-white">{{ trans('update.search_results_for',['temp' => request()->get('search')]) }}</h1>

            <div class="mt-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item text-sm text-white"><a href="/" class="text-white">{{ getGeneralSettings('site_name') }}</a></li>
                        <li class="breadcrumb-item text-sm text-white"><a href="/forums" class="text-white">{{ trans('update.forum') }}</a></li>
                        <li class="breadcrumb-item text-sm text-white font-bold" aria-current="page">{{ trans('update.search_results') }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <div class="topics-filters-section bg-white rounded-lg px-20 py-25 mt-14">
            <div class="row">
                <div class="col-12 col-md-5">
                    <h3 class="font-16 font-bold text-black">{{ trans('update.still_no_luck') }}</h3>
                    <div class="flex items-center mt-5 text-sm text-slate-500 font-medium">{{ trans('update.try_again_or_create_a_topic_for_it') }}</div>
                </div>

                <div class="col-12 col-md-7  mt-15 mt-lg-0">
                    <div class="row">
                        <div class="col-12 col-lg-7">
                            <form action="" method="get">
                                <div class="flex items-center">
                                    <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control input-search-topic grow" placeholder="{{ trans('update.search_in_this_forum') }}">
                                    <button type="submit" class="btn btn-primary btn-search-topic ml-10">
                                        <i data-feather="search" class="text-white" width="16" height="16"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-5 mt-15 mt-lg-0 text-right">
                            <a href="/forums/create-topic" class="btn btn-primary btn-create-topic btn-block">
                                <i data-feather="file" class="text-white" width="16" height="16"></i>
                                <span class="ml-1">{{ trans('update.create_a_new_topic') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="row">
                <div class="col-12 col-md-9">

                    <div class="py-15 px-20 rounded-sm bg-info-light border mb-15">
                        <h4 class="text-sm font-bold text-slate-500">{{ trans('update.search_results_found',['count' => $resultCount]) }}</h4>
                        <p class="mt-5 text-sm text-slate-500">{{ trans('update.explore_them_from_the_following_list') }}</p>
                    </div>

                    @if(!empty($topics) and count($topics))
                        <div class="rounded-lg px-15 py-20 border bg-white">

                            @foreach($topics as $topic)
                                <div class="topics-lists-card row items-center py-10">
                                    <div class="col-12 col-md-6">
                                        <div class="flex items-center">
                                            <div class="topic-user-avatar rounded-full">
                                                <img src="{{ $topic->creator->getAvatar() }}" class="img-cover rounded-full" alt="{{ $topic->creator->full_name }}">
                                            </div>
                                            <div class="ml-10 mw-full">
                                                <a href="{{ $topic->getPostsUrl() }}" class="">
                                                    <h4 class="font-16 font-bold text-black text-ellipsis">{{ $topic->title }}</h4>
                                                </a>
                                                <span class="block text-sm text-slate-500">{{ trans('public.by') }} {{ $topic->creator->full_name }} {{ trans('public.in') }} {{ dateTimeFormat($topic->created_at,'j M Y | H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <span class="block text-sm text-slate-500 font-bold">{{ $topic->posts_count }}</span>
                                                <span class="block text-sm text-slate-500">{{ trans('site.posts') }}</span>
                                            </div>
                                            <div class="col-3 flex items-center">
                                                @if($topic->pin)
                                                    <div class="topics-lists-card__icons rounded-full mr-10">
                                                        <img src="/assets/default/img/learning/un_pin.svg" alt="" class="img-cover rounded-full">
                                                    </div>
                                                @endif

                                                @if($topic->close)
                                                    <div class="topics-lists-card__icons rounded-full">
                                                        <img src="/assets/default/img/learning/lock.svg" alt="" class="img-cover rounded-full">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-6">
                                                @if(!empty($topic->lastPost))
                                                    <div class="flex items-center">
                                                        <div class="topic-last-post-user-avatar rounded-full">
                                                            <img src="{{ $topic->lastPost->user->getAvatar(30) }}" class="img-cover rounded-full" alt="{{ $topic->lastPost->user->full_name }}">
                                                        </div>
                                                        <div class="ml-10">
                                                            <h4 class="text-sm font-medium text-slate-500">{{ $topic->lastPost->user->full_name }}</h4>
                                                            <span class="block text-sm font-medium text-slate-500">{{ trans('public.in') }} {{ dateTimeFormat($topic->lastPost->created_at,'j M Y | H:i') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="mt-4">
                            {{ $topics->appends(request()->input())->links('vendor.pagination.panel') }}
                        </div>
                    @else
                        <div class="topics-not-result flex items-center justify-center flex-col">
                            <div class="topics-not-result-icon flex items-center justify-center">
                                <img src="/assets/default/img/learning/forum-empty.svg" class="img-fluid" alt="">
                            </div>

                            <div class="flex items-center flex-col mt-10 text-center">
                                <h3 class="font-20 font-bold text-dark-blue text-center">{{ trans('update.result_not_found') }}</h3>
                                <p class="text-sm font-medium text-slate-500 mt-5 text-center">{{ trans('update.try_another_word_to_reach_results') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-12 col-md-3">
                    @if(!empty($topUsers) and count($topUsers))
                        <div class="rounded-lg p-15 border bg-white">
                            <h3 class="topics-right-side-title relative font-16 text-dark font-bold mb-25">{{ trans('update.top_users') }}</h3>

                            @foreach($topUsers as $topUser)
                                @if(!empty($topUser->all_posts))
                                    <div class="flex items-center mt-15">
                                        <div class="topics-right-side-user-avatar rounded-full">
                                            <img src="{{ $topUser->getAvatar(48) }}" class="img-cover rounded-full" alt="{{ $topUser->full_name }}">
                                        </div>
                                        <div class="ml-10">
                                            <a href="{{ $topUser->getProfileUrl() }}" class="block">
                                                <span class="text-sm font-medium text-black">{{ $topUser->full_name }}</span>
                                            </a>
                                            <span class="block text-sm font-medium text-slate-500">{{ trans('update.n_posts',['count' => $topUser->posts]) }} | {{ trans('update.n_topics',['count' => $topUser->topics]) }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="rounded-lg p-15 border bg-white mt-4">
                        <h3 class="topics-right-side-title relative font-16 text-dark font-bold mb-25">{{ trans('update.popular_topics') }}</h3>

                        @foreach($popularTopics as $popularTopic)
                            <div class="flex items-center mt-15">
                                <div class="topics-right-side-user-avatar rounded-full">
                                    <img src="{{ $popularTopic->creator->getAvatar(48) }}" class="img-cover rounded-full" alt="{{ $popularTopic->creator->full_name }}">
                                </div>
                                <div class="ml-10">
                                    <a href="{{ $popularTopic->getPostsUrl() }}" class="block">
                                        <span class="text-sm font-medium text-black">{{ $popularTopic->title }}</span>
                                    </a>
                                    <span class="block text-sm font-medium text-slate-500">{{ trans('public.by') }} {{ $popularTopic->creator->full_name }} | {{ trans('update.n_posts',['count' => $popularTopic->posts_count]) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
