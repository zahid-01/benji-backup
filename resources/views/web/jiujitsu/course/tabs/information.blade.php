@php
    $learningMaterialsExtraDescription = !empty($course->webinarExtraDescription) ? $course->webinarExtraDescription->where('type', 'learning_materials') : null;
    $companyLogosExtraDescription = !empty($course->webinarExtraDescription) ? $course->webinarExtraDescription->where('type', 'company_logos') : null;
    $requirementsExtraDescription = !empty($course->webinarExtraDescription) ? $course->webinarExtraDescription->where('type', 'requirements') : null;
@endphp


{{-- Installments --}}
@if (
    !empty($installments) and
        count($installments) and
        getInstallmentsSettings('installment_plans_position') == 'top_of_page')
    @foreach ($installments as $installmentRow)
        @include('web.jiujitsu.installment.card', [
            'installment' => $installmentRow,
            'itemPrice' => $course->getPrice(),
            'itemId' => $course->id,
            'itemType' => 'course',
        ])
    @endforeach
@endif

@if (!empty($learningMaterialsExtraDescription) and count($learningMaterialsExtraDescription))
    <div class="py-4">
        <h3 class="font-bold">{{ trans('update.what_you_will_learn') }}</h3>

        @foreach ($learningMaterialsExtraDescription as $learningMaterial)
            <p class="flex text-sm mt-3">
                <i data-feather="check" width="18" height="18" class="mr-2 webinar-extra-description-check-icon"></i>
                <span class="">{{ $learningMaterial->value }}</span>
            </p>
        @endforeach
    </div>
@endif

{{-- course description --}}
@if ($course->description)
    <div class="mt-5">
        <h2 class="font-bold">{{ trans('product.Webinar_description') }}</h2>
        <div class="mt-6 font-light course-description">
            {!! nl2br($course->description) !!}
        </div>
    </div>
@endif
{{-- ./ course description --}}

@if (!empty($companyLogosExtraDescription) and count($companyLogosExtraDescription))
    <div class="mt-8">
        <div class="">
            <h3 class="font-bold">{{ trans('update.suggested_by_top_companies') }}</h3>
            <p class="text-sm text-slate-500 mt-1">{{ trans('update.suggested_by_top_companies_hint') }}</p>
        </div>

        <div class="grid grid-flow-col">
            @foreach ($companyLogosExtraDescription as $companyLogo)
                <div class="text-center">
                    <img src="{{ $companyLogo->value }}" class="webinar-extra-description-company-logos"
                        alt="{{ trans('update.company_logos') }}">
                </div>
            @endforeach
        </div>
    </div>
@endif

@if (!empty($requirementsExtraDescription) and count($requirementsExtraDescription))
    <div class="mt-8">
        <h3 class="font-bold mb-4">{{ trans('update.requirements') }}</h3>

        @foreach ($requirementsExtraDescription as $requirementExtraDescription)
            <p class="flex text-sm text-slate-500">
                <i data-feather="check" width="18" height="18"
                    class="mr-2 webinar-extra-description-check-icon"></i>
                <span class="">{{ $requirementExtraDescription->value }}</span>
            </p>
        @endforeach
    </div>
@endif

{{-- course prerequisites --}}
@if (!empty($course->prerequisites) and $course->prerequisites->count() > 0)

    <div class="mt-8">
        <h2 class="font-bold">{{ trans('public.prerequisites') }}</h2>

        <div class="grid grid-cols-1 gap-4 mt-4 filter-tabs">
            @foreach ($course->prerequisites as $prerequisite)
                @if ($prerequisite->prerequisiteWebinar)
                    @include('web.jiujitsu.includes.webinar.list-card', [
                        'webinar' => $prerequisite->prerequisiteWebinar,
                    ])
                @endif
            @endforeach
        </div>
    </div>
@endif
{{-- ./ course prerequisites --}}

{{-- course FAQ --}}
@if (!empty($course->faqs) and $course->faqs->count() > 0)


    <div class="mt-8">
        <h2 class="font-bold">{{ trans('public.faq') }}</h2>

        <div class="join join-vertical w-full mt-4">

            @foreach ($course->faqs as $faq)
                <div class="collapse collapse-arrow join-item border border-base-300">
                    <input type="checkbox" name="course-faq" />

                    <div class="collapse-title text-xl font-medium">
                        {{ clean($faq->title, 'title') }}
                    </div>
                    <div class="collapse-content">
                        {{ clean($faq->answer, 'answer') }}
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- ./ course FAQ --}}

{{-- Installments --}}
@if (
    !empty($installments) and
        count($installments) and
        getInstallmentsSettings('installment_plans_position') == 'bottom_of_page')
    @foreach ($installments as $installmentRow)
        @include('web.jiujitsu.installment.card', [
            'installment' => $installmentRow,
            'itemPrice' => $course->getPrice(),
            'itemId' => $course->id,
            'itemType' => 'course',
        ])
    @endforeach
@endif

{{-- course Comments --}}
@include('web.jiujitsu.includes.comments', [
    'comments' => $course->comments,
    'inputName' => 'webinar_id',
    'inputValue' => $course->id,
])
{{-- ./ course Comments --}}
