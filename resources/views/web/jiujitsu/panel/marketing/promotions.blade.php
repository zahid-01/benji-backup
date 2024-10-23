@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="">
        <h2 class="section-title">{{ trans('panel.select_promotion_plan') }}</h2>

        <div class="row mt-4">

            @foreach($promotions as $promotion)
                <div class="col-12 col-sm-6 col-lg-3 mt-15">
                    <div class="subscribe-plan relative bg-white flex flex-col items-center rounded-sm shadow pt-50 pb-20 px-20">
                        @if($promotion->is_popular)
                            <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                        @endif

                        <div class="plan-icon">
                            <img src="{{ $promotion->icon }}" class="img-cover" alt="">
                        </div>

                        <h3 class="mt-4 text-3xl text-black subscribe-plan-title">{{ $promotion->title }}</h3>
                        <p class="font-medium text-slate-500 mt-10">{{ trans('panel.promotion_days',['day' => $promotion->days]) }}</p>

                        <div class="flex align-items-start text-primary mt-6">
                            <span class="font-36 line-height-1 subscribe-plan-price">{{ (!empty($promotion->price) and $promotion->price > 0) ? handlePrice($promotion->price, true, true, false, null, true) : trans('public.free') }}</span>
                        </div>

                        <p class="text-dark-blue text-sm mt-25">{{ nl2br($promotion->description) }}</p>

                        <button type="button" data-promotion-id="{{ $promotion->id }}"
                                class="js-pay-promotion btn btn-primary btn-block mt-50">{{ trans('update.purchase') }}</button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @if($promotionSales->count() > 0)
        <section class="mt-8">
            <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
                <h2 class="section-title">{{ trans('panel.promotions_history') }}</h2>

                <div
                    class="flex items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-4 mt-md-0">
                    <label class="mb-0 mr-10 text-slate-500 text-sm font-medium"
                           for="activePromotionSwitch">{{ trans('panel.show_only_active_promotions') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="active_promotions" class="custom-control-input"
                               id="activePromotionSwitch">
                        <label class="custom-control-label" for="activePromotionSwitch"></label>
                    </div>
                </div>
            </div>

            <div class="panel-section-card py-20 px-4 mt-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table custom-table text-center ">
                                <thead>
                                <tr>
                                    <th class="text-left text-slate-500">{{ trans('panel.webinar') }}</th>
                                    <th class="text-center text-slate-500">{{ trans('panel.plan') }}</th>
                                    <th class="text-center text-slate-500">{{ trans('public.price') }}</th>
                                    <th class="text-center text-slate-500">{{ trans('public.date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promotionSales as $promotionSale)
                                    <tr>
                                        <td class="text-left text-dark-blue font-medium align-middle">{{ $promotionSale->webinar->title }}</td>
                                        <td class="align-middle">
                                            <span class="text-dark-blue font-medium">{{ $promotionSale->promotion->title }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-dark-blue font-medium">{{ (!empty($promotionSale->promotion->price) and $promotionSale->promotion->price > 0) ? handlePrice($promotionSale->promotion->price) : trans('public.free') }}</span>
                                        </td>
                                        <td class="text-dark-blue font-medium align-middle">{{ dateTimeFormat($promotionSale->created_at, 'j M Y | H:i') }}</td>
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
            'file_name' => 'promotion.png',
            'title' => trans('panel.promotion_no_result'),
            'hint' =>  nl2br(trans('panel.promotion_no_result_hint')) ,
        ])

    @endif

    <div class="my-30">
        {{ $promotionSales->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>

    <div id="promotionModal" class="hidden">
        <form action="/panel/marketing/pay-promotion" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="promotion_id" value="">


            <h3 class="section-title after-line">{{ trans('panel.promote_the_webinar') }}</h3>
            <div class="mt-25 flex flex-col items-center">
                <img src="/assets/default/img/check.png" alt="" width="120" height="117">
                <p class="mt-10">{{ trans('panel.select_webinar_for_promotion') }}</p>
                <div class="w-75">

                    <div class="mt-15 flex justify-between">
                        <span class="text-slate-500 font-bold">{{ trans('panel.plan') }}:</span>
                        <span class="text-slate-500 modal-title"></span>
                    </div>

                    <div class="mt-10 flex justify-between">
                        <span class="text-slate-500 font-bold">{{ trans('public.price') }}:</span>
                        <span class="text-slate-500"><span class="modal-price"></span></span>
                    </div>

                    <div class="form-group mt-15">
                        <select name="webinar_id" class="form-control custom-select">
                            <option selected disabled>{{ trans('panel.select_course') }}</option>

                            @foreach($webinars as $webinar)
                                <option value="{{ $webinar->id }}">{{ $webinar->title }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ trans('panel.select_course') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <button type="button"
                        class="btn btn-sm btn-primary js-submit-promotion">{{ trans('panel.pay') }}</button>
                <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>

    <script src="/assets/default/js/panel/marketing/promotions.min.js"></script>
@endpush
