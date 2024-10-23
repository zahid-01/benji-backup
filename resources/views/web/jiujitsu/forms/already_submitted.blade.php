@extends('web.jiujitsu.forms.layout')

@section('formContent')

    <div class="flex-center flex-col">
        <div class="forms-body-welcome-image">
            <img src="/assets/default/img/forms/already_submitted.svg" alt="{{ trans("update.already_submitted") }}" class="h-100">
        </div>

        <h3 class="font-24 mt-6">{{ trans("update.already_submitted") }}</h3>
        <div class="forms-body-welcome-message white-space-pre-wrap mt-10 text-sm text-slate-500">{{ trans("update.you_have_submitted_this_form_already_and_you_can_not_fill_it_in_again...") }}</div>

        <a href="/" class="btn btn-primary mt-4">{{ trans('update.back_to_home') }}</a>
    </div>

@endsection
