@php
    $price = (!empty($instructor->meeting)) ? $instructor->meeting->amount : 0;
    $discount = (!empty($price) and !empty($instructor->meeting) and !empty($instructor->meeting->discount) and $instructor->meeting->discount > 0) ? $instructor->meeting->discount : 0;
@endphp

<a href="{{ $instructor->getProfileUrl() }}" class="">
    <div class="relative flex flex-wrap instructor-finder-card border border-gray300 rounded-sm py-25 mt-4">

        <div class="col-12 col-md-8 flex">
            <div class="instructor-avatar rounded-full">
                <img src="{{ $instructor->getAvatar(70) }}" class="img-cover rounded-full" alt="{{ $instructor->full_name }}">
            </div>

            <div class="ml-20">
                <h3 class="font-16 font-bold text-black">{{ $instructor->full_name }}</h3>

                <div>
                    <span class="block text-sm text-slate-500">{{ $instructor->bio }}</span>

                    @if(!empty($instructor->occupations))
                        <div class="block text-sm text-slate-500 mt-5">
                            @foreach($instructor->occupations as $occupation)
                                @if(!empty($occupation->category))
                                    <span>{{ $occupation->category->title }}{{ !($loop->last) ? ', ' : '' }}</span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <p class="text-sm text-slate-500 mt-10">{{ truncate($instructor->about, 200) }}</p>
            </div>
        </div>

        <div class="col-12 col-md-4 mt-10 mt-md-0 pt-10 pt-md-0 instructor-finder-card-right-side relative">
            @if(!empty($discount))
                <span class="off-badge badge badge-danger">{{ trans('public.offer',['off' => $discount]) }}</span>
            @endif

            <div class="flex align-items-start">
                @if(!empty($instructor->meeting) and !empty($instructor->meeting->meetingTimes) and count($instructor->meeting->meetingTimes))
                    @if(!empty($price) and $price > 0)
                        <div class="flex flex-col">
                            <span class="font-20 font-bold text-primary">{{ handlePrice(!empty($discount) ? ($price - ($price * $discount / 100)) : $price) }}</span>

                            @if(!empty($discount))
                                <span class="text-sm font-medium text-slate-500 line-through">{{ handlePrice($price) }}</span>
                            @endif
                        </div>

                        <span class="text-sm font-medium text-slate-500 mt-5">/{{ trans('update.hour') }}</span>
                    @else
                        <span class="font-bold text-primary text-sm">{{ trans('public.free') }}</span>
                    @endif
                @else
                    <span class="font-bold text-danger text-sm">{{ trans('update.not_available_for_meeting') }}</span>
                @endif
            </div>

            @include('web.jiujitsu.includes.webinar.rate',['rate' => $instructor->rates()])

            <div class="flex items-center mt-4">
                <i data-feather="clock" width="18" height="18" class="text-dark-blue"></i>

                <span class="text-sm font-medium text-dark-blue ml-10">{{ $instructor->getTotalHoursTutoring() }} {{ trans('update.hours_tutoring') }}</span>
            </div>

            <div class="flex items-center flex-wrap mt-15">
                @foreach($instructor->getBadges() as $badge)
                    <div class="mr-15 mt-10 instructor-badge rounded-full" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! (!empty($badge->badge_id) ? nl2br($badge->badge->description) : nl2br($badge->description)) !!}">
                        <img src="{{ !empty($badge->badge_id) ? $badge->badge->image : $badge->image }}" class="img-cover rounded-full" alt="{{ !empty($badge->badge_id) ? $badge->badge->title : $badge->title }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</a>
