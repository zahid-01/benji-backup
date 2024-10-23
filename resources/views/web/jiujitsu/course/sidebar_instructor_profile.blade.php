<div class="rounded-lg shadow-lg mt-8 p-4 course-teacher-card flex items-center flex-col">

    @if(!empty($webinarPartnerTeacher))
        <span class="user-select-none px-15 py-10 bg-gray200 off-label text-slate-500 text-sm rounded-sm ml-auto">{{ trans('public.invited') }}</span>
    @endif

    <div class="mt-5 relative">
        <img src="{{ $courseTeacher->getAvatar(100) }}" class="rounded-full w-28 h-28" alt="{{ $courseTeacher->full_name }}">

        @if($courseTeacher->offline)
            <span class="unavailable flex items-center justify-center">
              <i data-feather="slash" width="20" height="20" class="text-white"></i>
           </span>
        @elseif($courseTeacher->verified)
            <span class="bg-[#2196f3] absolute w-8 h-8 shadow flex items-center justify-center p-1 rounded-full right-2 -bottom-2">
                <i data-feather="check" width="30" height="30" class="text-white"></i>
            </span>
        @endif
    </div>
    <h3 class="mt-3 font-16 font-bold text-black">{{ $courseTeacher->full_name }}</h3>
    <span class="my-2 text-sm font-medium text-slate-500 text-center">{{ $courseTeacher->bio }}</span>

    @include('web.jiujitsu.includes.webinar.rate',['rate' => $courseTeacher->rates()])

    <div class="flex flex-wrap items-center mt-6 gap-4">
        @foreach($courseTeacher->getBadges() as $userBadge)
            <div data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! (!empty($userBadge->badge_id) ? nl2br($userBadge->badge->description) : nl2br($userBadge->description)) !!}">
                <img src="{{ !empty($userBadge->badge_id) ? $userBadge->badge->image : $userBadge->image }}" width="32" height="32" alt="{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}">
            </div>
        @endforeach
    </div>

    @php
        $hasMeeting = !empty($courseTeacher->hasMeeting());
    @endphp

    <div class="mt-6 flex flex-row gap-4 w-full">
        <a href="{{ $courseTeacher->getProfileUrl() }}" target="_blank" class="btn btn-sm flex-1 text-black font-light btn-primary {{ $hasMeeting ? 'teacher-btn-action' : 'btn-block' }}">{{ trans('public.profile') }}</a>

        @if($hasMeeting)
            <a href="{{ $courseTeacher->getProfileUrl() }}" class="btn btn-sm flex-1 text-black font-light btn-primary teacher-btn-action ml-15">{{ trans('public.book_a_meeting') }}</a>
        @endif
    </div>
</div>
