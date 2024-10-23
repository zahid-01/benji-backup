<div class="installment-card p-15 mt-4">
    <div class="row">
        <div class="col-8">
            <h4 class="font-16 font-bold text-dark-blue">{{ $installment->main_title }}</h4>

            <div class="">
                <p class="text-slate-500 text-sm text-ellipsis">{{ nl2br($installment->description) }}</p>
            </div>

            @if(!empty($installment->capacity))
                @php
                    $reachedCapacityPercent = $installment->reachedCapacityPercent();
                @endphp

                @if($reachedCapacityPercent > 0)
                    <div class="mt-4 flex items-center">
                        <div class="progress card-progress grow">
                            <span class="progress-bar rounded-sm {{ $reachedCapacityPercent > 50 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ $reachedCapacityPercent }}%"></span>
                        </div>
                        <div class="ml-10 text-sm text-danger">{{ trans('update.percent_capacity_reached',['percent' => $reachedCapacityPercent]) }}</div>
                    </div>
                @endif
            @endif

            @if(!empty($installment->banner))
                <div class="mt-4">
                    <img src="{{ $installment->banner }}" alt="{{ $installment->main_title }}" class="img-fluid">
                </div>
            @endif

            @if(!empty($installment->options))
                <div class="mt-4">
                    @php
                        $installmentOptions = explode(\App\Models\Installment::$optionsExplodeKey, $installment->options);
                    @endphp

                    @foreach($installmentOptions as $installmentOption)
                        <div class="flex items-center mb-1">
                            <i data-feather="check" width="25" height="25" class="text-primary"></i>
                            <span class="ml-10 text-sm text-slate-500">{{ $installmentOption }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-4 p-0 pr-15">
            <div class="installment-card__payments flex flex-col w-full h-100">

                @php
                    $totalPayments = $installment->totalPayments($itemPrice ?? 1);
                    $installmentTotalInterest = $installment->totalInterest($itemPrice, $totalPayments);
                @endphp

                <div class="flex items-center justify-center flex-col">
                    <span class="font-36 font-bold text-primary">{{ handlePrice($totalPayments) }}</span>
                    <span class="mt-10 text-sm text-slate-500">{{ trans('update.total_payment') }} @if($installmentTotalInterest > 0)
                            ({{ trans('update.percent_interest',['percent' => $installmentTotalInterest]) }})
                        @endif</span>
                </div>

                <div class="mt-25 mb-15">
                    <div class="installment-step flex items-center text-sm text-slate-500">{{ !empty($installment->upfront) ? (trans('update.amount_upfront',['amount' => handlePrice($installment->getUpfront($itemPrice))]) . ($installment->upfront_type == "percent" ? " ({$installment->upfront}%)" : '')) : trans('update.no_upfront') }}</div>

                    @foreach($installment->steps as $installmentStep)
                        <div class="installment-step flex items-center text-sm text-slate-500">{{ $installmentStep->getDeadlineTitle($itemPrice) }}</div>
                    @endforeach
                </div>

                <a href="/installments/{{ $installment->id }}?item={{ $itemId }}&item_type={{ $itemType }}&{{ http_build_query(request()->all()) }}" target="_blank" class="btn btn-primary btn-block mt-auto">{{ trans('update.pay_with_installments') }}</a>
            </div>
        </div>
    </div>
</div>
