@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
    <div class="">

        <form method="post" action="/panel/bundles/{{ !empty($bundle) ? $bundle->id .'/update' : 'store' }}" id="webinarForm" class="webinar-form">
            @include('web.jiujitsu.panel.bundle.create_includes.progress')

            {{ csrf_field() }}
            <input type="hidden" name="current_step" value="{{ !empty($currentStep) ? $currentStep : 1 }}">
            <input type="hidden" name="draft" value="no" id="forDraft"/>
            <input type="hidden" name="get_next" value="no" id="getNext"/>
            <input type="hidden" name="get_step" value="0" id="getStep"/>


            @if($currentStep == 1)
                @include('web.jiujitsu.panel.bundle.create_includes.step_1')
            @elseif(!empty($bundle))
                @include('web.jiujitsu.panel.bundle.create_includes.step_'.$currentStep)
            @endif

        </form>


        <div class="create-bundle-footer flex flex-col flex-md-row items-center justify-between mt-4 pt-15 border-top">
            <div class="flex items-center">

                @if(!empty($bundle))
                    <a href="/panel/bundles/{{ $bundle->id }}/step/{{ ($currentStep - 1) }}" class="btn btn-sm btn-primary {{ $currentStep < 2 ? 'disabled' : '' }}">{{ trans('webinars.previous') }}</a>
                @else
                    <a href="" class="btn btn-sm btn-primary disabled">{{ trans('webinars.previous') }}</a>
                @endif

                <button type="button" id="getNextStep" class="btn btn-sm btn-primary ml-15" @if($currentStep >= 8) disabled @endif>{{ trans('webinars.next') }}</button>
            </div>

            <div class="mt-4 mt-md-0">
                <button type="button" id="sendForReview" class="btn btn-sm btn-primary">{{ trans('public.send_for_review') }}</button>

                <button type="button" id="saveAsDraft" class=" btn btn-sm btn-primary">{{ trans('public.save_as_draft') }}</button>

                @if(!empty($bundle) and $bundle->creator_id == $authUser->id)
                    <a href="/panel/bundles/{{ $bundle->id }}/delete?redirect_to=/panel/bundles" class="delete-action bundle-actions btn btn-sm bg-red-600 text-white mt-4 mt-md-0">{{ trans('public.delete') }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    </script>

    <script src="/assets/default/js/panel/webinar.min.js"></script>
    <script src="/assets/default/js/panel/new_bundle.min.js"></script>
@endpush
