<div class="row items-center my-15">
    <div class="col-12 col-md-6">
        <div class="flex items-center">
            <div class="forums-categories-card__icon p-5">
                <img src="{{ $forum->icon }}" alt="{{ $forum->title }}" class="img-cover">
            </div>
            <div class="ml-10">
                <a href="{{ $forum->getUrl() }}" class="block">
                    <div class="text-sm text-black font-bold">{{ $forum->title }}</div>
                </a>
                <p class="text-sm text-slate-500 mt-5">{{ $forum->description }}</p>
            </div>
        </div>
    </div>

    <div class="col-4 col-md-2 mt-10 mt-md-0 flex items-center justify-content-around">
        <div class="text-center">
            <span class="block text-sm text-slate-500 font-bold">{{ $forum->topics_count }}</span>
            <div class="block text-sm text-slate-500">{{ trans('update.topics') }}</div>
        </div>

        <div class="text-center">
            <span class="block text-sm text-slate-500 font-bold">{{ $forum->posts_count }}</span>
            <div class="block text-sm text-slate-500">{{ trans('site.posts') }}</div>
        </div>
    </div>

    <div class="col-8 col-md-4 mt-10 mt-md-0 forums-categories-card__last-post flex items-center">
        @if(!empty($forum->lastTopic))
            <div class="user-avatar rounded-full">
                <img src="{{ $forum->lastTopic->creator->getAvatar(39) }}" class="img-cover rounded-full" alt="{{ $forum->lastTopic->creator->full_name }}">
            </div>

            <div class="ml-2">
                <a href="{{ $forum->lastTopic->getPostsUrl() }}" class="block">
                    <span class="text-sm font-medium text-slate-500 text-ellipsis">{{ truncate($forum->lastTopic->title,30) }}</span>
                </a>
                <div class="text-slate-500 text-sm"><span class="font-bold">{{ $forum->lastTopic->creator->full_name }}</span> {{ trans('public.in') }} {{ dateTimeFormat($forum->lastTopic->created_at,'j M Y | H:i') }}</div>
            </div>
        @endif
    </div>
</div>
