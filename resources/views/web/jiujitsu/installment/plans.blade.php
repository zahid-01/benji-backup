@extends('web.jiujitsu.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')
    <div class="container pt-50 mt-10">
        <div class="text-center">
            <h1 class="font-36">{{ trans('update.select_an_installment_plan') }}</h1>
            <p class="mt-10 font-16 text-slate-500">{{ trans('update.please_select_an_installment_plan_in_order_to_finalize_your_purchase') }}</p>
        </div>

        <div class="flex items-center flex-col flex-lg-row mt-50 border rounded-lg p-15 p-lg-25">
            <div class="default-package-icon">
                <img src="/assets/default/img/become-instructor/default.png" class="img-cover" alt="{{ trans('update.installment_overview') }}" width="176" height="144">
            </div>

            <div class="ml-lg-25 w-full mt-4 mt-lg-0">
                <h2 class="font-24 font-bold text-dark-blue">{{ $overviewTitle }}</h2>

                <div class="flex flex-wrap items-center justify-between w-full">

                    <div class="flex items-center mt-4">
                        <i data-feather="check-square" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ handlePrice($cash) }} {{ trans('update.cash') }}</span>
                    </div>

                    <div class="flex items-center mt-4">
                        <i data-feather="menu" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ $plansCount }} {{ trans('update.installment_plans') }}</span>
                    </div>

                    <div class="flex items-center mt-4">
                        <i data-feather="dollar-sign" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ handlePrice($minimumAmount) }} {{ trans('update.minimum_installment_amount') }}</span>
                    </div>

                </div>
            </div>
        </div>

        @foreach($installments as $installmentRow)
            @include('web.jiujitsu.installment.card',['installment' => $installmentRow, 'itemPrice' => $itemPrice, 'itemId' => $itemId, 'itemType' => $itemType])
        @endforeach
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/installment_verify.min.js"></script>
@endpush
