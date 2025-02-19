<li data-id="{{ !empty($ticket) ? $ticket->id :'' }}" class="accordion-row bg-white rounded-sm panel-shadow mt-4 py-15 py-lg-30 px-10 px-lg-20">
    <div class="flex items-center justify-between " role="tab" id="ticket_{{ !empty($ticket) ? $ticket->id :'record' }}">
        <div class="font-bold text-dark-blue" href="#collapseTicket{{ !empty($ticket) ? $ticket->id :'record' }}" aria-controls="collapseTicket{{ !empty($ticket) ? $ticket->id :'record' }}" data-parent="#ticketsAccordion" role="button" data-toggle="collapse" aria-expanded="true">
            <span>{{ !empty($ticket) ? $ticket->title : trans('public.add_new_ticket') }}</span>
        </div>

        <div class="flex items-center">
            <i data-feather="move" class="move-icon mr-10 cursor-pointer" height="20"></i>

            @if(!empty($ticket))
                <div class="btn-group dropdown table-actions mr-15 font-weight-normal">
                    <button type="button" class="btn-ghost dropdown-toggle flex items-center justify-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-vertical" height="20"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="/panel/tickets/{{ $ticket->id }}/delete" class="delete-action btn btn-sm btn-ghost">{{ trans('public.delete') }}</a>
                    </div>
                </div>
            @endif

            <i class="collapse-chevron-icon" data-feather="chevron-down" height="20" href="#collapseTicket{{ !empty($ticket) ? $ticket->id :'record' }}" aria-controls="collapseTicket{{ !empty($ticket) ? $ticket->id :'record' }}" data-parent="#ticketsAccordion" role="button" data-toggle="collapse" aria-expanded="true"></i>
        </div>
    </div>

    <div id="collapseTicket{{ !empty($ticket) ? $ticket->id :'record' }}" aria-labelledby="ticket_{{ !empty($ticket) ? $ticket->id :'record' }}" class=" collapse @if(empty($ticket)) show @endif" role="tabpanel">
        <div class="panel-collapse text-slate-500">
            <div class="js-content-form ticket-form" data-action="/panel/tickets/{{ !empty($ticket) ? $ticket->id . '/update' : 'store' }}">
                <input type="hidden" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][bundle_id]" value="{{ !empty($bundle) ? $bundle->id :'' }}">

                @if(!empty(getGeneralSettings('content_translate')))
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="input-label">{{ trans('auth.language') }}</label>
                                <select name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][locale]"
                                        class="form-control {{ !empty($ticket) ? 'js-bundle-content-locale' : '' }}"
                                        data-bundle-id="{{ !empty($bundle) ? $bundle->id : '' }}"
                                        data-id="{{ !empty($ticket) ? $ticket->id : '' }}"
                                        data-relation="tickets"
                                        data-fields="title"
                                >
                                    @foreach($userLanguages as $lang => $language)
                                        <option value="{{ $lang }}" {{ (!empty($ticket) and !empty($ticket->locale)) ? (mb_strtolower($ticket->locale) == mb_strtolower($lang) ? 'selected' : '') : ($locale == $lang ? 'selected' : '') }}>{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][locale]" value="{{ $defaultLocale }}">
                @endif


                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="input-label">{{ trans('public.title') }}</label>
                            <input type="text" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][title]" class="js-ajax-title form-control" value="{{ !empty($ticket) ? $ticket->title :'' }}" placeholder="{{ trans('forms.maximum_64_characters') }}"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label class="input-label">{{ trans('public.discount') }} <span class="braces">(%)</span></label>
                            <input type="text" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][discount]" class="js-ajax-discount form-control" value="{{ !empty($ticket) ? $ticket->discount :'' }}"/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="input-label block">{{ trans('public.capacity') }}</label>
                            <input type="text" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][capacity]" class="js-ajax-capacity form-control mt-10" value="{{ !empty($ticket) ? $ticket->capacity :'' }}" placeholder="{{ trans('forms.empty_means_unlimited') }}"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('public.start_date') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="dateRangeLabel">
                                                <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][start_date]" class="js-ajax-start_date form-control datepicker" value="{{ !empty($ticket) ? dateTimeFormat($ticket->start_date, 'Y-m-d', false) :'' }}" aria-describedby="dateRangeLabel"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-15 mt-lg-0">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('webinars.end_date') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="dateRangeLabel">
                                                <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="ajax[{{ !empty($ticket) ? $ticket->id : 'new' }}][end_date]" class="js-ajax-end_date form-control datepicker" value="{{ !empty($ticket) ? dateTimeFormat($ticket->end_date, 'Y-m-d', false) :'' }}" aria-describedby="dateRangeLabel"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center">
                    <button type="button" class="js-save-ticket btn btn-sm btn-primary">{{ trans('public.save') }}</button>

                    @if(empty($ticket))
                        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 cancel-accordion">{{ trans('public.close') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</li>
