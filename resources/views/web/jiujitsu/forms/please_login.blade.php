@extends('web.jiujitsu.forms.layout')

@section('formContent')

    <div class="flex-center flex-col">
        <div class="forms-body-welcome-image">
            <img src="/assets/default/img/forms/please_login.svg" alt="{{ trans("update.access_denied") }}" class="h-100">
        </div>

        <h3 class="font-24 mt-6">{{ trans("update.access_denied") }}</h3>
        <div class="forms-body-welcome-message white-space-pre-wrap mt-10 text-sm text-slate-500">{{ trans("update.please_login_to_access_this_form._This_form_is_available_for_logged-in_users") }}</div>

        <a href="/" class="btn btn-primary mt-4">{{ trans('update.back_to_home') }}</a>
    </div>

@endsection
