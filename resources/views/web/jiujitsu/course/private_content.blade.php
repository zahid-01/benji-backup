@extends('web.jiujitsu.layouts.app')

@section('content')
    <div class="container">
        <div class="course-private-content text-center w-full border rounded-lg">
            <div class="course-private-content-icon m-auto">
                <img src="/assets/default/img/course/private_content_icon.svg" alt="private content icon" class="img-cover">
            </div>

            @if(!empty($userNotAccess) and $userNotAccess)
                <div class="mt-6">
                    <h2 class="font-20 text-dark-blue">{{ trans('update.not_access_to_content') }}</h2>
                    <p class="text-sm font-medium text-slate-500">{{ trans('update.not_access_to_content_hint') }}</p>
                </div>
            @else
                <div class="mt-6">
                    <h2 class="font-20 font-bold text-dark-blue">{{ trans('update.private_content') }}</h2>
                    <p class="text-sm font-medium text-slate-500">{{ trans('update.private_content_login_hint') }}</p>
                </div>

                <a href="/login" class="btn btn-primary mt-15">{{ trans('auth.login') }}</a>
            @endif
        </div>
    </div>
@endsection
