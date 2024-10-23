@extends(getTemplate() . '.layouts.fullwidth')

@section('content')
    <div class="w-full max-w-md mx-auto border border-slate-500 rounded my-10 py-10 px-6">
        @if (!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-6" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h1 class="text-center text-2xl">{{ trans('auth.login') }}</h1>

        @if (!empty(getFeaturesSettings('show_google_login_button')))
            <a href="/google" target="_blank" class="btn btn-block bg-white border-slate-500 text-xl font-light mb-5 mt-9">
                <img src="/assets/default/img/auth/google.svg" alt=" google svg" />
                <span class="grow">{{ trans('auth.google_login') }}</span>
            </a>
        @endif

        @if (!empty(getFeaturesSettings('show_facebook_login_button')))
            <a href="{{ url('/facebook/redirect') }}" target="_blank"
                class="btn btn-block bg-white border-slate-500 text-xl font-light mb-5">
                <img src="/assets/default/img/auth/facebook.svg" alt="facebook svg" />
                <span class="grow">{{ trans('auth.facebook_login') }}</span>
            </a>
        @endif

        <div class="divider text-slate-500">OR</div>

        <form method="POST" action="/login" class="mt-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('web.jiujitsu.auth.includes.register_methods')


            <div class="flex flex-col gap-2 mt-10">
                <label class="text-xl" for="password">{{ trans('auth.password') }}</label>
                <input name="password" type="password"
                    class="input input-bordered w-full border-slate-500 @error('password')  is-invalid @enderror" id="password"
                    aria-describedby="passwordHelp">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-right mt-3">
                <a href="/forget-password" target="_blank" class="font-light">{{ trans('auth.forget_your_password') }}</a>
            </div>

            @if (!empty(getGeneralSecuritySettings('captcha_for_login')))
                @include('web.jiujitsu.includes.captcha_input')
            @endif

            <button type="submit" class="btn btn-lg btn-primary btn-block text-2xl mt-4 shadow-xl">{{ trans('auth.login') }}</button>
        </form>

        @if (session()->has('login_failed_active_session'))
            <div class="flex items-center mt-4 p-15 danger-transparent-alert ">
                <div class="danger-transparent-alert__icon flex items-center justify-center">
                    <i data-feather="alert-octagon" width="18" height="18" class=""></i>
                </div>
                <div class="ml-10">
                    <div class="text-sm font-bold ">
                        {{ session()->get('login_failed_active_session')['title'] }}</div>
                    <div class="text-sm ">{{ session()->get('login_failed_active_session')['msg'] }}</div>
                </div>
            </div>
        @endif



        <div class="mt-2 text-center font-light">
            <span>{{ trans('auth.dont_have_account') }}</span>
            <a href="/register" class="link">{{ trans('auth.signup') }}</a>
        </div>


    </div>
@endsection
