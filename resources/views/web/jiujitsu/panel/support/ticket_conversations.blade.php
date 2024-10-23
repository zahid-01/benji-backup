@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('panel.support_summary') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/41.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $openSupportsCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('panel.open_conversations') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/40.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $closeSupportsCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('panel.closed_conversations') }}</span>
                    </div>
                </div>

                <div class="col-4 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/39.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $supportsCount }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('panel.total_conversations') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-25">
        <h2 class="section-title">{{ trans('panel.message_filters') }}</h2>

        <div class="panel-section-card py-20 px-4 mt-4">
            <form action="/panel/support/tickets" method="get">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('public.from') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="dateInputGroupPrepend">
                                            <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                        </span>
                                        </div>
                                        <input type="text" name="from" autocomplete="off" class="form-control @if(!empty(request()->get('from'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('from','') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('public.to') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text" id="dateInputGroupPrepend">
                                        <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                    </span>
                                        </div>
                                        <input type="text" name="to" autocomplete="off" class="form-control @if(!empty(request()->get('to'))) datepicker @else datefilter @endif" aria-describedby="dateInputGroupPrepend" value="{{ request()->get('to','') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label block">{{ trans('panel.department') }}</label>

                                    <select name="department" id="departments" class="form-control">
                                        <option value="all">{{ trans('public.all') }}</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" @if(request()->get('department') == $department->id) selected @endif>{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('public.status') }}</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="all">{{ trans('public.all') }}</option>
                                        <option value="open" @if(request()->get('status') == 'open') selected @endif >{{ trans('public.open') }}</option>
                                        <option value="close" @if(request()->get('status') == 'close') selected @endif >{{ trans('public.close') }}</option>
                                        <option value="replied" @if(request()->get('status') == 'replied') selected @endif >{{ trans('panel.replied') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-2 flex items-center justify-end">
                        <button type="submit" class="btn btn-sm text-sm btn-primary w-full mt-2">{{ trans('public.show_results') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="mt-14">
        <h2 class="section-title">{{ trans('panel.messages_history') }}</h2>

        @if(!empty($supports) and !$supports->isEmpty())

            <div class="bg-white shadow rounded-sm py-10 py-lg-25 px-15 px-lg-30 mt-25">
                <div class="row">
                    <div id="conversationsList" class="col-12 col-lg-6 conversations-list">
                        <div class="table-responsive">
                            <table class="table table-md">
                                <tr>
                                    <th class="text-left text-sm text-slate-500 font-medium">{{ trans('navbar.title') }}</th>
                                    <th class="text-center text-sm text-slate-500 font-medium">{{ trans('public.updated_at') }}</th>
                                    <th class="text-center text-sm text-slate-500 font-medium">{{ trans('panel.department') }}</th>
                                    <th class="text-center text-sm text-slate-500 font-medium">{{ trans('public.status') }}</th>
                                </tr>
                                <tbody>

                                @foreach($supports as $support)
                                    <tr class="@if(!empty($selectSupport) and $selectSupport->id == $support->id) selected-row @endif">
                                        <td class="text-left">
                                            <a href="/panel/support/tickets/{{ $support->id }}/conversations" class="">
                                                <div class="user-inline-avatar flex items-center">
                                                    <div class="avatar bg-gray200">
                                                        <img src="/assets/default/img/support.png" class="img-cover" alt="">
                                                    </div>
                                                    <div class="ml-10">
                                                        <span class="block text-sm text-dark-blue font-medium">{{ $support->title }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="font-medium text-dark-blue text-sm text-slate-500 block">{{ (!empty($support->conversations) and count($support->conversations)) ? dateTimeFormat($support->conversations->first()->created_at,'j M Y | H:i') : dateTimeFormat($support->created_at,'j M Y | H:i') }}</span>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="font-medium text-dark-blue text-sm block">{{ $support->department->title }}</span>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if($support->status == 'close')
                                                <span class="text-danger text-sm font-medium">{{  trans('panel.closed') }}</span>
                                            @elseif($support->status == 'supporter_replied')
                                                <span class="text-primary text-sm font-medium">{{  trans('panel.replied') }}</span>
                                            @else
                                                <span class="text-warning text-sm font-medium">{{  trans('public.waiting') }}</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(!empty($selectSupport))
                        <div class="col-12 col-lg-6 border-left border-gray300">
                            <div class="conversation-box p-15 flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-sm text-dark-blue block">{{ $selectSupport->title }}</span>
                                    <span class="text-sm text-slate-500 block mt-5">{{ trans('public.created') }}: {{ dateTimeFormat($support->created_at,'j M Y | H:i') }}</span>

                                    @if(!empty($selectSupport->webinar))
                                        <span class="text-sm text-slate-500 block mt-5">{{ trans('webinars.webinar') }}: {{ $selectSupport->webinar->title }}</span>
                                    @endif
                                </div>

                                @if($selectSupport->status != 'close')
                                    <a href="/panel/support/{{ $selectSupport->id }}/close" class="btn btn-primary btn-sm">{{ trans('panel.close_request') }}</a>
                                @endif
                            </div>

                            <div id="conversationsCard" class="pt-15 conversations-card">

                                @if(!empty($selectSupport->conversations) and !$selectSupport->conversations->isEmpty())

                                    @foreach($selectSupport->conversations as $conversations)
                                        <div class="rounded-sm mt-15 border panel-shadow p-15">
                                            <div class="flex items-center justify-between pb-20 border-bottom border-gray300">
                                                <div class="user-inline-avatar flex items-center">
                                                    <div class="avatar bg-gray200">
                                                        <img src="{{ (!empty($conversations->supporter)) ? $conversations->supporter->getAvatar() : $conversations->sender->getAvatar() }}" class="img-cover" alt="">
                                                    </div>
                                                    <div class="ml-10">
                                                        <span class="block text-dark-blue text-sm font-medium">{{ (!empty($conversations->supporter)) ? $conversations->supporter->full_name : $conversations->sender->full_name }}</span>
                                                        <span class="mt-1 text-sm text-slate-500 block">{{ (!empty($conversations->supporter)) ? trans('panel.staff') : $conversations->sender->role_name }}</span>
                                                    </div>
                                                </div>

                                                <div class="flex flex-col align-items-end">
                                                    <span class="text-sm text-slate-500">{{ dateTimeFormat($conversations->created_at,'j M Y | H:i') }}</span>

                                                    @if(!empty($conversations->attach))
                                                        <a href="{{ url($conversations->attach) }}" target="_blank" class="text-sm mt-10 text-danger"><i data-feather="paperclip" height="14"></i> {{ trans('panel.attach') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="white-space-pre-wrap text-slate-500 mt-15 font-medium text-sm">{{ $conversations->message }}</p>
                                        </div>
                                    @endforeach

                                @endif
                            </div>

                            <div class="conversation-box mt-6 py-10 px-15">
                                <h3 class="text-sm text-dark-blue font-bold">{{ trans('panel.reply_to_the_conversation') }}</h3>
                                <form action="/panel/support/{{ $selectSupport->id }}/conversations" method="post" class="mt-5">
                                    {{ csrf_field() }}

                                    <div class="form-group mt-10">
                                        <label class="input-label block">{{ trans('site.message') }}</label>
                                        <textarea name="message" class="form-control @error('message')  is-invalid @enderror" rows="5">{{ old('message') }}</textarea>
                                        @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="flex flex items-center">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('panel.attach_file') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text panel-file-manager" data-input="attach" data-preview="holder">
                                                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="attach" id="attach" value="{{ old('attach') }}" class="form-control"/>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm ml-40 mt-10">{{ trans('site.send_message') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="col-12 col-lg-6 border-left border-gray300">
                            @include(getTemplate() . '.includes.no-result',[
                                'file_name' => 'support.png',
                                'title' => trans('panel.select_support'),
                                'hint' => nl2br(trans('panel.select_support_hint')),
                            ])
                        </div>
                    @endif
                </div>
            </div>

        @else

            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'support.png',
                'title' => trans('panel.support_no_result'),
                'hint' => nl2br(trans('panel.support_no_result_hint')),
            ])

        @endif
    </section>


@endsection


@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>

    <script src="/assets/default/js/panel/conversations.min.js"></script>
@endpush
