@extends('web.jiujitsu.forms.layout')

@section('formContent')

    <div class="flex-center flex-col">
        <div class="forms-body-welcome-image">
            <img src="/assets/default/img/forms/please_login.svg" alt="{{ trans("update.access_denied") }}" class="h-100">
        </div>

        <h3 class="font-24 mt-6">{{ trans("update.access_denied") }}</h3>

        @if(empty($form->end_date))
            <div class="forms-body-welcome-message white-space-pre-wrap mt-10 text-sm text-slate-500">{{ trans("update.you_can_fill_out_this_form_from_date",['date' => dateTimeFormat($form->start_date, 'j M Y')]) }}</div>
        @else
            <div class="forms-body-welcome-message white-space-pre-wrap mt-10 text-sm text-slate-500">{{ trans("update.you_can_fill_out_this_form_from_date_to_end_date",['date' => dateTimeFormat($form->start_date, 'j M Y'), 'end_date' => dateTimeFormat($form->end_date, 'j M Y')]) }}</div>
        @endif

        <a href="/" class="btn btn-primary mt-4">{{ trans('update.back_to_home') }}</a>
    </div>

@endsection
