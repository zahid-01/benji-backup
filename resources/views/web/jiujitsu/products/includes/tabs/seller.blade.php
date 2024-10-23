<div class="product-show-seller-tab mt-4">

    <div class="product-show__profile-info-box profile-info-box flex align-items-start justify-between">
        <div class="user-details flex items-center">
            <div class="user-profile-avatar">
                <img src="{{ $seller->getAvatar(190) }}" class="img-cover" alt="{{ $seller->full_name }}"/>

                @if($seller->offline)
                    <span class="user-circle-badge unavailable flex items-center justify-center">
                        <i data-feather="slash" width="20" height="20" class="text-white"></i>
                    </span>
                @elseif($seller->verified)
                    <span class="user-circle-badge has-verified flex items-center justify-center">
                        <i data-feather="check" width="20" height="20" class="text-white"></i>
                    </span>
                @endif
            </div>
            <div class="ml-20 ml-lg-40">
                <h1 class="font-24 font-bold text-dark-blue">{{ $seller->full_name }}</h1>
                <span class="text-slate-500">{{ $seller->headline }}</span>

                <div class="stars-card flex items-center mt-5">
                    @include('web.jiujitsu.includes.webinar.rate',['rate' => $sellerRates])
                </div>

                <div class="w-full mt-10 flex items-center justify-center justify-content-lg-start">
                    <div class="flex flex-col followers-status">
                        <span class="font-20 font-bold text-dark-blue">{{ $sellerFollowers->count() }}</span>
                        <span class="text-sm text-slate-500">{{ trans('panel.followers') }}</span>
                    </div>

                    <div class="flex flex-col ml-25 pl-5 following-status">
                        <span class="font-20 font-bold text-dark-blue">{{ $sellerFollowing->count() }}</span>
                        <span class="text-sm text-slate-500">{{ trans('panel.following') }}</span>
                    </div>
                </div>

                @if(!empty($sellerBadges))
                    <div class="user-reward-badges flex flex-wrap items-center mt-15">
                        @foreach($sellerBadges as $sellerBadge)
                            <div class="mr-15" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! (!empty($sellerBadge->badge_id) ? nl2br($sellerBadge->badge->description) : nl2br($sellerBadge->description)) !!}">
                                <img src="{{ !empty($sellerBadge->badge_id) ? $sellerBadge->badge->image : $sellerBadge->image }}" width="32" height="32" alt="{{ !empty($sellerBadge->badge_id) ? $sellerBadge->badge->title : $sellerBadge->title }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="user-actions flex flex-col">
            <button type="button" id="followToggle" data-user-id="{{ $seller->id }}" class="btn btn-{{ (!empty($authUserIsFollower) and $authUserIsFollower) ? 'danger' : 'primary' }} btn-sm">
                @if(!empty($authUserIsFollower) and $authUserIsFollower)
                    {{ trans('panel.unfollow') }}
                @else
                    {{ trans('panel.follow') }}
                @endif
            </button>

            @if($seller->public_message)
                <button type="button" class="js-send-message btn btn-border-white rounded btn-sm mt-15">{{ trans('site.send_message') }}</button>
            @endif
        </div>
    </div>

    @if($seller->offline)
        <div class="user-offline-alert flex mt-14">
            <div class="p-15">
                <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-15">{{ $seller->offline_message }}</p>
            </div>

            <div class="offline-icon offline-icon-right ml-auto flex align-items-stretch">
                <div class="flex items-center">
                    <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                </div>
            </div>
        </div>
    @endif

    @if(!empty($seller->about))
        <div class="mt-14">
            <h3 class="font-16 text-dark-blue font-bold">{{ trans('site.about') }}</h3>

            <div class="mt-15 text-slate-500">
                {!! nl2br($seller->about) !!}
            </div>
        </div>
    @endif
</div>
