<section class="px-15 pb-15 my-15 mx-lg-15 bg-white rounded-lg">

    @if(!empty($course->noticeboards) and count($course->noticeboards))
        @foreach($course->noticeboards as $noticeboard)
            <div class="course-noticeboards noticeboard-{{ $noticeboard->color }} p-15 mt-15 rounded-sm w-full">
                <div class="flex items-center">
                    <div class="course-noticeboard-icon flex items-center justify-center rounded-full">
                        <i data-feather="{{ $noticeboard->getIcon() }}" class="" width="24" height="24"></i>
                    </div>

                    <div class="ml-10">
                        <h3 class="text-sm font-bold">{{ $noticeboard->title }}</h3>
                        <span class="block text-sm">{{ $noticeboard->creator->full_name }} {{ trans('public.in') }} {{ dateTimeFormat($noticeboard->created_at,'j M Y') }}</span>
                    </div>
                </div>

                <div class="mt-10 text-sm">{!! $noticeboard->message !!}</div>
            </div>
        @endforeach
    @endif

</section>
