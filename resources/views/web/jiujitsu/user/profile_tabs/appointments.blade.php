@if(!empty($meeting) and !empty($meeting->meetingTimes) and $meeting->meetingTimes->count() > 0)
    @push('styles_top')
        <link rel="stylesheet" href="/assets/vendors/wrunner-html-range-slider-with-2-handles/css/wrunner-default-theme.css">
    @endpush

    <div class="mt-14">
        <h3 class="font-16 font-bold text-dark-blue">{{ trans('site.view_available_times') }}</h3>

        <div class="pt-8">
            <div class="flex items-center justify-center mb-10">
                <input type="hidden" id="inlineCalender" class="form-control">
                <div class="inline-reservation-calender inline-block w-96 mx-auto"></div>
            </div>
        </div>
    </div>

    <div class="pick-a-time hidden" id="PickTimeContainer" data-user-id="{{ $user["id"] }}">

        <div class="flex items-center my-40 rounded-lg border px-10 py-5">
            <div class="appointment-timezone-icon">
                <img src="/assets/default/img/icons/timezone.svg" alt="appointment timezone">
            </div>
            <div class="ml-15">
                <div class="font-16 font-bold text-dark-blue">{{ trans('update.note') }}:</div>
                <p class="text-sm font-medium text-slate-500">{{ trans('update.appointment_timezone_note_hint',['timezone' => $meetingTimezone .' '. toGmtOffset($meetingTimezone)]) }}</p>
            </div>
        </div>


        {{-- Cashback Alert --}}
        @include('web.jiujitsu.includes.cashback_alert',['itemPrice' => $meeting->amount, 'classNames' => 'mt-0 mb-40', 'itemType' => 'meeting'])


        <div class="loading-img hidden text-center">
            <img src="/assets/default/img/loading.gif" width="80" height="80">
        </div>

        <form action="{{ (!$meeting->disabled) ? '/meetings/reserve' : '' }}" method="post" id="PickTimeBody" class="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="day" id="selectedDay" value="">

            <h3 class="font-16 font-bold text-dark-blue">
                @if($meeting->disabled)
                    {{ trans('public.unavailable') }}
                @else
                    {{ trans('site.pick_a_time') }}
                    @if(!empty($meeting) and !empty($meeting->discount) and !empty($meeting->amount) and $meeting->amount > 0)
                        <span class="badge badge-danger text-white text-sm">{{ $meeting->discount }}% {{ trans('public.off') }}</span>
                    @endif
                @endif
            </h3>

            <div class="flex flex-col mt-10">
                @if($meeting->disabled)
                    <span class="text-sm text-slate-500">{{ trans('public.unavailable_description') }}</span>
                @else
                    <span class="block text-sm text-slate-500 font-medium">
                        {{ trans('site.instructor_hourly_charge') }}

                        @if(!empty($meeting->amount) and $meeting->amount > 0)
                            @if(!empty($meeting->discount))
                                <span class="line-through">{{ handlePrice($meeting->amount, true, true, false, null, true) }}</span>
                                <span class="text-primary">{{ handlePrice($meeting->amount - (($meeting->amount * $meeting->discount) / 100), true, true, false, null, true) }}</span>
                            @else
                                <span class="text-primary">{{ handlePrice($meeting->amount, true, true, false, null, true) }}</span>
                            @endif
                        @else
                            <span class="text-primary">{{ trans('public.free') }}</span>
                        @endif
                    </span>

                    @if($meeting->in_person)
                    <span class="block text-sm text-slate-500 font-medium">
                        {{ trans('update.instructor_hourly_charge_in_person_amount') }}

                        @if(!empty($meeting->in_person_amount) and $meeting->in_person_amount > 0)
                            @if(!empty($meeting->discount))
                                <span class="line-through">{{ handlePrice($meeting->in_person_amount, true, true, false, null, true) }}</span>
                                <span class="text-primary">{{ handlePrice($meeting->in_person_amount - (($meeting->in_person_amount * $meeting->discount) / 100), true, true, false, null, true) }}</span>
                            @else
                                <span class="text-primary">{{ handlePrice($meeting->in_person_amount, true, true, false, null, true) }}</span>
                            @endif
                        @else
                            <span class="text-primary">{{ trans('public.free') }}</span>
                        @endif
                    </span>
                  @endif
                  @if($meeting->group_meeting)
                    <span class="block text-sm text-slate-500 font-medium">{{ trans('update.instructor_conducts_group_meetings',['min' => $meeting->online_group_min_student,'max' => $meeting->online_group_max_student]) }}</span>
                  @endif

                @endif

                <span class="text-sm text-slate-500 mt-5 selected_date font-medium">{{ trans('site.selected_date') }}: <span></span></span>
            </div>

            @if(!$meeting->disabled)
                <div id="availableTimes" class="flex flex-wrap items-center mt-25">

                </div>

                <div class="js-time-description-card hidden mt-25 rounded-sm border p-10">

                </div>

                <div class="mt-25 hidden js-finalize-reserve">
                    <h3 class="font-16 font-bold text-dark-blue">{{ trans('update.finalize_your_meeting') }}</h3>
                    <span class="selected-date-time text-sm text-slate-500 font-medium">{{ trans('update.meeting_time') }}: <span></span></span>

                    <div class="mt-15">
                        <span class="font-16 font-medium text-dark-blue">{{ trans('update.meeting_type') }}</span>

                        <div class="flex items-center mt-5">
                            <div class="meeting-type-reserve relative">
                                <input type="radio" name="meeting_type" id="meetingTypeInPerson" value="in_person">
                                <label for="meetingTypeInPerson">{{ trans('update.in_person') }}</label>
                            </div>

                            <div class="meeting-type-reserve relative">
                                <input type="radio" name="meeting_type" id="meetingTypeOnline" value="online">
                                <label for="meetingTypeOnline">{{ trans('update.online') }}</label>
                            </div>
                        </div>
                    </div>

                    @if($meeting->group_meeting)
                        <div class="js-group-meeting-switch hidden items-center mt-4">
                            <label class="mb-0 mr-10 text-slate-500 text-sm font-medium cursor-pointer"
                                   for="withGroupMeetingSwitch">{{ trans('update.group_meeting') }}</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="with_group_meeting" class="custom-control-input"
                                       id="withGroupMeetingSwitch">
                                <label class="custom-control-label" for="withGroupMeetingSwitch"></label>
                            </div>
                        </div>

                        <div class="js-group-meeting-options hidden mt-15">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="hidden" id="online_group_max_student" value="{{ $meeting->online_group_max_student }}">
                                        <input type="hidden" id="in_person_group_max_student" value="{{ $meeting->in_person_group_max_student }}">
                                        <label for="studentCountRange" class="form-label">{{ trans('update.participates') }}:</label>
                                        <div
                                            class="range"
                                            id="studentCountRange"
                                            data-minLimit="1"
                                        >
                                            <input type="hidden" name="student_count" value="1">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="js-online-group-amount hidden text-sm font-medium mt-15">
                                <span class="text-slate-500 block">{{ trans('update.online') }} {{ trans('update.group_meeting_hourly_rate_per_student',['amount' => handlePrice($meeting->online_group_amount, true, true, false, null, true)]) }}</span>
                                <span class="text-danger mt-5 block">{{ trans('update.group_meeting_student_count_hint',['min' => $meeting->online_group_min_student, 'max' => $meeting->online_group_max_student]) }}</span>
                                <span class="text-danger mt-5 block">{{ trans('update.group_meeting_max_student_count_hint',['max' => $meeting->online_group_max_student]) }}</span>
                            </div>

                            @if($meeting->in_person)
                            <div class="js-in-person-group-amount hidden text-sm font-medium mt-15">
                                <span class="text-slate-500 block">{{ trans('update.in_person') }} {{ trans('update.group_meeting_hourly_rate_per_student',['amount' => handlePrice($meeting->in_person_group_amount, true, true, false, null, true)]) }}</span>
                                <span class="text-danger mt-5 block">{{ trans('update.group_meeting_student_count_hint',['min' => $meeting->in_person_group_min_student, 'max' => $meeting->in_person_group_max_student]) }}</span>
                                <span class="text-danger mt-5 block">{{ trans('update.group_meeting_max_student_count_hint',['max' => $meeting->in_person_group_max_student]) }}</span>
                            </div>
                            @endif

                        </div>
                    @endif
                </div>

                <div class="js-reserve-description hidden form-group mt-6">
                    <label class="input-label">{{ trans('public.description') }}</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="{{ trans('update.reserve_time_description_placeholder') }}"></textarea>
                </div>

                <div class="js-reserve-btn hidden items-center justify-end mt-6">
                    <button type="button" class="js-submit-form btn btn-primary">{{ trans('meeting.reserve_appointment') }}</button>
                </div>
            @endif
        </form>
    </div>

    @push('scripts_bottom')
        <script src="/assets/vendors/wrunner-html-range-slider-with-2-handles/js/wrunner-jquery.js"></script>
    @endpush
@else

    @include(getTemplate() . '.includes.no-result',[
       'file_name' => 'meet.png',
       'title' => trans('site.instructor_not_available'),
       'hint' => '',
    ])

@endif
