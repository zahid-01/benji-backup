<div class="webinar-card">
    <figure>
        <div class="image-box">
            @if(!empty($upcomingCourse->webinar_id))
                <span class="badge badge-secondary">{{ trans('update.released') }}</span>
            @endif

            <a href="{{ $upcomingCourse->getUrl() }}">
                <img src="{{ $upcomingCourse->getImage() }}" class="img-cover" alt="{{ $upcomingCourse->title }}">
            </a>

            @if(empty($upcomingCourse->webinar_id))
                <a href="{{ $upcomingCourse->addToCalendarLink() }}" target="_blank" class="upcoming-bell flex items-center justify-center">
                    <i data-feather="bell" width="20" height="20"></i>
                </a>
            @endif
        </div>

        <figcaption class="webinar-card-body">
            <div class="user-inline-avatar flex items-center">
                <div class="avatar bg-gray200">
                    <img src="{{ $upcomingCourse->teacher->getAvatar() }}" class="img-cover" alt="{{ $upcomingCourse->teacher->full_name }}">
                </div>
                <a href="{{ $upcomingCourse->teacher->getProfileUrl() }}" target="_blank" class="user-name ml-2 text-sm">{{ $upcomingCourse->teacher->full_name }}</a>
            </div>

            <a href="{{ $upcomingCourse->getUrl() }}">
                <h3 class="mt-15 webinar-title font-bold font-16 text-dark-blue">{{ clean($upcomingCourse->title,'title') }}</h3>
            </a>

            @if(!empty($upcomingCourse->category))
                <span class="block text-sm mt-10">{{ trans('public.in') }} <a href="{{ $upcomingCourse->category->getUrl() }}" target="_blank" class="text-decoration-underline">{{ $upcomingCourse->category->title }}</a></span>
            @endif

            <div class="flex justify-between mt-4">
                @if(!empty($upcomingCourse->duration))
                    <div class="flex items-center">
                        <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                        <span class="duration text-sm ml-2">{{ convertMinutesToHourAndMinute($upcomingCourse->duration) }} {{ trans('home.hours') }}</span>
                    </div>
                @endif

                @if(!empty($upcomingCourse->published_date))

                    @if(!empty($upcomingCourse->duration))
                        <div class="vertical-line mx-15"></div>
                    @endif

                    <div class="flex items-center">
                        <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                        <span class="date-published text-sm ml-2">{{ dateTimeFormat($upcomingCourse->published_date, 'j M Y') }}</span>
                    </div>
                @endif
            </div>

            <div class="webinar-price-box mt-25">
                @if(!empty($upcomingCourse->price) and $upcomingCourse->price > 0)
                    <span class="real">{{ handlePrice($upcomingCourse->price) }}</span>
                @else
                    <span class="real text-sm">{{ trans('public.free') }}</span>
                @endif
            </div>
        </figcaption>
    </figure>
</div>
