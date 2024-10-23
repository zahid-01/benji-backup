@extends('web.jiujitsu.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')
    <div class="container pt-50 mt-10">
        <div class="text-center">
            @if($installment->needToVerify())
                <h1 class="font-36">{{ trans('update.verify_your_installments') }}</h1>
                <p class="mt-10 font-16 text-slate-500">{{ trans('update.verify_your_installments_hint') }}</p>
            @else
                <h1 class="font-36">{{ trans('update.verify_your_installments2') }}</h1>
                <p class="mt-10 font-16 text-slate-500">{{ trans('update.verify_your_installments_hint2') }}</p>
            @endif
        </div>

        <div class="become-instructor-packages flex items-center flex-col flex-lg-row mt-50 border rounded-lg p-15 p-lg-25">
            <div class="default-package-icon">
                <img src="/assets/default/img/become-instructor/default.png" class="img-cover" alt="{{ trans('update.installment_overview') }}" width="176" height="144">
            </div>

            <div class="ml-lg-25 w-full mt-4 mt-lg-0">
                <h2 class="font-24 font-bold text-dark-blue">{{ trans('update.installment_overview') }}</h2>
                @if($itemType == 'course')
                    <a href="{{ $item->getUrl() }}" target="_blank" class="text-sm font-medium text-slate-500">{{ $item->title }}</a>
                @else
                    <div class="text-sm font-medium text-slate-500">{{ $item->title }}</div>
                @endif

                <div class="flex flex-wrap items-center justify-between w-full">

                    <div class="flex items-center mt-4">
                        <i data-feather="check-square" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ !empty($installment->upfront) ? handlePrice($installment->getUpfront($itemPrice)).' '. trans('update.upfront') : trans('update.no_upfront') }}</span>
                    </div>

                    <div class="flex items-center mt-4">
                        <i data-feather="menu" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ $installment->steps_count }} {{ trans('update.installments') }} ({{ handlePrice($installment->totalPayments($itemPrice, false)) }})</span>
                    </div>

                    <div class="flex items-center mt-4">
                        <i data-feather="dollar-sign" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ handlePrice($installment->totalPayments($itemPrice)) }} {{ trans('financial.total_amount') }}</span>
                    </div>

                    <div class="flex items-center mt-4">
                        <i data-feather="calendar" width="20" height="20" class="text-slate-500"></i>
                        <span class="text-sm text-slate-500 ml-2">{{ $installment->steps->max('deadline') }} {{ trans('update.days_duration') }}</span>
                    </div>

                </div>
            </div>
        </div>

        <form action="/installments/{{ $installment->id }}/store" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="item" value="{{ request()->get('item') }}">
            <input type="hidden" name="item_type" value="{{ request()->get('item_type') }}">

            {{-- Verify Section --}}
            @if($installment->request_uploads or $installment->needToVerify())
                <div class="border rounded-lg p-15 mt-4">
                    @if($installment->needToVerify())
                        <h3 class="font-16 font-bold text-dark-blue">{{ trans('update.verify_installments') }}</h3>

                        <div class="font-16 text-slate-500 mt-10">{!! nl2br($installment->verification_description) !!}</div>

                        {{-- Banner --}}
                        @if(!empty($installment->verification_banner))
                            <img src="{{ $installment->verification_banner }}" alt="{{ $installment->main_title }}" class="img-fluid mt-6">
                        @endif

                        {{-- Video --}}
                        @if(!empty($installment->verification_video))
                            <div class="installment-video-card mt-50">
                                <video
                                    id="my-video"
                                    class="video-js"
                                    controls
                                    preload="auto"
                                >
                                    <source src="{{ $installment->verification_video }}" type="video/mp4"/>
                                </video>
                            </div>
                        @endif
                    @endif

                    @if($installment->request_uploads)
                        <div class="{{ ($installment->needToVerify()) ? 'mt-4' : '' }}">
                            <h4 class="font-16 font-bold text-dark-blue">{{ trans('update.attachments') }}</h4>
                            <p class="mt-5 text-sm text-slate-500">{{ trans('update.attach_your_documents_and_send_them_to_admin') }}</p>

                            @error('attachments')
                            <div class="invalid-feedback block">{{ $message }}</div>
                            @enderror

                            <div class="js-attachments">

                                <div class="js-main-row row">
                                    <div class="col-12 col-md-6 mt-15">
                                        <div class="form-group mb-0">
                                            <label class="text-sm text-dark-blue">{{ trans('public.title') }}</label>
                                            <input type="text" name="attachments[record][title]" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mt-15">
                                        <div class="form-group">
                                            <label class="text-sm text-dark-blue">{{ trans('update.attach_a_file_optional') }}</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text panel-file-manager" data-input="file_record" data-preview="holder">
                                                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="attachments[record][file]" id="file_record" class="form-control rounded-0"/>

                                                <button type="button" class="js-add-btn btn btn-primary h-40px btn-sm installment-verify-attachment-add-btn">
                                                    <i data-feather="plus" width="16" height="16" class="text-white"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            @endif


            {{-- Installment Terms & Rules --}}
            <div class="border rounded-lg p-15 mt-6">
                <h3 class="font-16 font-bold text-dark-blue">{{ trans('update.installment_terms_&_rules') }}</h3>

                <div class="font-16 text-slate-500">{!! nl2br(getInstallmentsTermsSettings('terms_description')) !!}</div>

                <div class="mt-10 border bg-info-light p-15 rounded-sm">
                    <h4 class="text-sm text-slate-500 font-bold">{{ trans('update.important') }}</h4>
                    <p class="mt-5 text-sm text-slate-500">{{ trans('update.by_purchasing_installment_plans_you_will_accept_installment_terms_and_rules') }}</p>
                </div>
            </div>

            @if(!empty($hasPhysicalProduct))
                @include('web.jiujitsu.cart.includes.shipping_and_delivery')
            @endif

            @if(!empty(request()->get('quantity')))
                <input type="hidden" name="quantity" value="{{ request()->get('quantity') }}">
            @endif

            @if(!empty(request()->get('specifications')) and count(request()->get('specifications')))
                @foreach(request()->get('specifications') as $k => $specification)
                    <input type="hidden" name="specifications[{{ $k }}]" value="{{ $specification }}">
                @endforeach
            @endif

            <div class="flex items-center justify-between border-top pt-10 mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-gray200">{{ trans('update.back') }}</a>

                <button type="submit" class="btn btn-sm btn-primary">
                    @if($installment->needToVerify())
                        @if(!empty($installment->upfront))
                            {{ trans('update.submit_and_checkout') }}
                        @else
                            {{ trans('update.submit_request') }}
                        @endif
                    @else
                        @if(!empty($installment->upfront))
                            {{ trans('update.proceed_to_checkout') }}
                        @else
                            {{ trans('update.finalize_request') }}
                        @endif
                    @endif
                </button>
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

    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="/assets/default/js/parts/get-regions.min.js"></script>
    <script src="/assets/default/js/parts/installment_verify.min.js"></script>
@endpush
