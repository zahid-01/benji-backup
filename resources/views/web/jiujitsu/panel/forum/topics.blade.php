@extends('web.jiujitsu.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('update.topics_statistics') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/125.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $publishedTopics }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.published_topics') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/126.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $lockedTopics }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.locked_topics') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/39.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $topicMessages }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.topic_messages') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-25">
        <h2 class="section-title">{{ trans('update.filter_topics') }}</h2>

        <div class="panel-section-card py-20 px-4 mt-4">
            <form action="/panel/forums/topics" method="get" class="row">
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.from') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="dateInputGroupPrepend">
                                            <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="from" autocomplete="off" class="form-control @if(!empty(request()->get('from'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('from','') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.to') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="dateInputGroupPrepend">
                                            <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="to" autocomplete="off" class="form-control @if(!empty(request()->get('to'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('to','') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('update.forums') }}</label>
                                <select name="forum_id" class="form-control" data-placeholder="{{ trans('public.all') }}">
                                    <option value="all">{{ trans('public.all') }}</option>

                                    @foreach($forums as $forum)
                                        @if(!empty($forum->subForums) and count($forum->subForums))
                                            <optgroup label="{{ $forum->title }}">
                                                @foreach($forum->subForums as $subForum)
                                                    <option value="{{ $subForum->id }}" {{ (request()->get('forum_id') == $subForum->id) ? 'selected' : '' }}>{{ $subForum->title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $forum->id }}" {{ (request()->get('forum_id') == $forum->id) ? 'selected' : '' }}>{{ $forum->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.status') }}</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="all">{{ trans('public.all') }}</option>
                                    <option value="published" @if(request()->get('status') == 'published') selected @endif >{{ trans('public.published') }}</option>
                                    <option value="closed" @if(request()->get('status') == 'closed') selected @endif >{{ trans('panel.closed') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2 flex items-center justify-end">
                    <button type="submit" class="btn btn-sm btn-primary w-full mt-2">{{ trans('public.show_results') }}</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mt-8">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('update.my_topics') }}</h2>
        </div>

        @if($topics->count() > 0)

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th class="text-left">{{ trans('public.title') }}</th>
                                    <th class="text-center">{{ trans('update.forum') }}</th>
                                    <th class="text-center">{{ trans('site.posts') }}</th>
                                    <th class="text-center">{{ trans('public.status') }}</th>
                                    <th class="text-center">{{ trans('public.publish_date') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($topics as $topic)
                                    <tr>
                                        <td class="text-left align-middle">
                                            <div class="user-inline-avatar flex items-center">
                                                <div class="avatar bg-gray200">
                                                    <img src="{{ $topic->forum->icon }}" class="img-cover" alt="">
                                                </div>
                                                <a href="{{ $topic->getPostsUrl() }}" target="_blank" class="">
                                                    <div class=" ml-2">
                                                        <span class="block text-sm font-medium text-dark-blue">{{ $topic->title }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $topic->forum->title }}</td>
                                        <td class="text-center align-middle">{{ $topic->posts_count }}</td>
                                        <td class="text-center align-middle">
                                            @if($topic->close)
                                                {{ trans('panel.closed') }}
                                            @else
                                                {{ trans('public.published') }}
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">{{ dateTimeFormat($topic->created_at, 'j M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else

            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'quiz.png',
                'title' => trans('update.panel_topics_no_result'),
                'hint' => nl2br(trans('update.panel_topics_no_result_hint')),
                'btn' => ['url' => '/forums','text' => trans('update.forums')]
            ])

        @endif

    </section>

    <div class="my-30">
        {{ $topics->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
@endpush
