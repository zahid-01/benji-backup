@if(!empty($forumTopics) and !$forumTopics->isEmpty())
    <div class="px-15 py-20">

        @foreach($forumTopics as $topic)
            <div class="topics-lists-card row items-center py-10">
                <div class="col-12 col-md-6">
                    <div class="flex items-center">
                        <div class="topic-user-avatar rounded-full">
                            <img src="{{ $user->getAvatar() }}" class="img-cover rounded-full" alt="{{ $user->full_name }}">
                        </div>
                        <div class="ml-10 mw-full">
                            <a href="{{ $topic->getPostsUrl() }}" class="">
                                <h4 class="font-16 font-bold text-black text-ellipsis">{{ $topic->title }}</h4>
                            </a>
                            <span class="block text-sm text-slate-500">{{ trans('public.by') }} {{ $user->full_name }} {{ trans('public.in') }} {{ dateTimeFormat($topic->created_at,'j M Y | H:i') }}</span>
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
@else
    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'webinar.png',
        'title' => trans('update.instructor_not_have_topics'),
        'hint' => '',
    ])
@endif

