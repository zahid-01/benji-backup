<div class="hidden" id="exchangePointsModal">
    <h3 class="section-title font-16 text-dark-blue mb-25">{{ trans('update.exchange_points') }}</h3>

    <div class="text-center">
        <img src="/assets/default/img/rewards/wallet.png" class="exchange-points-modal-img" alt="wallet">

        <p class="text-sm font-medium text-slate-500 mt-6">
            <span class="block">{{ trans('update.you_will_get_n_for_points',['amount' => handlePrice($earnByExchange) ,'points' => $availablePoints]) }}</span>
            <span class="block">{{ trans('update.the_amount_will_be_charged_to_your_wallet') }}</span>
            <span class="block">{{ trans('update.do_you_want_to_proceed') }}</span>
        </p>
    </div>

    <div class="flex items-center mt-25">
        <button type="button" class="js-apply-exchange btn btn-primary btn-sm grow">{{ trans('update.exchange') }}</button>
        <button type="button" class="close-swl btn bg-red-600 text-white ml-15 btn-sm grow">{{ trans('public.close') }}</button>
    </div>
</div>
