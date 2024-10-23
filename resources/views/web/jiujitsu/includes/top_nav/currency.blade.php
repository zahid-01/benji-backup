@if(!empty($currencies) and count($currencies))
    @php
        $userCurrency = currency();
    @endphp

    <div class="js-currency-select custom-dropdown relative">
        <form action="/set-currency" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="currency" value="{{ $userCurrency }}">
            @if(!empty($previousUrl))
                <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
            @endif

            @foreach($currencies as $currencyItem)
                @if($userCurrency == $currencyItem->currency)
                    <div class="custom-dropdown-toggle flex items-center cursor-pointer">
                        <div class="mr-5 text-black">
                            <span class="js-lang-title text-sm">{{ $currencyItem->currency }} ({{ currencySign($currencyItem->currency) }})</span>
                        </div>
                        <i data-feather="chevron-down" class="icons" width="14px" height="14px"></i>
                    </div>
                @endif
            @endforeach
        </form>

        <div class="custom-dropdown-body py-10">

            @foreach($currencies as $currencyItem)
                <div class="js-currency-dropdown-item custom-dropdown-body__item cursor-pointer {{ ($userCurrency == $currencyItem->currency) ? 'active' : '' }}" data-value="{{ $currencyItem->currency }}" data-title="{{ $currencyItem->currency }} ({{ currencySign($currencyItem->currency) }})">
                    <div class=" flex items-center w-full px-15 py-5 text-slate-500 bg-transparent">
                        <div class="size-32 relative flex-center bg-gray100 rounded-sm">
                            {{ currencySign($currencyItem->currency) }}
                        </div>

                        <span class="ml-2 text-sm">{{ currenciesLists($currencyItem->currency) }}</span>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endif
