@extends('web.jiujitsu.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')

    <section class="mt-8">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('update.bookmarks') }}</h2>
        </div>

        @if($topics->count() > 0)

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th class="text-left">{{ trans('public.topic') }}</th>
                                    <th class="text-center">{{ trans('update.forum') }}</th>
                                    <th class="text-center">{{ trans('update.replies') }}</th>
                                    <th class="text-center">{{ trans('public.publish_date') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($topics as $topic)
                                    <tr>
                                        <td class="text-left align-middle">
                                            <div class="user-inline-avatar flex items-center">
                                                <div class="avatar bg-gray200">
                                                    <img src="{{ $topic->creator->getAvatar(48) }}" class="img-cover" alt="">
                                                </div>
                                                <a href="{{ $topic->getPostsUrl() }}" target="_blank" class="">
                                                    <div class=" ml-2">
                                                        <span class="block font-16 font-medium text-dark-blue">{{ $topic->title }}</span>
                                                        <span class="text-sm text-slate-500 mt-5">{{ trans('public.by') }} {{ $topic->creator->full_name }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $topic->forum->title }}</td>
                                        <td class="text-center align-middle">{{ $topic->posts_count }}</td>
                                        <td class="text-center align-middle">{{ dateTimeFormat($topic->created_at, 'j M Y H:i') }}</td>
                                        <td class="text-center align-middle">
                                            <a
                                                href="/panel/forums/topics/{{ $topic->id }}/removeBookmarks"
                                                data-title="{{ trans('update.this_topic_will_be_removed_from_your_bookmark') }}"
                                                data-confirm="{{ trans('update.confirm') }}"
                                                class="panel-remove-bookmark-btn delete-action flex items-center justify-center p-5 rounded-full">
                                                <i data-feather="bookmark" width="18" height="18" class="text-danger"></i>
                                            </a>
                                        </td>
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
                'file_name' => 'comment.png',
                'title' => trans('update.panel_topics_bookmark_no_result'),
                'hint' => nl2br(trans('update.panel_topics_bookmark_no_result_hint')),
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
