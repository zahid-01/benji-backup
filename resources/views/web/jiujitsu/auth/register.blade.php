@extends(getTemplate() . '.layouts.fullwidth')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
        $selectRolesDuringRegistration = getFeaturesSettings('select_the_role_during_registration') ?? null;
    @endphp

    <div class="w-full max-w-md mx-auto border border-slate-500 rounded my-10 py-10 px-6">

        <h1 class="text-center text-2xl">{{ trans('auth.signup') }}</h1>

        <form method="post" action="/register" class="flex flex-col gap-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            {{-- @if (!empty($selectRolesDuringRegistration) and count($selectRolesDuringRegistration) or false)
                <div class="form-group">
                    <label class="input-label">{{ trans('financial.account_type') }}</label>

                    <div class="flex items-center wizard-custom-radio mt-5">
                        <div class="wizard-custom-radio-item grow">
                            <input type="radio" name="account_type" value="user" id="role_user" class="" checked>
                            <label class="text-sm cursor-pointer px-15 py-10"
                                for="role_user">{{ trans('update.role_user') }}</label>
                        </div>

                        @foreach ($selectRolesDuringRegistration as $selectRole)
                            <div class="wizard-custom-radio-item grow">
                                <input type="radio" name="account_type" value="{{ $selectRole }}"
                                    id="role_{{ $selectRole }}" class="">
                                <label class="text-sm cursor-pointer px-15 py-10"
                                    for="role_{{ $selectRole }}">{{ trans('update.role_' . $selectRole) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif --}}


            <div class="flex flex-col gap-2 mt-8">
                <label class="text-xl" for="full_name">{{ trans('auth.full_name') }}</label>
                <input name="full_name" type="text" value="{{ old('full_name') }}"
                    class="input input-bordered border-slate-500 w-full @error('full_name') is-invalid @enderror">
                @error('full_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if ($registerMethod == 'mobile')
                @include('web.jiujitsu.auth.register_includes.mobile_field')

                @if ($showOtherRegisterMethod)
                    @include('web.jiujitsu.auth.register_includes.email_field', [
                        'optional' => true,
                    ])
                @endif
            @else
                @include('web.jiujitsu.auth.register_includes.email_field')

                @if ($showOtherRegisterMethod)
                    @include('web.jiujitsu.auth.register_includes.mobile_field', [
                        'optional' => true,
                    ])
                @endif
            @endif

            <div class="flex flex-col gap-2">
                <label class="text-xl" for="password">{{ trans('auth.password') }}:</label>
                <input name="password" type="password" class="input input-bordered border-slate-500 w-full @error('password') is-invalid @enderror"
                    id="password" aria-describedby="passwordHelp">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-xl" for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                <input name="password_confirmation" type="password"
                    class="input input-bordered border-slate-500 w-full @error('password_confirmation') is-invalid @enderror" id="confirm_password"
                    aria-describedby="confirmPasswordHelp">
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if ($showCertificateAdditionalInRegister)
                <div class="form-group">
                    <label class="input-label"
                        for="certificate_additional">{{ trans('update.certificate_additional') }}</label>
                    <input name="certificate_additional" id="certificate_additional"
                        class="form-control @error('certificate_additional') is-invalid @enderror" />
                    @error('certificate_additional')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            {{-- @if (getFeaturesSettings('timezone_in_register'))
                @php
                    $selectedTimezone = getGeneralSettings('default_time_zone');
                @endphp

                <div class="form-group">
                    <label class="input-label">{{ trans('update.timezone') }}</label>
                    <select name="timezone" class="form-control select2" data-allow-clear="false">
                        <option value="" {{ empty($user->timezone) ? 'selected' : '' }} disabled>
                            {{ trans('public.select') }}</option>
                        @foreach (getListOfTimezones() as $timezone)
                            <option value="{{ $timezone }}" @if ($selectedTimezone == $timezone) selected @endif>
                                {{ $timezone }}</option>
                        @endforeach
                    </select>
                    @error('timezone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif --}}

            @if (!empty($referralSettings) and $referralSettings['status'])
                <div class="form-group ">
                    <label class="input-label" for="referral_code">{{ trans('financial.referral_code') }}:</label>
                    <input name="referral_code" type="text"
                        class="form-control @error('referral_code') is-invalid @enderror" id="referral_code"
                        value="{{ !empty($referralCode) ? $referralCode : old('referral_code') }}"
                        aria-describedby="confirmPasswordHelp">
                    @error('referral_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="js-form-fields-card">
                @if (!empty($formFields))
                    {!! $formFields !!}
                @endif
            </div>

            @if (!empty(getGeneralSecuritySettings('captcha_for_register')))
                @include('web.jiujitsu.includes.captcha_input')
            @endif

            <div class="custom-control custom-checkbox flex items-start gap-2">
                <input type="checkbox" class="checkbox" name="term" value="1"
                    {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }}
                    class="custom-control-input @error('term') is-invalid @enderror" id="term">
                <label class="text-slate-500 text-center font-light" for="term">By signing up, you agree to our 
                    <a href="pages/terms" target="_blank"
                        class="link">Terms of use</a> and
                    <a href="pages/terms" target="_blank"
                        class="link">Privacy Policy</a>
                </label>

                @error('term')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @error('term')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="btn btn-lg btn-primary btn-block text-2xl mt-4 shadow-xl">{{ trans('auth.signup') }}</button>
        </form>

        <div class="mt-2 text-center font-light">
            <span>
                {{ trans('auth.already_have_an_account') }}
                <a href="/login" class="link">{{ trans('auth.login') }}</a>
            </span>
        </div>


    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/forms.min.js"></script>
    <script src="/assets/default/js/parts/register.min.js"></script>
@endpush
