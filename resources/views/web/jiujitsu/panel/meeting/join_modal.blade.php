<div class="hidden" id="joinMeetingLinkModal">
    <h3 class="section-title after-line font-20 text-dark-blue mb-25">{{ trans('panel.join_live_meeting') }}</h3>

    <div class="row">
        <div class="col-12 col-md-8">
            <div class="form-group">
                <label class="input-label">{{ trans('panel.url') }}</label>
                <input type="text" readonly name="link" class="form-control"/>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label class="input-label">{{ trans('auth.password') }} ({{ trans('public.optional') }})</label>
                <input type="text" readonly name="password" class="form-control"/>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <p class="font-medium text-slate-500">{{ trans('panel.add_live_meeting_link_hint') }}</p>

    <div class="mt-6 flex items-center justify-end">
        <a href="" target="_blank" class="js-join-meeting-link btn btn-sm btn-primary">{{ trans('footer.join') }}</a>
        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>
@push('scripts_bottom')
    <script src="/assets/default/js/panel/meeting/join_modal.min.js"></script>
@endpush
