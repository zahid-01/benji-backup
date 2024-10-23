@extends(getTemplate().'.layouts.fullwidth')

@push('styles_top')

@endpush

@section('content')
    <section class="cart-banner relative text-center">
        <h1 class="text-3xl text-white font-bold">{{ trans('cart.checkout') }}</h1>
        <span class="payment-hint font-20 text-white block">{{ handlePrice($total) . ' ' .  trans('cart.for_items',['count' => $count]) }}</span>
    </section>

    <section class="container mt-10">

        @if(!empty($totalCashbackAmount))
            <div class="flex items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon flex items-center justify-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="text-sm font-bold ">{{ trans('update.get_cashback') }}</div>
                    <div class="text-sm ">{{ trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback',['amount' => handlePrice($totalCashbackAmount)]) }}</div>
                </div>
            </div>
        @endif

        @php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        @endphp

        <h2 class="font-semibold text-lg mb-8">{{ trans('financial.select_a_payment_gateway') }}</h2>

        <form action="/payments/payment-request" method="post" class=" mt-25">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                @if(!empty($paymentChannels))
                    @foreach($paymentChannels as $paymentChannel)
                        @if(!$isMultiCurrency or (!empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)))
                            <div class="shadow rounded-lg cursor-pointer border-2 border-white hover:border-primary">
                                <input type="radio" name="gateway" class="hidden" id="{{ $paymentChannel->title }}" data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                                <label for="{{ $paymentChannel->title }}" class="rounded-sm p-6 lg:p-10 flex flex-col items-center justify-center cursor-pointer">
                                    <img src="{{ $paymentChannel->image }}" width="120" height="60" alt="">

                                    <p class="mt-6 mt-lg-50 font-medium text-dark-blue">
                                        {{ trans('financial.pay_via') }}
                                        <span class="font-bold text-sm">{{ $paymentChannel->title }}</span>
                                    </p>
                                </label>
                            </div>
                        @else
                            @php
                                $invalidChannels[] = $paymentChannel;
                            @endphp
                        @endif
                    @endforeach
                @endif

                <div class="shadow rounded-lg cursor-pointer border-2 border-white hover:border-primary">
                    <input type="radio" @if(empty($userCharge) or ($total > $userCharge)) disabled @endif name="gateway" class="hidden" id="offline" value="credit">
                    <label for="offline" class="rounded-sm p-6 lg:p-10 flex flex-col items-center justify-center cursor-pointer">
                        <img src="/assets/default/img/activity/pay.svg" width="100" height="60" alt="">

                        <p class="mt-2 mt-lg-50 font-medium text-dark-blue">
                            {{ trans('financial.account') }}
                            <span class="font-bold">{{ trans('financial.charge') }}</span>
                        </p>

                        <span class="mt-1">{{ handlePrice($userCharge) }}</span>
                    </label>
                </div>
            </div>

            @if(!empty($invalidChannels))
                <div class="flex items-center mt-6 rounded-lg border p-15">
                    <div class="size-40 flex-center rounded-full bg-gray200">
                        <i data-feather="info" class="text-slate-500" width="20" height="20"></i>
                    </div>
                    <div class="ml-2">
                        <h4 class="text-sm font-bold text-slate-500">{{ trans('update.disabled_payment_gateways') }}</h4>
                        <p class="text-sm text-slate-500">{{ trans('update.disabled_payment_gateways_hint') }}</p>
                    </div>
                </div>

                <div class="row mt-4">
                    @foreach($invalidChannels as $invalidChannel)
                        <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                            <div class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 flex flex-col items-center justify-center">
                                <img src="{{ $invalidChannel->image }}" width="120" height="60" alt="">

                                <p class="mt-6 mt-lg-50 font-medium text-dark-blue">
                                    {{ trans('financial.pay_via') }}
                                    <span class="font-bold text-sm">{{ $invalidChannel->title }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif


            <div class="flex items-center justify-between my-16">
                <span class="font-16 font-medium text-slate-500">{{ trans('financial.total_amount') }} {{ handlePrice($total) }}</span>
                <button type="button" id="paymentSubmit" disabled class="btn btn-sm btn-primary">{{ trans('public.start_payment') }}</button>
            </div>
        </form>

        @if(!empty($razorpay) and $razorpay)
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ env('RAZORPAY_API_KEY') }}"
                        data-amount="{{ (int)($order->total_amount * 100) }}"
                        data-buttontext="product_price"
                        data-description="Rozerpay"
                        data-currency="{{ currency() }}"
                        data-image="{{ $generalSettings['logo'] }}"
                        data-prefill.name="{{ $order->user->full_name }}"
                        data-prefill.email="{{ $order->user->email }}"
                        data-theme.color="#43d477">
                </script>
            </form>
        @endif
    </section>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
