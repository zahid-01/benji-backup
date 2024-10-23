@php
    $percent = $course->getProgress(true);
@endphp

<div class="flex align-items-lg-center justify-between flex-col lg:flex-row px-15 px-lg-35 py-3">
    <div class="flex align-items-lg-center flex-col lg:flex-row grow">

        <div class="flex items-center justify-between lg:justify-start">
            <a class="text-xl font-black" href="/">
                {{-- @if (!empty($generalSettings['logo'])) --}}
                {{-- <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="site logo"> --}}
                {{-- @endif --}}
                {{ $generalSettings['site_name'] }}
            </a>

            <div class="flex items-center lg:hidden ml-20">
                <a href="{{ $course->getUrl() }}"
                    class="btn learning-page-navbar-btn btn-sm border-gray200 hidden d-mblock">{{ trans('update.course_page') }}</a>

                <a href="/panel/webinars/purchases"
                    class="btn learning-page-navbar-btn btn-sm border-gray200 ml-0 ml-md-10">{{ trans('update.my_courses') }}</a>
            </div>
        </div>

        <div class="flex flex-col ml-5">
            <a href="{{ $course->getUrl() }}" class="learning-page-navbar-title">
                <span class="font-bold">{{ $course->title }}</span>
            </a>

            <div class="flex items-center">
                <div
                    class="w-[465px] h-[11px] course-progress flex items-center grow bg-white border border-gray-200 rounded shadow-none mt-1">
                    <span class="block h-full rounded bg-warning" style="width: {{ $percent }}%"></span>
                </div>

                <span class="ml-2 font-medium text-sm text-slate-500">{{ $percent }}%
                    {{ trans('update.learnt') }}</span>
            </div>
        </div>
    </div>

    <div class="flex items-center mt-1 md:mt-0">

        @if (!empty($course->noticeboards_count) and $course->noticeboards_count > 0)
            <a href="{{ $course->getNoticeboardsPageUrl() }}" target="_blank"
                class="btn learning-page-navbar-btn noticeboard-btn btn-sm border-gray200 mr-10">
                <i data-feather="bell" class="" width="16" height="16"></i>

                <span
                    class="noticeboard-btn-badge flex items-center justify-center text-white bg-danger rounded-full text-sm">{{ $course->noticeboards_count }}</span>
            </a>
        @endif

        @if ($course->forum)
            <a href="{{ $course->getForumPageUrl() }}"
                class="btn learning-page-navbar-btn btn-sm border-gray200 mr-10">{{ trans('update.course_forum') }}</a>
        @endif

        <div class="hidden items-center lg:flex">
            <a href="{{ $course->getUrl() }}"
                class="btn learning-page-navbar-btn btn-sm border-gray200">{{ trans('update.course_page') }}</a>

            <a href="/panel/webinars/purchases"
                class="btn learning-page-navbar-btn btn-sm border-gray200 ml-3">{{ trans('update.my_courses') }}</a>
        </div>

        <button id="collapseBtn" type="button" class="btn-ghost ml-auto lg:ml-4">
            <i data-feather="menu" width="20" height="20" class=""></i>
        </button>
    </div>
</div>
