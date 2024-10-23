@extends(getTemplate().'.layouts.app')

@section('content')
    <div class="container">
        <div class="row login-container border-red-300">
            <div class="avatar gap-10">
                <img class="max-h-full max-w-sm rounded-xl" src="{{ getPageBackgroundSettings('certificate_validation') }}"  alt="Login">

                <div class="login-card mx-auto max-w-md">
                    <h1 class="font-20 font-bold">{{ trans('site.certificate_validation') }}</h1>
                    <p class="text-sm text-slate-500 mt-15">{{ trans('site.certificate_validation_hint') }}</p>


                    <form method="post" action="/certificate_validation/validate" class="mt-8">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label class="input-label" for="code">{{ trans('public.certificate_id') }}:</label>
                            <input type="text" name="certificate_id" class="form-control border-slate-500 input h-8" id="certificate_id" aria-describedby="certificate_idHelp">
                            <div class="invalid-feedback"></div>
                        

                        <div class="form-group h-24 w-24">
                            <label class="input-label">{{ trans('site.captcha') }}</label>
                            <div class="row items-center">
                                <div class="col">
                                    <input type="tel" name="captcha" class="form-control border-slate-500 input h-8 mb-3">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col flex items-center">
                                    <img id="captchaImageComment" class="captcha-image" src="">

                                    <button type="button" id="refreshCaptcha" class="btn-ghost ml-15">
                                        <i data-feather="refresh-ccw" width="24" height="24" class=""></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                        <button type="button" id="formSubmit" class="btn btn-primary btn-block mt-4">{{ trans('cart.validate') }}</button>

                    </form>

                </div>
            </div>

            <div class="col-12 col-md-6">

               
            </div>
        </div>
    </div>

    <div id="certificateModal" class="hidden">
        <h3 class="section-title after-line">{{ trans('site.certificate_is_valid') }}</h3>
        <div class="mt-25 flex flex-col items-center">
            <img src="/assets/default/img/check.png" alt="" width="120" height="117">
            <p class="mt-10">{{ trans('site.certificate_is_valid_hint') }}</p>
            <div class="w-75">

                <div class="mt-15 flex justify-between">
                    <span class="text-slate-500 font-bold">{{ trans('quiz.student') }}:</span>
                    <span class="text-slate-500 modal-student"></span>
                </div>

                <div class="mt-10 flex justify-between">
                    <span class="text-slate-500 font-bold">{{ trans('public.date') }}:</span>
                    <span class="text-slate-500"><span class="modal-date"></span></span>
                </div>

                <div class="mt-10 flex justify-between">
                    <span class="text-slate-500 font-bold">{{ trans('webinars.webinar') }}:</span>
                    <span class="text-slate-500"><span class="modal-webinar"></span></span>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end">
            <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
        </div>
    </div>

@endsection

@push('scripts_bottom')
    <script>
        var certificateNotFound = '{{ trans('site.certificate_not_found') }}';
        var close = '{{ trans('public.close') }}';
    </script>

    <script src="/assets/default/js/parts/certificate_validation.min.js"></script>
@endpush
