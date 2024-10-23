<div class="special-offer-card flex flex-col flex-md-row items-center justify-between rounded-lg shadow-xs bg-white p-15 p-md-30">
    <div class="flex flex-col">
        <strong class="special-offer-title font-16 text-dark-blue font-bold">{{ trans('panel.special_offer') }}</strong>
        <span class="text-sm text-slate-500">{{ $activeSpecialOffer->name }}</span>
    </div>

    <div class="mt-4 mt-md-0 mb-30 mb-md-0">
        @php
            $remainingTimes = $activeSpecialOffer->getRemainingTimes()
        @endphp
        <div id="offerCountDown" class="flex time-counter-down"
             data-day="{{ $remainingTimes['day'] }}"
             data-hour="{{ $remainingTimes['hour'] }}"
             data-minute="{{ $remainingTimes['minute'] }}"
             data-second="{{ $remainingTimes['second'] }}">

            <div class="flex items-center flex-col mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-bold text-dark time-item days"></span>
                <span class="text-sm mt-1 text-slate-500">{{ trans('public.day') }}</span>
            </div>
            <div class="flex items-center flex-col mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-bold text-dark time-item hours"></span>
                <span class="text-sm mt-1 text-slate-500">{{ trans('public.hr') }}</span>
            </div>
            <div class="flex items-center flex-col mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-bold text-dark time-item minutes"></span>
                <span class="text-sm mt-1 text-slate-500">{{ trans('public.min') }}</span>
            </div>
            <div class="flex items-center flex-col">
                <span class="bg-gray300 rounded p-10 font-16 font-bold text-dark time-item seconds"></span>
                <span class="text-sm mt-1 text-slate-500">{{ trans('public.sec') }}</span>
            </div>
        </div>
    </div>

    <div class="offer-percent-box flex flex-col items-center justify-center">
        <span class="percent text-white">{{ $activeSpecialOffer->percent }}%</span>
        <span class="off text-white">{{ trans('public.off') }}</span>
    </div>
</div>
