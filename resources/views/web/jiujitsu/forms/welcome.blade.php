@extends('web.jiujitsu.forms.layout')

@section('formContent')
    @if(!empty($form->end_date))
        <div class="flex items-center mb-40 rounded-lg border border-gray200 p-15">
            <div class="size-40 flex-center rounded-full bg-gray200">
                <i data-feather="calendar" class="text-slate-500" width="20" height="20"></i>
            </div>
            <div class="ml-2">
                <h4 class="text-sm font-bold text-slate-500">{{ trans('update.notice') }}</h4>
                <p class="text-sm text-slate-500">{{ trans('update.this_form_will_be_expired_on_date',['date' => dateTimeFormat($form->end_date, 'j M Y')]) }}</p>
            </div>
        </div>
    @endif

    <div class="flex-center flex-col">
        <div class="">
            <img src="{{ $form->welcome_message_image }}" alt="{{ $form->welcome_message_title }}" class="img-fluid">
        </div>

        <h3 class="font-24 mt-6">{{ $form->welcome_message_title }}</h3>
    </div>

    <div class="forms-body-welcome-message white-space-pre-wrap mt-15 text-sm text-slate-500">{{ $form->welcome_message_description }}</div>

    <div class="flex-center mt-4">
        <a href="/forms/{{ $form->url }}?fields=1" class="btn btn-primary">{{ trans('update.fill_out_the_form') }}</a>
    </div>
@endsection
