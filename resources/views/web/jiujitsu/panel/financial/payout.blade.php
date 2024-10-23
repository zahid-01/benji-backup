@extends(getTemplate() .'.panel.layouts.panel_layout')

@section('content')
    <section>
        <h2 class="section-title">{{ trans('financial.account_summary') }}</h2>

        @if(!$authUser->financial_approval)
            <div class="p-15 mt-4 p-lg-20 not-verified-alert font-medium text-dark-blue rounded-sm panel-shadow">
                {{ trans('panel.not_verified_alert') }}
                <a href="/panel/setting/step/7" class="text-decoration-underline">{{ trans('panel.this_link') }}</a>.
            </div>
        @endif

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
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ handlePrice($readyPayout ?? 0) }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('financial.ready_to_payout') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/38.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ handlePrice($totalIncome ?? 0) }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('financial.total_income') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="mt-45">
        <button type="button" @if(!$authUser->financial_approval) disabled @endif class="request-payout btn btn-sm btn-primary">{{ trans('financial.request_payout') }}</button>
    </div>

    @if($payouts->count() > 0)
        <section class="mt-8">
            <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
                <h2 class="section-title">{{ trans('financial.payouts_history') }}</h2>
            </div>

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th>{{ trans('financial.account') }}</th>
                                    <th class="text-center">{{ trans('public.type') }}</th>
                                    <th class="text-center">{{ trans('panel.amount') }} ({{ $currency }})</th>
                                    <th class="text-center">{{ trans('public.status') }}</th>
                                    <th class="text-center">{{ trans('admin/main.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($payouts as $payout)
                                    <tr>
                                        <td>
                                            <div class="text-left">
                                            @if(!empty($payout->userSelectedBank->bank))
                                                <span class="block font-medium text-dark-blue">{{ $payout->userSelectedBank->bank->title }}</span>
                                                @else
                                                <span class="block font-medium text-dark-blue">-</span>
                                                @endif
                                                <span class="block text-sm text-slate-500 mt-1">{{ dateTimeFormat($payout->created_at, 'j M Y | H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span>{{ trans('public.manual') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-primary font-bold">{{ handlePrice($payout->amount, false) }}</span>
                                        </td>
                                        <td>
                                            @switch($payout->status)
                                                @case(\App\Models\Payout::$waiting)
                                                    <span class="text-warning font-bold">{{ trans('public.waiting') }}</span>
                                                    @break;
                                                @case(\App\Models\Payout::$reject)
                                                    <span class="text-danger font-bold">{{ trans('public.rejected') }}</span>
                                                    @break;
                                                @case(\App\Models\Payout::$done)
                                                    <span class="">{{ trans('public.done') }}</span>
                                                    @break;
                                            @endswitch
                                        </td>

                                        <td>
                                            {{-- For Modal --}}
                                             @if(!empty($payout->userSelectedBank->bank))
                                            @php
                                                $bank = $payout->userSelectedBank->bank;
                                            @endphp
                                             @endif
                                             
                                             @if(!empty($bank->title))
                                            <input type="hidden" class="js-bank-details" data-name="{{ trans("admin/main.bank") }}" value="{{ $bank->title }}">
                                            @foreach($bank->specifications as $specification)
                                                @php
                                                    $selectedBankSpecification = $payout->userSelectedBank->specifications->where('user_selected_bank_id', $payout->userSelectedBank->id)->where('user_bank_specification_id', $specification->id)->first();
                                                @endphp

                                                @if(!empty($selectedBankSpecification))
                                                    <input type="hidden" class="js-bank-details" data-name="{{ $specification->name }}" value="{{ $selectedBankSpecification->value }}">
                                                @endif
                                            @endforeach
                                            @endif
                                            

                                            <button type="button" class="js-show-details btn-ghost btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('update.show_details') }}">
                                                <i data-feather="eye" width="18" class=""></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="my-30">
                {{ $payouts->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    @else
        @include(getTemplate() . '.includes.no-result',[
            'file_name' => 'payout.png',
            'title' => trans('financial.payout_no_result'),
            'hint' => nl2br(trans('financial.payout_no_result_hint')),
        ])

    @endif


    <div id="requestPayoutModal" class="hidden">
        <h3 class="section-title after-line font-20 text-dark-blue mb-25">{{ trans('financial.payout_confirmation') }}</h3>
        <p class="text-slate-500 mt-15">{{ trans('financial.payout_confirmation_hint') }}</p>

        <form method="post" action="/panel/financial/request-payout">
            {{ csrf_field() }}
            <div class="row justify-center">
                <div class="w-75 mt-50">
                    <div class="flex items-center justify-between text-slate-500">
                        <span class="font-bold">{{ trans('financial.ready_to_payout') }}</span>
                        <span>{{ handlePrice($readyPayout ?? 0) }}</span>
                    </div>

                    @if(!empty($authUser->selectedBank) and !empty($authUser->selectedBank->bank))
                        <div class="flex items-center justify-between text-slate-500 mt-4">
                            <span class="font-bold">{{ trans('financial.account_type') }}</span>
                            <span>{{ $authUser->selectedBank->bank->title }}</span>
                        </div>

                        @foreach($authUser->selectedBank->bank->specifications as $specification)
                            @php
                                $selectedBankSpecification = $authUser->selectedBank->specifications->where('user_selected_bank_id', $authUser->selectedBank->id)->where('user_bank_specification_id', $specification->id)->first();
                            @endphp

                            <div class="flex items-center justify-between text-slate-500 mt-4">
                                <span class="font-bold">{{ $specification->name }}</span>
                                <span>{{ (!empty($selectedBankSpecification)) ? $selectedBankSpecification->value : '' }}</span>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>

            <div class="mt-50 flex items-center justify-end">
                <button type="button" class="js-submit-payout btn btn-sm btn-primary">{{ trans('financial.request_payout') }}</button>
                <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts_bottom')
    <script>
        var payoutDetailsLang = '{{ trans('update.payout_details') }}';
        var closeLang = '{{ trans('public.close') }}';
    </script>

    <script src="/assets/default/js/panel/financial/payout.min.js"></script>
@endpush
