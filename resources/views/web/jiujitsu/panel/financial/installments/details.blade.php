@extends(getTemplate() .'.panel.layouts.panel_layout')

@section('content')

    @if(!empty($overdueInstallments) and count($overdueInstallments))
        <div class="flex items-center mb-20 p-15 danger-transparent-alert">
            <div class="danger-transparent-alert__icon flex items-center justify-center">
                <i data-feather="credit-card" width="18" height="18" class=""></i>
            </div>
            <div class="ml-10">
                <div class="text-sm font-bold ">{{ trans('update.overdue_installments') }}</div>
                <div class="text-sm ">{{ trans('update.you_have_count_overdue_installments_please_pay_them_to_avoid_restrictions_and_negative_effects_on_your_account',['count' => count($overdueInstallments)]) }}</div>
            </div>
        </div>
    @endif

    {{-- Installments Overview --}}
    <section>
        <h2 class="section-title">{{ trans('update.installments_overview') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/127.png" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $totalParts }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.total_parts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/38.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $remainedParts }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.remained_parts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/33.png" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ handlePrice($remainedAmount) }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.remained_amount') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/128.png" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ handlePrice($overdueAmount) }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.overdue_amount') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="mt-25">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('update.installments_list') }}</h2>
        </div>

        <div class="panel-section-card py-20 px-4 mt-4">
            <div class="row">
                <div class="col-12 ">
                    <div class="table-responsive">
                        <table class="table text-center custom-table">
                            <thead>
                            <tr>
                                <th>{{ trans('public.title') }}</th>
                                <th class="text-center">{{ trans('panel.amount') }}</th>
                                <th class="text-center">{{ trans('update.due_date') }}</th>
                                <th class="text-center">{{ trans('update.payment_date') }}</th>
                                <th class="text-center">{{ trans('public.status') }}</th>
                                <th class=""></th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(!empty($installment->upfront))
                                @php
                                    $upfrontPayment = $payments->where('type','upfront')->first();
                                @endphp
                                <tr>
                                    <td class="text-left">
                                        {{ trans('update.upfront') }}
                                        @if($installment->upfront_type == 'percent')
                                            <span class="ml-2">({{ $installment->upfront }}%)</span>
                                        @endif
                                    </td>

                                    <td class="text-center">{{ handlePrice($installment->getUpfront($itemPrice)) }}</td>

                                    <td class="text-center">-</td>

                                    <td class="text-center">{{ !empty($upfrontPayment) ? dateTimeFormat($upfrontPayment->created_at, 'j M Y H:i') : '-' }}</td>

                                    <td class="text-center">
                                        @if(!empty($upfrontPayment))
                                            <span class="text-primary">{{ trans('public.paid') }}</span>
                                        @else
                                            <span class="text-dark-blue">{{ trans('update.unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">

                                    </td>
                                </tr>
                            @endif

                            @foreach($installment->steps as $step)
                                @php
                                    $stepPayment = $payments->where('selected_installment_step_id', $step->id)->where('status', 'paid')->first();
                                    $dueAt = ($step->deadline * 86400) + $order->created_at;
                                    $isOverdue = ($dueAt < time() and empty($stepPayment));
                                @endphp

                                <tr>
                                    <td class="text-left">
                                        <div class="block font-16 font-medium text-dark-blue">
                                            {{ $step->title }}

                                            @if($step->amount_type == 'percent')
                                            <span class="ml-2 text-sm text-slate-500">({{ $step->amount }}%)</span>
                                            @endif
                                        </div>
                                        <span class="block text-sm text-slate-500">{{ trans('update.n_days_after_purchase', ['days' => $step->deadline]) }}</span>
                                    </td>

                                    <td class="text-center">{{ handlePrice($step->getPrice($itemPrice)) }}</td>

                                    <td class="text-center">
                                        <span class="{{ $isOverdue ? 'text-danger' : '' }}">{{ dateTimeFormat($dueAt, 'j M Y') }}</span>
                                    </td>

                                    <td class="text-center">{{ !empty($stepPayment) ? dateTimeFormat($stepPayment->created_at, 'j M Y H:i') : '-' }}</td>

                                    <td class="text-center">
                                        @if(!empty($stepPayment))
                                            <span class="text-primary">{{ trans('public.paid') }}</span>
                                        @else
                                            <span class="{{ $isOverdue ? 'text-danger' : 'text-dark-blue' }}">{{ trans('update.unpaid') }} {{ $isOverdue ? "(". trans('update.overdue') .")" : '' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if(empty($stepPayment))
                                            <div class="btn-group dropdown table-actions">
                                                <button type="button" class="btn-ghost dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i data-feather="more-vertical" height="20"></i>
                                                </button>
                                                <div class="dropdown-menu menu-lg">

                                                    <a href="/panel/financial/installments/{{ $order->id }}/steps/{{ $step->id }}/pay" target="_blank"
                                                       class="webinar-actions block mt-10 font-weight-normal">{{ trans('panel.pay') }}</a>
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
@endsection

@push('scripts_bottom')

@endpush
