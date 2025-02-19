@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="cart-banner relative text-center">
        <div class="container h-100">
            <div class="row h-100 items-center justify-center text-center">
                <div class="col-12 col-md-9 col-lg-7">

                    <h1 class="text-3xl text-white font-bold">{{ $post->title }}</h1>

                    <div class="flex flex-col flex-sm-row items-center align-sm-items-start justify-between">
                        @if(!empty($post->author))
                            <span class="mt-10 mt-md-20 font-16 font-medium text-white">{{ trans('public.created_by') }}
                                @if($post->author->isTeacher())
                                    <a href="{{ $post->author->getProfileUrl() }}" target="_blank" class="text-white text-decoration-underline">{{ $post->author->full_name }}</a>
                                @elseif(!empty($post->author->full_name))
                                    <span class="text-white text-decoration-underline">{{ $post->author->full_name }}</span>
                                @endif
                        </span>
                        @endif

                        <span class="mt-10 mt-md-20 font-16 font-medium text-white">{{ trans('public.in') }}
                            <a href="{{ $post->category->getUrl() }}" class="text-white text-decoration-underline">{{ $post->category->title }}</a>
                        </span>

                        <span class="mt-10 mt-md-20 font-16 font-medium text-white">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>

                        <div class="js-share-blog flex items-center cursor-pointer mt-10 mt-md-20">
                            <div class="icon-box ">
                                <i data-feather="share-2" class="text-white" width="20" height="20"></i>
                            </div>
                            <div class="ml-2 font-16 font-medium text-white">{{ trans('public.share') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="container mt-10 mt-md-40">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="post-show mt-6">

                    <div class="post-img pb-30">
                        <img src="{{ $post->image }}" alt="">
                    </div>


                    {!! nl2br($post->content) !!}
                </div>

                {{-- post Comments --}}
                @if($post->enable_comment)
                    @include('web.jiujitsu.includes.comments',[
                            'comments' => $post->comments,
                            'inputName' => 'blog_id',
                            'inputValue' => $post->id
                        ])
                @endif
                {{-- ./ post Comments --}}

            </div>
            <div class="col-12 col-lg-4">
                @if(!empty($post->author) and !empty($post->author->full_name))
                    <div class="rounded-lg shadow-lg mt-8 p-20 course-teacher-card flex items-center flex-col">
                        <div class="teacher-avatar mt-5">
                            <img src="{{ $post->author->getAvatar(100) }}" class="img-cover" alt="">
                        </div>
                        <h3 class="mt-10 font-20 font-bold text-black">{{ $post->author->full_name }}</h3>

                        @if(!empty($post->author->role))
                            <span class="mt-5 font-medium text-sm text-slate-500">{{ $post->author->role->caption }}</span>
                        @endif

                        <div class="mt-25 flex items-center  w-full">
                            <a href="/blog?author={{ $post->author->id }}" class="btn btn-sm btn-primary btn-block px-15">{{ trans('public.author_posts') }}</a>
                        </div>
                    </div>
                @endif

                {{-- categories --}}
                <div class="p-20 mt-6 rounded-sm shadow-lg border border-gray300">
                    <h3 class="category-filter-title font-16 font-bold text-dark-blue">{{ trans('categories.categories') }}</h3>

                    <div class="pt-15">
                        @foreach($blogCategories as $blogCategory)
                            <a href="{{ $blogCategory->getUrl() }}" class="text-sm text-dark-blue block mt-15">{{ $blogCategory->title }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- recent_posts --}}
                <div class="p-20 mt-6 rounded-sm shadow-lg border border-gray300">
                    <h3 class="category-filter-title font-20 font-bold text-dark-blue">{{ trans('site.recent_posts') }}</h3>

                    <div class="pt-15">

                        @foreach($popularPosts as $popularPost)
                            <div class="popular-post flex align-items-start mt-4">
                                <div class="popular-post-image rounded">
                                    <img src="{{ $popularPost->image }}" class="img-cover rounded" alt="{{ $popularPost->title }}">
                                </div>
                                <div class="popular-post-content flex flex-col ml-10">
                                    <a href="{{ $popularPost->getUrl() }}">
                                        <h3 class="text-sm text-dark-blue">{{ truncate($popularPost->title,40) }}</h3>
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
    </section>

    @include('web.jiujitsu.blog.share_modal')
@endsection

@push('scripts_bottom')
    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var copyLang = '{{ trans('public.copy') }}';
        var copiedLang = '{{ trans('public.copied') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/blog.min.js"></script>
@endpush
