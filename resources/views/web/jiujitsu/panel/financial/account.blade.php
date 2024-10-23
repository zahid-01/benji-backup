@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')

    {{-- Cashback Alert --}}
    @if(!empty($cashbackRules) and count($cashbackRules))
        @foreach($cashbackRules as $cashbackRule)
            <div class="flex items-center mb-20 p-15 success-transparent-alert {{ $classNames ?? '' }}">
                <div class="success-transparent-alert__icon flex items-center justify-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="text-sm font-bold ">{{ trans('update.get_cashback') }}</div>

                    <div class="text-sm ">{{ trans('update.by_charging_your_wallet_will_get_amount_as_cashback',['amount' => ($cashbackRule->amount_type == 'percent' ? "%{$cashbackRule->amount}" : handlePrice($cashbackRule->amount))]) }}</div>
                </div>
            </div>
        @endforeach
    @endif



    @if(!empty($registrationBonusAmount))
        <div class="mb-25 flex items-center justify-between p-15 bg-white panel-shadow">
            <div class="flex items-center">
                <img src="/assets/default/img/icons/money.png" alt="money" width="51" height="51">

                <div class="ml-15">
                    <span class="block font-16 text-dark font-bold">{{ trans('update.unlock_registration_bonus') }}</span>
                    <span class="block text-sm text-slate-500 font-medium mt-5">{{ trans('update.your_wallet_includes_amount_registration_bonus_This_amount_is_locked',['amount' => handlePrice($registrationBonusAmount)]) }}</span>
                </div>
            </div>

            <a href="/panel/marketing/registration_bonus" class="btn btn-border-gray300">{{ trans('update.view_more') }}</a>
        </div>
    @endif

    <section>
        <h2 class="section-title">{{ trans('financial.account_summary') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/36.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $accountCharge ? handlePrice($accountCharge) : 0 }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('financial.account_charge') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/37.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $readyPayout ? handlePrice($readyPayout) : 0 }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('financial.ready_to_payout') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/38.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $totalIncome ? handlePrice($totalIncome) : 0 }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('financial.total_income') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @if (\Session::has('msg'))
        <div class="alert alert-warning">
            <ul>
                <li>{!! \Session::get('msg') !!}</li>
            </ul>
        </div>
    @endif

    @php
        $showOfflineFields = false;
        if ($errors->has('date') or $errors->has('referral_code') or $errors->has('account') or !empty($editOfflinePayment)) {
            $showOfflineFields = true;
        }

        $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
        $userCurrency = currency();
        $invalidChannels = [];
    @endphp

    <section class="mt-6">
        <h2 class="section-title">{{ trans('financial.select_the_payment_gateway') }}</h2>

        <form action="/panel/financial/{{ !empty($editOfflinePayment) ? 'offline-payments/'. $editOfflinePayment->id .'/update' : 'charge' }}" method="post" enctype="multipart/form-data" class="mt-25">
            {{csrf_field()}}

            @if($errors->has('gateway'))
                <div class="text-danger mb-3">{{ $errors->first('gateway') }}</div>
            @endif

            <div class="row">
                @foreach($paymentChannels as $paymentChannel)
                    @if(!$isMultiCurrency or (!empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)))
                        <div class="col-6 col-lg-3 mb-40 charge-account-radio">
                            <input type="radio" class="online-gateway" name="gateway" id="{{ $paymentChannel->class_name }}" @if(old('gateway') == $paymentChannel->class_name) checked @endif value="{{ $paymentChannel->class_name }}">
                            <label for="{{ $paymentChannel->class_name }}" class="rounded-sm p-20 p-lg-45 flex flex-col items-center justify-center">
                                <img src="{{ $paymentChannel->image }}" width="120" height="60" alt="">
                                <p class="mt-6 text-sm font-medium text-dark-blue">{{ trans('financial.pay_via') }}
                                    <span class="font-bold">{{ $paymentChannel->title }}</span>
                                </p>
                            </label>
                        </div>
                    @else
                        @php
                            $invalidChannels[] = $paymentChannel;
                        @endphp
                    @endif
                @endforeach

                @if(!empty(getOfflineBankSettings('offline_banks_status')))
                    <div class="col-6 col-lg-3 mb-40 charge-account-radio">
                        <input type="radio" name="gateway" id="offline" value="offline" @if(old('gateway') == 'offline' or !empty($editOfflinePayment)) checked @endif>
                        <label for="offline" class="rounded-sm p-20 p-lg-45 flex flex-col items-center justify-center">
                            <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">
                            <p class="mt-6 text-sm font-medium text-dark-blue">{{ trans('financial.pay_via') }}
                                <span class="font-bold">{{ trans('financial.offline') }}</span>
                            </p>
                        </label>
                    </div>
                @endif
            </div>

            @if(!empty($invalidChannels))
                <div class="flex items-center rounded-lg border p-15">
                    <div class="size-40 flex-center rounded-full bg-gray200">
                        <i data-feather="gift" class="text-slate-500" width="20" height="20"></i>
                    </div>
                    <div class="ml-2">
                        <h4 class="text-sm font-bold text-slate-500">{{ trans('update.disabled_payment_gateways') }}</h4>
                        <p class="text-sm text-slate-500">{{ trans('update.disabled_payment_gateways_hint') }}</p>
                    </div>
                </div>

                <div class="row mt-4">
                    @foreach($invalidChannels as $invalidChannel)
                        <div class="col-6 col-lg-3 mb-40 charge-account-radio">
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

            <div class="">
                <h3 class="section-title mb-20">{{ trans('financial.finalize_payment') }}</h3>

                <div class="row">
                    <div class="col-12 col-lg-3 mb-25 mb-lg-0">
                        <label class="font-medium text-sm text-dark-blue block">{{ trans('panel.amount') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-white font-16">
                                    {{--<i data-feather="dollar-sign" width="18" height="18" class="text-white"></i>--}}
                                    {{ $currency }}
                                </span>
                            </div>
                            <input type="number" name="amount" min="0" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ !empty($editOfflinePayment) ? $editOfflinePayment->amount : old('amount') }}"
                                   placeholder="{{ trans('panel.number_only') }}"/>
                            <div class="invalid-feedback">@error('amount') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="{{ (!$showOfflineFields) ? 'display:none' : '' }}">
                        <div class="form-group">
                            <label class="input-label">{{ trans('financial.account') }}</label>
                            <select name="account" class="form-control @error('account') is-invalid @enderror">
                                <option selected disabled>{{ trans('financial.select_the_account') }}</option>

                                @foreach($offlineBanks as $offlineBank)
                                    <option value="{{ $offlineBank->id }}" @if(!empty($editOfflinePayment) and $editOfflinePayment->offline_bank_id == $offlineBank->id) selected @endif>{{ $offlineBank->title }}</option>
                                @endforeach
                            </select>

                            @error('account')
                            <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="{{ (!$showOfflineFields) ? 'display:none' : '' }}">
                        <div class="form-group">
                            <label for="referralCode" class="input-label">{{ trans('admin/main.referral_code') }}</label>
                            <input type="text" name="referral_code" id="referralCode" value="{{ !empty($editOfflinePayment) ? $editOfflinePayment->reference_number : old('referral_code') }}" class="form-control @error('referral_code') is-invalid @enderror"/>
                            @error('referral_code')
                            <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="{{ (!$showOfflineFields) ? 'display:none' : '' }}">
                        <div class="form-group">
                            <label class="input-label">{{ trans('public.date_time') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="dateRangeLabel">
                                        <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" value="{{ !empty($editOfflinePayment) ? dateTimeFormat($editOfflinePayment->pay_date, 'Y-m-d H:i', false) : old('date') }}" class="form-control datetimepicker @error('date') is-invalid @enderror"
                                       aria-describedby="dateRangeLabel"/>
                                @error('date')
                                <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-25 mb-lg-0 js-offline-payment-input " style="{{ (!$showOfflineFields) ? 'display:none' : '' }}">
                        <div class="form-group">
                            <label class="input-label">{{ trans('update.attach_the_payment_photo') }}</label>

                            <label for="attachmentFile" id="attachmentFileLabel" class="custom-upload-input-group">
                                <span class="custom-upload-icon text-white">
                                    <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                </span>
                                <div class="custom-upload-input"></div>
                            </label>

                            <input type="file" name="attachment" id="attachmentFile"
                                   class="form-control h-auto invisible-file-input @error('attachment') is-invalid @enderror"
                                   value=""/>
                            @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="mt-6">
                            <button type="button" id="submitChargeAccountForm" class="btn btn-primary btn-sm">{{ trans('public.pay') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="mt-14">
        <h2 class="section-title">{{ trans('financial.bank_accounts_information') }}</h2>

        <div class="row mt-25">
            @foreach($offlineBanks as $offlineBank)
                <div class="col-12 col-lg-3 mb-30 mb-lg-0">
                    <div class="py-25 px-20 rounded-sm panel-shadow flex flex-col items-center justify-center">
                        <img src="{{ $offlineBank->logo }}" width="120" height="60" alt="">

                        <div class="mt-15 mt-6 w-full">

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-black">{{ trans('public.name') }}:</span>
                                <span class="text-sm font-medium text-slate-500">{{ $offlineBank->title }}</span>
                            </div>

                            @foreach($offlineBank->specifications as $specification)
                                <div class="flex items-center justify-between mt-10">
                                    <span class="text-sm font-medium text-black">{{ $specification->name }}:</span>
                                    <span class="text-sm font-medium text-slate-500">{{ $specification->value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @if($offlinePayments->count() > 0)
        <section class="mt-14">
            <h2 class="section-title">{{ trans('financial.offline_transactions_history') }}</h2>

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th>{{ trans('financial.bank') }}</th>
                                    <th>{{ trans('admin/main.referral_code') }}</th>
                                    <th class="text-center">{{ trans('panel.amount') }} ({{ $currency }})</th>
                                    <th class="text-center">{{ trans('update.attachment') }}</th>
                                    <th class="text-center">{{ trans('public.status') }}</th>
                                    <th class="text-right">{{ trans('public.controls') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($offlinePayments as $offlinePayment)
                                    <tr>
                                        <td class="text-left">
                                            <div class="flex flex-col">

                                                @if(!empty($offlinePayment->offlineBank))
                                                    <span class="font-medium text-dark-blue">{{ $offlinePayment->offlineBank->title }}</span>
                                                @else
                                                    <span class="font-medium text-dark-blue">-</span>
                                                @endif
                                                <span class="text-sm text-slate-500">{{ dateTimeFormat($offlinePayment->pay_date, 'j M Y H:i') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-left align-middle">
                                            <span>{{ $offlinePayment->reference_number }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="font-16 font-bold text-primary">{{ handlePrice($offlinePayment->amount, false) }}</span>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if(!empty($offlinePayment->attachment))
                                                <a href="{{ $offlinePayment->getAttachmentPath() }}" target="_blank" class="text-primary">{{ trans('public.view') }}</a>
                                            @else
                                                ---
                                            @endif
                                        </td>

                                        <td class="text-center align-middle">
                                            @switch($offlinePayment->status)
                                                @case(\App\Models\OfflinePayment::$waiting)
                                                    <span class="text-warning">{{ trans('public.waiting') }}</span>
                                                    @break
                                                @case(\App\Models\OfflinePayment::$approved)
                                                    <span class="text-primary">{{ trans('financial.approved') }}</span>
                                                    @break
                                                @case(\App\Models\OfflinePayment::$reject)
                                                    <span class="text-danger">{{ trans('public.rejected') }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="text-right align-middle">
                                            @if($offlinePayment->status != 'approved')
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-ghost dropdown-toggle"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-vertical" height="20"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="/panel/financial/offline-payments/{{ $offlinePayment->id }}/edit"
                                                           class="webinar-actions block mt-10">{{ trans('public.edit') }}</a>
                                                        <a href="/panel/financial/offline-payments/{{ $offlinePayment->id }}/delete" data-item-id="1"
                                                           class="webinar-actions block mt-10 delete-action">{{ trans('public.delete') }}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    @else

        @include(getTemplate() . '.includes.no-result',[
            'file_name' => 'offline.png',
            'title' => trans('financial.offline_no_result'),
            'hint' => nl2br(trans('financial.offline_no_result_hint')),
        ])

    @endif
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

    <script src="/assets/default/js/panel/financial/account.min.js"></script>

    <script>
        (function ($) {
            "use strict";

            @if(session()->has('sweetalert'))
            Swal.fire({
                icon: "{{ session()->get('sweetalert')['status'] ?? 'success' }}",
                html: '<h3 class="font-20 text-center text-dark-blue py-25">{{ session()->get('sweetalert')['msg'] ?? '' }}</h3>',
                showConfirmButton: false,
                width: '25rem',
            });
            @endif
        })(jQuery)
    </script>
@endpush
