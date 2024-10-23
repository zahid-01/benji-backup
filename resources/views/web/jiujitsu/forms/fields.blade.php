@extends('web.jiujitsu.forms.layout')

@section('formContent')

    @if(!empty($form->end_date))
        <div class="flex items-center mb-40 rounded-lg border border-gray200 p-15">
            <div class="size-40 flex-center rounded-full bg-gray200">
                <i data-feather="calendar" class="text-slate-500" width="20" height="20"></i>
            </div>
            <div class="ml-2">
                <h4 class="text-sm font-bold text-slate-500">{{ trans('update.notice') }}</h4>
                <p class="text-sm text-slate-500">{{ trans('update.this_form_will_be_expired_on_date',['date' => dateTimeFormat($form->end_date, 'j M Y')]) }}</p>
            </div>
        </div>
    @endif

    <div class="flex-center flex-col">
        <div class="">
            <img src="{{ $form->image }}" alt="{{ $form->heading_title }}" class="img-fluid">
        </div>

        <h3 class="font-24 mt-6">{{ $form->heading_title }}</h3>
    </div>

    <div class="forms-body-welcome-message white-space-pre-wrap mt-15 text-sm text-slate-500">{!! $form->description !!}</div>

    {{-- Inputs --}}
    <form action="/forms/{{ $form->url }}/store" method="post" class="mt-6">
        {{ csrf_field() }}

        @include('web.jiujitsu.forms.handle_field',['fields' => $form->fields])

        <div class="flex items-center justify-end mt-6">
            <button type="button" class="js-clear-form btn bg-red-600 text-white mr-10">{{ trans('update.clear_form') }}</button>

            <button type="submit" class="btn btn-primary">{{ trans('update.submit_form') }}</button>
        </div>
    </form>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/admin/form_submissions_details.min.js"></script>
@endpush
