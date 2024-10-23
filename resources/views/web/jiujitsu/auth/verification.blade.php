@extends(getTemplate() . '.layouts.fullwidth')

@section('content')
    <div class="max-w-xl mx-auto text-center py-10">

        <h1 class="text-xl font-bold">{{ trans('auth.account_verification') }}</h1>

        <p>{{ trans('auth.account_verification_hint', ['username' => $username]) }}</p>
        <form method="post" action="/verification" class="mt-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="hidden" name="username" value="{{ $usernameValue }}">

            <div class="flex flex-col gap-2">
                <label class="input-label text-left" for="code">{{ trans('auth.code') }}:</label>
                <input type="text" name="code" class="input input-bordered w-full border-slate-500  @error('code') is-invalid @enderror" id="code"
                    aria-describedby="codeHelp">
                @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-4">{{ trans('auth.verification') }}</button>
        </form>

        <div class="text-center mt-4">
            <span class="text-black">
                <a href="/verification/resend" class="font-bold">{{ trans('auth.resend_code') }}</a>
            </span>
        </div>

    </div>
@endsection
