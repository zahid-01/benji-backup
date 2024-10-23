<div class="mt-4 flex justify-between">

    <div class="flex gap-2">
        @if (!empty($webinarPartnerTeacher))
            <span
                class="user-select-none px-15 py-10 bg-gray200 off-label text-slate-500 text-sm rounded-sm ml-auto">{{ trans('public.invited') }}</span>
        @endif

        <div class="relative">
            <img src="{{ $courseTeacher->getAvatar(100) }}" class="rounded-full w-14 h-14"
                alt="{{ $courseTeacher->full_name }}">

            @if ($courseTeacher->offline)
                <span class="unavailable flex items-center justify-center">
                    <i data-feather="slash" width="10" height="10" class="text-white"></i>
                </span>
            @elseif($courseTeacher->verified)
                <span
                    class="bg-[#2196f3] absolute w-4 h-4 shadow flex items-center justify-center p-1 rounded-full right-2 -bottom-2">
                    <i data-feather="check" width="10" height="10" class="text-white"></i>
                </span>
            @endif
        </div>

        <div>
            <div class="flex items-center gap-2">
                <h3 class="font-16 font-bold text-black"><a
                        href="{{ $courseTeacher->getProfileUrl() }}">{{ $courseTeacher->full_name }}</a></h3>
                <span class="my-2 text-xs font-medium text-slate-500 text-center">({{ $courseTeacher->bio }})</span>
            </div>
            @include('web.jiujitsu.includes.webinar.rate', ['rate' => $courseTeacher->rates()])
        </div>
    </div>

    <div class="hidden md:flex flex-wrap items-center gap-4 ">
        @foreach ($courseTeacher->getBadges() as $userBadge)
            <div data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! !empty($userBadge->badge_id) ? nl2br($userBadge->badge->description) : nl2br($userBadge->description) !!}">
                <img src="{{ !empty($userBadge->badge_id) ? $userBadge->badge->image : $userBadge->image }}"
                    width="32" height="32"
                    alt="{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}">
            </div>
        @endforeach
    </div>



    {{-- @php
        $hasMeeting = !empty($courseTeacher->hasMeeting());
    @endphp

    <div class="mt-6 flex flex-row gap-4 w-full">
        <a href="{{ $courseTeacher->getProfileUrl() }}" target="_blank" class="btn btn-sm flex-1 text-black font-light btn-primary {{ $hasMeeting ? 'teacher-btn-action' : 'btn-block' }}">{{ trans('public.profile') }}</a>

        @if ($hasMeeting)
            <a href="{{ $courseTeacher->getProfileUrl() }}" class="btn btn-sm flex-1 text-black font-light btn-primary teacher-btn-action ml-15">{{ trans('public.book_a_meeting') }}</a>
        @endif
    </div> --}}
</div>
