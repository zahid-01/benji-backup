@php
    $progressSteps = [
        1 => [
            'name' => 'basic_information',
            'icon' => 'paper'
        ],

        2 => [
            'name' => 'extra_information',
            'icon' => 'paper_plus'
        ],

        3 => [
            'name' => 'pricing',
            'icon' => 'wallet'
        ],

        4 => [
            'name' => 'content',
            'icon' => 'folder'
        ],

        5 => [
            'name' => 'faq',
            'icon' => 'tick_square'
        ],

        6 => [
            'name' => 'message_to_reviewer',
            'icon' => 'shield_done'
        ],
    ];

    $currentStep = empty($currentStep) ? 1 : $currentStep;
@endphp


<div class="webinar-progress block lg:flex items-center p-15 panel-shadow bg-white rounded-sm">

    @foreach($progressSteps as $key => $step)
        <div class="progress-item flex items-center">
            <button type="button" data-step="{{ $key }}" class="js-get-next-step p-0 border-0 progress-icon p-10 flex items-center justify-center rounded-full {{ $key == $currentStep ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="{{ trans('public.' . $step['name']) }}">
                <img src="/assets/default/img/icons/{{ $step['icon'] }}.svg" class="img-cover" alt="">
            </button>

            <div class="ml-10 {{ $key == $currentStep ? '' : 'lg:hidden' }}">
                <span class="text-sm text-slate-500">{{ trans('webinars.progress_step', ['step' => $key,'count' => 6]) }}</span>
                <h4 class="font-16 text-black font-bold">{{ trans('public.' . $step['name']) }}</h4>
            </div>
        </div>
    @endforeach
</div>
