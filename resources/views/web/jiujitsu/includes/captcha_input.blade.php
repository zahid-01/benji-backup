<div class="form-group">
    <label class="input-label font-medium">{{ trans('site.captcha') }}</label>
    <div class="row items-center">
        <div class="col">
            <input type="text" name="captcha" class="form-control @error('captcha')  is-invalid @enderror">
            @error('captcha')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col flex items-center">
            <img id="captchaImageComment" class="captcha-image" src="">

            <button type="button" id="refreshCaptcha" class="btn-ghost ml-15">
                <i data-feather="refresh-ccw" width="24" height="24" class=""></i>
            </button>
        </div>
    </div>
</div>
