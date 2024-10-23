<div class="hidden" id="buyWithPointModal">
    <h3 class="section-title font-16 text-dark-blue mb-25">{{ trans('update.buy_with_points') }}</h3>

    @if(!empty($user))
        <div class="text-center">
            <img src="/assets/default/img/rewards/medal-2.png" class="buy-with-points-modal-img" alt="medal">

            <p class="text-sm font-medium text-slate-500 mt-6">
                <span class="block">{{ trans('update.this_course_requires_n_points',['points' => $course->points]) }}</span>
                <span class="block">{{ trans('update.you_have_n_points',['points' => $user->getRewardPoints()]) }}</span>

                @if($user->getRewardPoints() >= $course->points)
                    <span class="block">{{ trans('update.do_you_want_to_proceed') }}</span>
                @else
                    <span class="block text-danger">{{ trans('update.you_have_no_enough_points_for_this_course') }}</span>
                @endif
            </p>
        </div>

        <div class="flex items-center mt-25">
            <a href="{{ ($user->getRewardPoints() >= $course->points) ? '/course/'. $course->slug .'/points/apply' : '#' }}" class="btn btn-sm grow {{ ($user->getRewardPoints() >= $course->points) ? 'btn-primary js-buy-course-with-point' : 'bg-gray300 text-slate-500 disabled' }}">{{ trans('update.buy') }}</a>
            <a href="/panel/rewards" class="btn btn-outline-primary ml-15 btn-sm grow">{{ trans('update.my_points') }}</a>
        </div>
    @endif
</div>
