@extends(getTemplate() . '.layouts.fullwidth')


@section('content')
    <section>
        <h1 class="text-3xl font-bold">{{ trans('cart.shopping_cart') }}</h1>
        {{-- <span class="payment-hint font-20 block"> {{ handlePrice($subTotal, true, true, false, null, true) . ' ' . trans('cart.for_items',['count' => $carts->count()]) }}</span> --}}
    </section>

    <div class="container">

        @if (!empty($totalCashbackAmount))
            <div class="flex items-center mt-45 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon flex items-center justify-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="text-sm font-bold ">{{ trans('update.get_cashback') }}</div>
                    <div class="text-sm ">
                        {{ trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback', ['amount' => handlePrice($totalCashbackAmount)]) }}
                    </div>
                </div>
            </div>
        @endif

        <section class="mt-10">
            {{-- <h2 class="section-title">{{ trans('cart.cart_items') }}</h2> --}}


            @if ($carts->count() > 0)
                {{-- <div class="row hidden d-mflex">
                        <div class="col-12 col-lg-8"><span
                                class="text-slate-500 font-medium">{{ trans('cart.item') }}</span></div>
                        <div class="col-6 col-lg-2 text-center"><span
                                class="text-slate-500 font-medium">{{ trans('public.price') }}</span></div>
                        <div class="col-6 col-lg-2 text-center"><span
                                class="text-slate-500 font-medium">{{ trans('public.remove') }}</span></div>
                    </div> --}}
            @endif
            @foreach ($carts as $cart)
                <div class="flex gap-x-6">
                    <figure class="w-full md:w-96 max-h-48 lg:h-48 relative rounded-xl">
                        @php
                            $cartItemInfo = $cart->getItemInfo();
                            $cartTaxType = !empty($cartItemInfo['isProduct']) ? 'store' : 'general';
                        @endphp
                        <img src="{{ $cartItemInfo['imgPath'] }}" class="rounded-xl h-full w-full" alt="user avatar">
                    </figure>
                    <div class="flex w-full justify-between">
                        <div class="flex flex-col gap-2">
                            <a href="{{ $cartItemInfo['itemUrl'] ?? '#!' }}" target="_blank">
                                <h3 class="font-16 font-bold text-dark-blue">{{ $cartItemInfo['title'] }}
                                </h3>
                            </a>

                            @if (!empty($cart->gift_id) and !empty($cart->gift))
                                <span class="block mt-5 text-slate-500 text-sm">{!! trans('update.a_gift_for_name_on_date', [
                                    'name' => $cart->gift->name,
                                    'date' => !empty($cart->gift->date) ? dateTimeFormat($cart->gift->date, 'j M Y H:i') : trans('update.instantly'),
                                ]) !!}
                            @endif


                            @if (!empty($cart->reserve_meeting_id))
                                <div class="mt-10">
                                    <span
                                        class="text-slate-500 text-sm border rounded-pill py-5 px-10">{{ $cart->reserveMeeting->day . ' ' . $cart->reserveMeeting->meetingTime->time }}
                                        ({{ $cart->reserveMeeting->meeting->getTimezone() }})
                                    </span>
                                </div>

                                @if ($cart->reserveMeeting->meeting->getTimezone() != getTimezone())
                                    <div class="mt-10">
                                        <span
                                            class="text-danger text-sm border border-danger rounded-pill py-5 px-10">{{ $cart->reserveMeeting->day . ' ' . dateTimeFormat($cart->reserveMeeting->start_at, 'h:iA', false) . '-' . dateTimeFormat($cart->reserveMeeting->end_at, 'h:iA', false) }}
                                            ({{ getTimezone() }})</span>
                                    </div>
                                @endif
                            @endif


                            @if (!empty($cartItemInfo['extraHint']))
                                <span class="text-slate-500 text-sm mt-auto">{{ $cartItemInfo['extraHint'] }}</span>
                            @endif

                            @if (!is_null($cartItemInfo['rate']))
                                @include('web.jiujitsu.includes.webinar.rate', [
                                    'rate' => $cartItemInfo['rate'],
                                ])
                            @endif
                            @if (!empty($cartItemInfo['profileUrl']) and !empty($cartItemInfo['teacherName']))
                                <span class="text-slate-500 text-sm mt-auto">
                                    {{ trans('public.by') }}
                                    <a href="{{ $cartItemInfo['profileUrl'] }}" target="_blank"
                                        class="text-slate-500 text-decoration-underline">{{ $cartItemInfo['teacherName'] }}</a>
                                </span>
                            @endif

                            <div class="flex mg:flex-col ">
                                <span class="text-slate-500 d-inline-block d-mhidden">{{ trans('public.price') }}
                                    :</span>

                                @if (!empty($cartItemInfo['discountPrice']))
                                    <span
                                        class="text-slate-500 line-through mx-3 mx-md-0">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                                    <span
                                        class="font-20 text-primary mt-0 mt-md-5 font-bold">{{ handlePrice($cartItemInfo['discountPrice'], true, true, false, null, true, $cartTaxType) }}</span>
                                @else
                                    <span
                                        class="font-20 text-primary mt-0 mt-md-5 font-bold">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                                @endif

                                @if (!empty($cartItemInfo['quantity']))
                                    <span
                                        class="text-sm text-warning font-medium mt-0 mt-md-5">({{ $cartItemInfo['quantity'] }}
                                        {{ trans('update.product') }})</span>
                                @endif

                                @if (!empty($cartItemInfo['extraPriceHint']))
                                    <span
                                        class="text-sm text-slate-500 font-medium mt-0 mt-md-5">{{ $cartItemInfo['extraPriceHint'] }}</span>
                                @endif
                            </div>

                            <div class="col-6 col-lg-2 flex flex-md-column">
                                {{-- <span
                                        class="text-slate-500 d-inline-block d-mhidden mr-10 mr-md-0">{{ trans('public.remove') }}
                                        :</span>
        
                                    <a href="/cart/{{ $cart->id }}/delete"
                                        class="delete-action btn-cart-list-delete flex items-center justify-center">
                                        <i data-feather="x" width="20" height="20" class=""></i>
                                    </a> --}}
                                <button class="btn btn-outline mt-3 btn-sm">{{ trans('public.remove') }}</button>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="webinar-card-body p-0 w-full h-100 flex flex-col">
                            <div class="flex flex-col"> --}}
                    {{-- <button type="button" onclick="window.history.back()"
                                            class="btn btn-primary mt-25 w-32">{{ trans('cart.continue_shopping') }}</button> --}}
                    {{-- </div>
                        </div> --}}


                    {{-- <div class="col-8">
                                </div> --}}

                    {{-- 
                        <div class="col-6 col-lg-2 flex flex-md-column items-center justify-center">
                            <span class="text-slate-500 d-inline-block d-mhidden">{{ trans('public.price') }} :</span>

                            @if (!empty($cartItemInfo['discountPrice']))
                                <span
                                    class="text-slate-500 line-through mx-10 mx-md-0">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                                <span
                                    class="font-20 text-primary mt-0 mt-md-5 font-bold">{{ handlePrice($cartItemInfo['discountPrice'], true, true, false, null, true, $cartTaxType) }}</span>
                            @else
                                <span
                                    class="font-20 text-primary mt-0 mt-md-5 font-bold">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                            @endif

                            @if (!empty($cartItemInfo['quantity']))
                                <span
                                    class="text-sm text-warning font-medium mt-0 mt-md-5">({{ $cartItemInfo['quantity'] }}
                                    {{ trans('update.product') }})</span>
                            @endif

                            @if (!empty($cartItemInfo['extraPriceHint']))
                                <span
                                    class="text-sm text-slate-500 font-medium mt-0 mt-md-5">{{ $cartItemInfo['extraPriceHint'] }}</span>
                            @endif
                        </div>

                        <div class="col-6 col-lg-2 flex flex-md-column items-center justify-center">
                            <span
                                class="text-slate-500 d-inline-block d-mhidden mr-10 mr-md-0">{{ trans('public.remove') }}
                                :</span>

                            <a href="/cart/{{ $cart->id }}/delete"
                                class="delete-action btn-cart-list-delete flex items-center justify-center">
                                <i data-feather="x" width="20" height="20" class=""></i>
                            </a>
                        </div> --}}
                </div>
            @endforeach

            {{-- <button type="button" onclick="window.history.back()"
                    class="btn btn-sm btn-primary mt-25">{{ trans('cart.continue_shopping') }}</button> --}}

        </section>

        <form action="/cart/checkout" method="post" id="cartForm">
            {{ csrf_field() }}
            <input type="hidden" name="discount_id" value="">

            @if ($hasPhysicalProduct)
                @include('web.jiujitsu.cart.includes.shipping_and_delivery')
            @endif

            <div class="grid grid-cols-2">
                <div class="hidden md:block">&nbsp;</div>
                {{-- <div class="col-12 col-lg-6">
                    <section class="mt-45">
                        <h3 class="section-title">{{ trans('cart.coupon_code') }}</h3>
                        <div class="rounded-sm shadow mt-4 py-25 px-20">
                            <p class="text-slate-500 text-sm">{{ trans('cart.coupon_code_hint') }}</p>

                            @if (!empty($userGroup) and !empty($userGroup->discount))
                                <p class="text-slate-500 mt-25">{{ trans('cart.in_user_group',['group_name' => $userGroup->name , 'percent' => $userGroup->discount]) }}</p>
                            @endif

                            <form action="/carts/coupon/validate" method="Post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" name="coupon" id="coupon_input" class="form-control mt-25"
                                           placeholder="{{ trans('cart.enter_your_code_here') }}">
                                    <span class="invalid-feedback">{{ trans('cart.coupon_invalid') }}</span>
                                    <span class="valid-feedback">{{ trans('cart.coupon_valid') }}</span>
                                </div>

                                <button type="submit" id="checkCoupon"
                                        class="btn btn-sm btn-primary mt-50">{{ trans('cart.validate') }}</button>
                            </form>
                        </div>
                    </section>
                </div> --}}


                <section class="mt-16">
                    <h3 class="font-semibold text-lg">{{ trans('cart.cart_totals') }}</h3>
                    <div class="rounded-sm mt-4 pb-20">

                        <div class="flex p-4 border-b justify-between border-slate-300">
                            <h4 class="text-black text-sm font-medium">{{ trans('cart.sub_total') }}</h4>
                            <span class="text-sm text-slate-500 font-bold">{{ handlePrice($subTotal) }}</span>
                        </div>

                        <div class="flex p-4 border-b justify-between border-slate-300">
                            <h4 class="text-black text-sm font-medium">{{ trans('public.discount') }}</h4>
                            <span class="text-sm text-slate-500 font-bold">
                                <span id="totalDiscount">{{ handlePrice($totalDiscount) }}</span>
                            </span>
                        </div>

                        <div class="flex p-4 border-b justify-between border-slate-300">
                            <h4 class="text-black text-sm font-medium">{{ trans('cart.tax') }}
                                @if (!$taxIsDifferent)
                                    <span class="text-sm text-slate-500 ">({{ $tax }}%)</span>
                                @endif
                            </h4>
                            <span class="text-sm text-slate-500 font-bold"><span
                                    id="taxPrice">{{ handlePrice($taxPrice) }}</span></span>
                        </div>

                        @if (!empty($productDeliveryFee))
                            <div class="flex p-4 border-b justify-between border-slate-300">
                                <h4 class="text-black text-sm font-medium">
                                    {{ trans('update.delivery_fee') }}
                                </h4>
                                <span class="text-sm text-slate-500 font-bold"><span
                                        id="taxPrice">{{ handlePrice($productDeliveryFee) }}</span></span>
                            </div>
                        @endif

                        <div class="flex p-4 border-b justify-between border-slate-300">
                            <h4 class="text-black text-sm font-medium">{{ trans('cart.total') }}</h4>
                            <span class="text-sm text-slate-500 font-bold"><span
                                    id="totalAmount">{{ handlePrice($total) }}</span></span>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary mt-14">{{ trans('cart.checkout') }}</button>
                        </div>
                    </div>
                </section>

            </div>
        </form>
    </div>
@endsection

@push('scripts_bottom')
    <script>
        var couponInvalidLng = '{{ trans('cart.coupon_invalid') }}';
        var selectProvinceLang = '{{ trans('update.select_province') }}';
        var selectCityLang = '{{ trans('update.select_city') }}';
        var selectDistrictLang = '{{ trans('update.select_district') }}';
    </script>

    <script src="/assets/default/js/parts/get-regions.min.js"></script>
    <script src="/assets/default/js/parts/cart.min.js"></script>
@endpush
