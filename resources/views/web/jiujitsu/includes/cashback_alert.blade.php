@if(!empty($cashbackRules) and count($cashbackRules) and !empty($itemPrice) and $itemPrice > 0)
    @foreach($cashbackRules as $cashbackRule)
        <div class="flex items-center mt-4 p-15 success-transparent-alert {{ $classNames ?? '' }}">
            <div class="success-transparent-alert__icon flex items-center justify-center">
                <i data-feather="credit-card" width="18" height="18" class=""></i>
            </div>

            <div class="ml-10">
                <div class="text-sm font-bold ">{{ trans('update.get_cashback') }}</div>

                @if(!empty($itemType) and $itemType == 'meeting')
                    @if($cashbackRule->min_amount)
                        <div class="text-sm ">{{ trans('update.by_reserving_a_this_meeting_you_will_get_amount_as_cashback_for_orders_more_than_min_amount',['amount' => handlePrice($cashbackRule->getAmount($itemPrice)), 'min_amount' => handlePrice($cashbackRule->min_amount)]) }}</div>
                    @else
                        <div class="text-sm ">{{ trans('update.by_reserving_a_this_meeting_you_will_get_amount_as_cashback',['amount' => handlePrice($cashbackRule->getAmount($itemPrice))]) }}</div>
                    @endif
                @else
                    @if($cashbackRule->min_amount)
                        <div class="text-sm ">{{ trans('update.by_purchasing_this_product_you_will_get_amount_as_cashback_for_orders_more_than_min_amount',['amount' => handlePrice($cashbackRule->getAmount($itemPrice)), 'min_amount' => handlePrice($cashbackRule->min_amount)]) }}</div>
                    @else
                        <div class="text-sm ">{{ trans('update.by_purchasing_this_product_you_will_get_amount_as_cashback',['amount' => handlePrice($cashbackRule->getAmount($itemPrice))]) }}</div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endif
