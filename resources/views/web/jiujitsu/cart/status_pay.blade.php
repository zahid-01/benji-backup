@extends(getTemplate().'.layouts.app')


@section('content')


    @if(!empty($order) && $order->status === \App\Models\Order::$paid)
        <div class="no-result default-no-result my-50 flex items-center justify-center flex-col">
            <div class="no-result-logo">
                <img src="/assets/default/img/no-results/search.png" alt="">
            </div>
            <div class="flex items-center flex-col mt-6 text-center">
                <h2>{{ trans('cart.success_pay_title') }}</h2>
                <p class="mt-5 text-center">{!! trans('cart.success_pay_msg') !!}</p>
                <a href="/panel" class="btn btn-sm btn-primary mt-4">{{ trans('public.my_panel') }}</a>
            </div>
        </div>
    @endif

    @if(!empty($order) && $order->status === \App\Models\Order::$fail)
        <div class="no-result status-failed my-50 flex items-center justify-center flex-col">
            <div class="no-result-logo">
                <img src="/assets/default/img/no-results/failed_pay.png" alt="">
            </div>
            <div class="flex items-center flex-col mt-6 text-center">
                <h2>{{ trans('cart.failed_pay_title') }}</h2>
                <p class="mt-5 text-center">{!! nl2br(trans('cart.failed_pay_msg')) !!}</p>
                <a href="/panel" class="btn btn-sm btn-primary mt-4">{{ trans('public.my_panel') }}</a>
            </div>
        </div>
    @endif


@endsection
