@extends(getTemplate() .'.panel.layouts.panel_layout')

@section('content')
    @if($activeSubscribe)
        <section>
            <h2 class="section-title">{{ trans('financial.my_active_plan') }}</h2>

            <div class="activities-container mt-25 p-20 p-lg-35">
                <div class="row">
                    <div class="col-4 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/webinars.svg" width="64" height="64" alt="">
                            <strong class="text-3xl font-bold mt-5">{{ $activeSubscribe->title }}</strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('financial.active_plan') }}</span>
                        </div>
                    </div>

                    <div class="col-4 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/53.svg" width="64" height="64" alt="">
                            <strong class="text-3xl text-dark-blue font-bold mt-5">
                                @if($activeSubscribe->infinite_use)
                                    {{ trans('update.unlimited') }}
                                @else
                                    {{ $activeSubscribe->usable_count - $activeSubscribe->used_count }}
                                @endif
                            </strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('financial.remained_downloads') }}</span>
                        </div>
                    </div>

                    <div class="col-4 flex items-center justify-center">
                        <div class="flex flex-col items-center text-center">
                            <img src="/assets/default/img/activity/54.svg" width="64" height="64" alt="">
                            <strong class="text-3xl text-dark-blue text-dark-blue font-bold mt-5">{{ $activeSubscribe->days - $dayOfUse }}</strong>
                            <span class="font-16 text-slate-500 font-medium">{{ trans('financial.days_remained') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @else
        @include(getTemplate() . '.includes.no-result',[
           'file_name' => 'subcribe.png',
           'title' => trans('financial.subcribe_no_result'),
           'hint' => nl2br(trans('financial.subcribe_no_result_hint')),
       ])
    @endif

    <section class="mt-6">
        <h2 class="section-title">{{ trans('financial.select_a_subscribe_plan') }}</h2>

        <div class="row mt-15">

            @foreach($subscribes as $subscribe)
                @php
                    $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                @endphp

                <div class="col-12 col-sm-6 col-lg-3 mt-15">
                    <div class="subscribe-plan relative bg-white flex flex-col items-center rounded-sm shadow pt-50 pb-20 px-20">
                        @if($subscribe->is_popular)
                            <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                        @elseif(!empty($subscribeSpecialOffer))
                            <span class="badge badge-danger badge-popular px-15 py-5">{{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}</span>
                        @endif

                        <div class="plan-icon">
                            <img src="{{ $subscribe->icon }}" class="img-cover" alt="">
                        </div>

                        <h3 class="mt-4 text-3xl text-black">{{ $subscribe->title }}</h3>
                        <p class="font-medium text-sm text-slate-500 mt-10">{{ $subscribe->description }}</p>

                        <div class="flex align-items-start mt-6">
                            @if(!empty($subscribe->price) and $subscribe->price > 0)
                                @if(!empty($subscribeSpecialOffer))
                                    <div class="flex align-items-end line-height-1">
                                        <span class="font-36 text-primary">{{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}</span>
                                        <span class="text-sm text-slate-500 ml-2 line-through">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                    </div>
                                @else
                                    <span class="font-36 text-primary line-height-1">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                @endif
                            @else
                                <span class="font-36 text-primary line-height-1">{{ trans('public.free') }}</span>
                            @endif
                        </div>

                        <ul class="mt-4 plan-feature">
                            <li class="mt-10">{{ $subscribe->days }} {{ trans('financial.days_of_subscription') }}</li>
                            <li class="mt-10">
                                @if($subscribe->infinite_use)
                                    {{ trans('update.unlimited') }}
                                @else
                                    {{ $subscribe->usable_count }}
                                @endif
                                <span class="ml-2">{{ trans('update.subscribes') }}</span>
                            </li>
                        </ul>
                        <form action="/panel/financial/pay-subscribes" method="post" class="btn-block">
                            {{ csrf_field() }}
                            <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                            <input name="id" value="{{ $subscribe->id }}" type="hidden">

                            <div class="flex items-center mt-50 w-full">
                                <button type="submit" class="btn btn-primary {{ !empty($subscribe->has_installment) ? '' : 'btn-block' }}">{{ trans('update.purchase') }}</button>

                                @if(!empty($subscribe->has_installment))
                                    <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments" class="btn btn-outline-primary grow ml-10">{{ trans('update.installments') }}</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/panel/financial/subscribes.min.js"></script>
@endpush
