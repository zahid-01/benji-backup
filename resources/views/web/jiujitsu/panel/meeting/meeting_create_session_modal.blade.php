<div class="hidden" id="meetingCreateSessionModal">
    <h3 class="section-title after-line font-20 text-dark-blue mb-25">{{ trans('update.create_a_live_session') }}</h3>

    <div class="flex items-center justify-center flex-col mt-4">
        <img src="/assets/default/img/meeting/live_session.svg" alt="" class="" width="150" height="150">

        <h4 class="js-for-create-session-text hidden mt-5">{{ trans('update.new_in-app_call_session') }}</h4>
        <p class="js-for-create-session-text hidden mt-5 text-slate-500 text-sm">{{  trans('update.are_you_sure_to_create_an_in-app_live_session_for_this_meeting') }}</p>
        <p class="js-for-create-session-text hidden mt-5 text-slate-500 text-sm"> {{ trans('update.your_meeting_date_is') }} <span class="js-meeting-date"></span></p>

        <h4 class="js-for-join-session-text hidden mt-5">{{ trans('update.join_the_live_session_now') }}</h4>
        <p class="js-for-join-session-text hidden mt-5 text-slate-500 text-sm">{{ trans('update.live_session_created_successfully_and_you_can_join_it_right_now') }}</p>
    </div>

    <div class="mt-6 flex items-center justify-end">
        <button type="button" data-item-id="" class="js-create-meeting-session btn btn-sm btn-primary">{{ trans('public.create') }}</button>
        <a href="" target="_blank" class="js-join-to-session hidden btn btn-sm btn-primary">{{ trans('footer.join') }}</a>
        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>

