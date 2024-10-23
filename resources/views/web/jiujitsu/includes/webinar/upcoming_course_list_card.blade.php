<div class="webinar-card webinar-list webinar-list-2 flex mt-6">
    <div class="image-box">
        @if(!empty($upcomingCourse->webinar_id))
            <span class="badge badge-secondary">{{ trans('update.released') }}</span>
        @endif

        <a href="{{ $upcomingCourse->getUrl() }}">
            <img src="{{ $upcomingCourse->getImage() }}" class="img-cover" alt="{{ $upcomingCourse->title }}">
        </a>
    </div>

    <div class="webinar-card-body w-full flex flex-col">

        @if(empty($upcomingCourse->webinar_id))
            <a href="{{ $upcomingCourse->addToCalendarLink() }}" target="_blank" class="upcoming-bell flex items-center justify-center">
                <i data-feather="bell" width="20" height="20"></i>
            </a>
        @endif

        <div class="flex items-center justify-between">
            <a href="{{ $upcomingCourse->getUrl() }}">
                <h3 class="mt-15 webinar-title font-bold font-16 text-dark-blue">{{ clean($upcomingCourse->title,'title') }}</h3>
            </a>
        </div>

        @if(!empty($upcomingCourse->category))
            <span class="block text-sm mt-10">{{ trans('public.in') }} <a href="{{ $upcomingCourse->category->getUrl() }}" target="_blank" class="text-decoration-underline">{{ $upcomingCourse->category->title }}</a></span>
        @endif

        <div class="user-inline-avatar flex items-center mt-10">
            <div class="avatar bg-gray200">
                <img src="{{ $upcomingCourse->teacher->getAvatar() }}" class="img-cover" alt="{{ $upcomingCourse->teacher->full_name }}">
            </div>
            <a href="{{ $upcomingCourse->teacher->getProfileUrl() }}" target="_blank" class="user-name ml-2 text-sm">{{ $upcomingCourse->teacher->full_name }}</a>
        </div>


        <div class="flex justify-between mt-auto">
            <div class="flex items-center">

                @if(!empty($upcomingCourse->duration))
                    <div class="flex items-center">
                        <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                        <span class="duration ml-2 text-sm">{{ convertMinutesToHourAndMinute($upcomingCourse->duration) }} {{ trans('home.hours') }}</span>
                    </div>
                @endif

                @if(!empty($upcomingCourse->published_date))

                    @if(!empty($upcomingCourse->duration))
                        <div class="vertical-line h-25 mx-15"></div>
                    @endif

                    <div class="flex items-center">
                        <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                        <span class="date-published ml-2 text-sm">{{ dateTimeFormat($upcomingCourse->published_date, 'j M Y') }}</span>
                    </div>
                @endif
            </div>

            <div class="webinar-price-box flex flex-col justify-center items-center">
                @if(!empty($upcomingCourse->price))
                    <span class="real">{{ handlePrice($upcomingCourse->price) }}</span>
                @else
                    <span class="real text-sm">{{ trans('public.free') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
