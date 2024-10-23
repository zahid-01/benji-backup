@extends('web.jiujitsu.layouts.app')

@section('content')
    <div class="container">
        <div class="course-private-content text-center w-full border rounded-lg">
            <div class="course-private-content-icon m-auto">
                <img src="/assets/default/img/course/private_content_icon.svg" alt="private content icon" class="img-cover">
            </div>

            <div class="mt-6">
                <h2 class="font-20 text-dark-blue">{{ trans('update.access_denied') }}</h2>
                <p class="text-sm font-medium text-slate-500">{{ trans('update.you_have_an_overdue_installment_please_pay_it_to_access_this_course') }}</p>

                <a href="/panel/financial/installments" class="btn btn-primary mt-15">{{ trans('update.view_installments') }}</a>
            </div>
        </div>
    </div>
@endsection
