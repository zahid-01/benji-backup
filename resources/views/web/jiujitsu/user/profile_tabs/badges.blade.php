@if(!empty($userBadges) and count($userBadges))

    <div class="user-reward-badges badges-lg grid grid-cols-6 lg:grid-cols-4 gap-3 items-center mt-10 mt-lg-20 py-10">

        @foreach($userBadges as $userBadge)

            <div class="col-6 col-lg-3 mt-4 mt-lg-0">
                <div class="rounded-lg badges-item py-20 py-lg-40 shadow-lg px-10 px-lg-25 flex flex-col items-center">
                    <img src="{{ !empty($userBadge->badge_id) ? $userBadge->badge->image : $userBadge->image }}" class="rounded-full w-28 h-28" alt="{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}">

                    <span class="font-16 font-bold text-dark-blue mt-15 mt-lg-25">{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}</span>
                    <span class="text-sm text-slate-500 mt-5 mt-lg-10 text-center">{!! (!empty($userBadge->badge_id) ? nl2br($userBadge->badge->description) : nl2br($userBadge->description)) !!}</span>
                </div>
            </div>

        @endforeach

    </div>

@else
    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'badge.png',
        'title' => trans('site.instructor_not_have_badge'),
        'hint' => '',
    ])

@endif
