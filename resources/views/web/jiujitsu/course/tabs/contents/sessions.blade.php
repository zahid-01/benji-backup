@php
    $checkSequenceContent = $session->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp

<div class="collapse collapse-arrow border border-slate-200 mt-6">
    <input type="checkbox" name="collapseChapterInner" />

    <div class="collapse-title flex font-medium items-center justify-between" role="tab"
        id="session_{{ $session->id }}">
        <div class="flex items-center" href="#collapseSession{{ $session->id }}"
            aria-controls="collapseSession{{ $session->id }}" data-parent="#{{ $accordionParent }}" role="button"
            data-toggle="collapse" aria-expanded="true">
            @if ($session->date > time())
                <a href="{{ $session->addToCalendarLink() }}" target="_blank" class="mr-15 flex" data-toggle="tooltip"
                    data-placement="top" title="{{ trans('public.add_to_calendar') }}">
                    <span class="chapter-icon chapter-content-icon">
                        <i data-feather="bell" width="20" height="20" class="text-slate-500"></i>
                    </span>
                </a>
            @else
                <span class="mr-15 flex chapter-icon chapter-content-icon">
                    <i data-feather="bell" width="20" height="20" class="text-slate-500"></i>
                </span>
            @endif
            <span class="ml-3">{{ $session->title }}</span>
        </div>
    </div>

    <div id="collapseSession{{ $session->id }}" aria-labelledby="session_{{ $session->id }}" class="collapse-content"
        role="tabpanel">
        <div class="border-t border-slate-200 pt-8">
            {!! nl2br(clean($session->description)) !!}
    
            @if (!empty($user) and $hasBought)
                <div class="flex items-center my-4">
                    <label class="mb-0 mr-10 cursor-pointer font-medium"
                        for="sessionReadToggle{{ $session->id }}">{{ trans('public.i_passed_this_lesson') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" @if ($session->date < time() or $sequenceContentHasError) disabled @endif
                            id="sessionReadToggle{{ $session->id }}" data-session-id="{{ $session->id }}"
                            value="{{ $course->id }}" class="js-text-session-toggle custom-control-input"
                            @if (!empty($session->checkPassedItem())) checked @endif>
                        <label class="custom-control-label" for="sessionReadToggle{{ $session->id }}"></label>
                    </div>
                </div>
            @endif
    
            <div class="flex items-center justify-between py-4 border-t border-slate-200">
                <div class="flex items-center">
                    <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                        <i data-feather="clock" width="18" height="18" class="text-slate-500 mr-5"></i>
                        <span class="line-height-1">{{ convertMinutesToHourAndMinute($session->duration) }}
                            {{ trans('home.hours') }}</span>
                    </div>
    
                    <div class="flex items-center text-slate-500 text-center text-sm mr-20">
                        <i data-feather="calendar" width="18" height="18" class="text-slate-500 mr-5"></i>
                        <span class="line-height-1">{{ dateTimeFormat($session->date, 'j M Y | H:i') }}</span>
                    </div>
                </div>
    
                <div class="">
                    @if ($session->isFinished())
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray disabled grow disabled session-finished-toast">{{ trans('public.finished') }}</button>
                    @elseif(empty($user))
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray disabled grow disabled not-login-toast">{{ trans('public.go_to_class') }}</button>
                    @elseif($hasBought)
                        @if (!empty($checkSequenceContent) and $sequenceContentHasError)
                            <button type="button"
                                class="course-content-btns btn btn-sm btn-gray grow disabled js-sequence-content-error-modal"
                                data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
                                data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">{{ trans('public.go_to_class') }}</button>
                        @else
                            <a href="{{ $course->getLearningPageUrl() }}?type=session&item={{ $session->id }}"
                                target="_blank"
                                class="course-content-btns btn btn-sm btn-primary grow">{{ trans('public.go_to_class') }}</a>
                        @endif
                    @else
                        <button type="button"
                            class="course-content-btns btn btn-sm btn-gray grow disabled not-access-toast">{{ trans('public.go_to_class') }}</button>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
