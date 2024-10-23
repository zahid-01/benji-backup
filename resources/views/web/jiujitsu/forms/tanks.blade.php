@extends('web.jiujitsu.forms.layout')

@section('formContent')

    <div class="flex-center flex-col">
        <div class="">
            <img src="{{ $form->tank_you_message_image }}" alt="{{ $form->tank_you_message_title }}" class="img-fluid">
        </div>

        <h3 class="font-24 mt-6">{{ $form->tank_you_message_title }}</h3>
    </div>

    <div class="forms-body-welcome-message white-space-pre-wrap mt-15 text-sm text-slate-500">{{ $form->tank_you_message_description }}</div>

    <div class="flex-center mt-4">
        <a href="/" class="btn btn-primary">{{ trans('update.back_to_home') }}</a>
    </div>
@endsection
