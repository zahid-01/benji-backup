<div class="flex flex-col gap-2">
    <label class="text-xl" for="email">{{ trans('auth.email') }}
        {{ !empty($optional) ? '(' . trans('public.optional') . ')' : '' }}:</label>
    <input name="email" type="text" class="input input-bordered w-full border-slate-500 @error('email') is-invalid @enderror"
        value="{{ old('email') }}" id="email" aria-describedby="emailHelp">
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
