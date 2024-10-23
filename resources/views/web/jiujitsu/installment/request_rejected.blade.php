@extends('web.jiujitsu.layouts.app')

@section('content')
    <div class="container mt-4 my-50">
        <div class="row items-center justify-center">
            <div class="col-12 col-md-8">
                <div class="installment-request-card flex items-center justify-center flex-col border rounded-lg">
                    <img src="/assets/default/img/installment/request_rejected.svg" alt="{{ trans('update.installment_request_rejected') }}" width="267" height="265">

                    <h1 class="font-20 mt-6">{{ trans('update.installment_request_rejected') }}</h1>
                    <p class="text-sm text-slate-500 mt-5">{{ trans('update.installment_request_rejected_hint') }}</p>

                    <a href="/panel/" class="btn btn-primary mt-15">{{ trans('update.back_to_installments') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
