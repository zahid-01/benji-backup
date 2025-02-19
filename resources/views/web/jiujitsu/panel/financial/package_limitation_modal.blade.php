<div class="text-left">
    <h3 class="section-title font-16 text-dark-blue mb-25">{{ trans('update.upgrade_your_plan') }}</h3>

    <div class="text-center">
        <img src="/assets/default/img/icons/diamond.png" class="buy-with-points-modal-img" alt="diamond">

        <p class="text-sm font-medium text-slate-500 mt-6">
            <span class="block">{{ trans('update.your_account_limited') }}</span>
            <span class="block">{{ trans('update.your_account_'. $type .'_limited_hint') }}</span>
            @if(!empty($currentCount))
                <span class="block">{{ trans('update.your_current_plan_'.$type,['count' => $currentCount]) }}</span>
            @endif
        </p>
    </div>

    <div class="flex items-center mt-25">
        <a href="/panel/financial/registration-packages" class="btn btn-primary btn-sm grow">{{ trans('update.upgrade') }}</a>
        <button type="button" class="btn btn-outline-danger ml-15 btn-sm grow close-swl">{{ trans('public.cancel') }}</button>
    </div>
</div>
