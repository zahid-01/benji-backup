@extends('web.jiujitsu.layouts.app')

@section('content')
    <section class="forum-hero-section mt-50 relative">
        <div class="container forum-hero-section__container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="font-36 text-black">
                        <span>{{ trans('update.need_help?') }}</span><br/>
                        <span>{{ trans('update.create_a_topic_in_forum') }}</span>
                    </h1>
                    <p class="text-sm text-slate-500 mt-15">{{ trans('update.forum_top_section_hint') }}</p>

                    <div class="search-input bg-white p-10 grow mt-25">
                        <form action="/forums/search" method="get">
                            <div class="form-group flex items-center m-0">
                                <input type="text" name="search" class="form-control border-0" placeholder="{{ trans('update.search_discussions') }}"/>
                                <button type="submit" class="btn btn-primary rounded-pill">{{ trans('public.search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="forum-hero-section__image">
            <img src="/assets/default/img/forum/hero.png" class="img-cover" alt="forum hero">
        </div>
    </section>

    <div class="container mt-14">
        <div class="forum-stat-section rounded-lg bg-white p-20">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="flex items-center justify-center flex-col">
                        <img src="/assets/default/img/forum/1.svg" alt="{{ trans('update.forums') }}" class="forum-stat-icon"/>
                        <span class="text-3xl font-bold text-black">{{ $forumsCount }}</span>
                        <span class="font-16 font-medium text-slate-500">{{ trans('update.forums') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="flex items-center justify-center flex-col">
                        <img src="/assets/default/img/forum/2.svg" alt="{{ trans('update.topics') }}" class="forum-stat-icon"/>
                        <span class="text-3xl font-bold text-black">{{ $topicsCount }}</span>
                        <span class="font-16 font-medium text-slate-500">{{ trans('update.topics') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="flex items-center justify-center flex-col">
                        <img src="/assets/default/img/forum/3.svg" alt="{{ trans('site.posts') }}" class="forum-stat-icon"/>
                        <span class="text-3xl font-bold text-black">{{ $postsCount }}</span>
                        <span class="font-16 font-medium text-slate-500">{{ trans('site.posts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="flex items-center justify-center flex-col">
                        <img src="/assets/default/img/forum/4.svg" alt="{{ trans('update.members') }}" class="forum-stat-icon"/>
                        <span class="text-3xl font-bold text-black">{{ $membersCount }}</span>
                        <span class="font-16 font-medium text-slate-500">{{ trans('update.members') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($featuredTopics) and count($featuredTopics))
        <section class="container forums-featured-section mt-6 mt-md-50">

            <div class="text-center mb-30">
                <h2 class="text-3xl font-bold text-black">{{ trans('update.featured_topics') }}</h2>
                <p class="text-sm text-slate-500">{{ trans('update.featured_topics_hint') }}</p>
            </div>

            @foreach($featuredTopics as $featuredTopic)
                <div class="forums-featured-card flex items-center bg-white p-20 p-md-35 rounded-lg mt-15">
                    <div class="forums-featured-card-icon">
                        <img src="{{ $featuredTopic->icon }}" alt="{{ $featuredTopic->topic->title }}" class="img-cover">
                    </div>

                    <div class="ml-15">
                        <a href="{{ $featuredTopic->topic->getPostsUrl() }}" class="">
                            <h4 class="font-16 font-bold text-dark">{{ $featuredTopic->topic->title }}</h4>
                        </a>
                        <p class="text-sm text-slate-500">{!! truncate(strip_tags($featuredTopic->topic->description),100) !!}</p>
                        <div class="mt-15 flex align-items-end">
                            @if($featuredTopic->topic->posts_count > 0 or (!empty($featuredTopic->usersAvatars) and count($featuredTopic->usersAvatars)))
                                <div class="forums-featured-card-users-avatar flex items-center mr-10">
                                    @foreach($featuredTopic->usersAvatars as $userAvatar)
                                        <div class="user-avatar-card rounded-full">
                                            <img src="{{ $userAvatar->getAvatar(32) }}" class="img-cover rounded-full" alt="{{ $userAvatar->full_name }}">
                                        </div>
                                    @endforeach

                                    @if(($featuredTopic->topic->posts_count - count($featuredTopic->usersAvatars)) > 0)
                                        <span class="topics-count flex items-center justify-center text-sm text-slate-500 rounded-full">+{{ ($featuredTopic->topic->posts_count - count($featuredTopic->usersAvatars)) }}</span>
                                    @endif
                                </div>
                            @endif

                            <div class="flex items-center">
                                <div class="text-slate-500 text-sm">{{ trans('public.created_by') }} <span class="font-bold">{{ $featuredTopic->topic->creator->full_name }}</span></div>

                                <div class="text-slate-500 text-sm ml-2 pl-5 border-left">{{ trans('update.n_posts',['count' => $featuredTopic->topic->posts_count]) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="forums-featured-bg-box"></div>
        </section>
    @endif

    @if(!empty($forums) and count($forums))
        <section class="container forums-categories-section mt-6">
            <div class="text-center">
                <h2 class="text-3xl text-black font-bold">{{ trans('update.forums') }}</h2>
                <p class="text-sm text-slate-500 mt-5">{{ trans('update.forums_categories_hints') }}</p>
            </div>

            @foreach($forums as $forum)
                <div class="forums-categories-card mt-6 rounded-lg border bg-white p-15">
                    <h3 class="forums-categories-card__title text-dark font-16 font-bold mb-15">{{ $forum->title }}</h3>

                    @if(!empty($forum->subForums) and count($forum->subForums))
                        @foreach($forum->subForums as $subForum)
                            @include('web.jiujitsu.forum.forum_card',['forum' => $subForum])
                        @endforeach
                    @else
                        @include('web.jiujitsu.forum.forum_card',['forum' => $forum])
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    @if(!empty($recommendedTopics) and count($recommendedTopics))
        <section class="container forum-recommended-topics-section relative">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-black">{{ trans('update.recommended_topics') }}</h2>
                <p class="text-sm text-slate-500">{{ trans('update.recommended_topics_hint') }}</p>
            </div>

            <div class="row mt-4 relative">
                @foreach($recommendedTopics as $recommendedTopic)
                    <div class="col-12 col-md-3 mt-15">
                        <div class="forum-recommended-topics__card relative rounded-lg bg-white px-20 py-30">
                            <div class="forum-recommended-topics__icon">
                                <img src="{{ $recommendedTopic->icon }}" alt="{{ $recommendedTopic->title }}" class="img-cover">
                            </div>

                            <h4 class="font-16 font-bold text-black mt-10">{{ $recommendedTopic->title }}</h4>

                            <div class="forum-recommended-topics__lists mt-5">
                                @foreach($recommendedTopic->topics as $topic)
                                    <a href="{{ $topic->getPostsUrl() }}" class="flex items-center text-slate-500 text-sm font-medium mt-15">
                                        <i data-feather="chevron-right" class="mr-5 text-primary" width="16" height="16"></i>
                                        <span>{{ truncate($topic->title,25) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="forums-recommended-topics-bg-box"></div>
        </section>
    @endif

    <section class="container forum-question-section bg-info-light rounded-lg mt-25 mt-md-45">
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="px-10 px-md-25 py-25 p-md-50">
                    <h1 class="font-36 font-bold text-black">
                        <span class="block">{{ trans('update.have_a_question?') }}</span>
                        <span class="block">{{ trans('update.ask_it_in_forum_and_get_answer') }}</span>
                    </h1>

                    <p class="mt-15 text-slate-500 text-sm">{{ trans('update.have_a_question_hint') }}</p>

                    <div class="flex flex-col flex-md-row align-items-stretch align-items-md-center mt-15">
                        <a href="/forums/create-topic" class="btn btn-primary">
                            <i data-feather="file" class="mr-5 text-white" width="16" height="16"></i>
                            {{ trans('update.create_a_new_topic') }}
                        </a>

                        <a href="" class="btn btn-outline-primary ml-0 ml-md-20 mt-15 mt-md-0">
                            {{ trans('update.browse_forums') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5 hidden d-mblock relative">
                <div class="forum-question-section__img">
                    <img src="/assets/default/img/forum/question-section.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
