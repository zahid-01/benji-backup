@if(!empty($upcomingCourse->webinar_id))
    <div class="flex items-center mt-4 p-15 success-transparent-alert">
        <div class="success-transparent-alert__icon flex items-center justify-center">
            <i data-feather="check-circle" width="18" height="18" class=""></i>
        </div>
        <div class="ml-10">
            <div class="text-sm font-bold ">{{ trans('update.course_published') }}</div>
            <div class="text-sm ">{{ trans('update.this_course_was_published_already_and_you_can_check_the_main_course') }}</div>
        </div>
    </div>

    @include('web.jiujitsu.includes.webinar.list-card',['webinar' => $upcomingCourse->webinar])
@endif


@php
    $learningMaterialsExtraDescription = !empty($upcomingCourse->extraDescriptions) ? $upcomingCourse->extraDescriptions->where('type','learning_materials') : null;
    $companyLogosExtraDescription = !empty($upcomingCourse->extraDescriptions) ? $upcomingCourse->extraDescriptions->where('type','company_logos') : null;
    $requirementsExtraDescription = !empty($upcomingCourse->extraDescriptions) ? $upcomingCourse->extraDescriptions->where('type','requirements') : null;
@endphp

@if(!empty($learningMaterialsExtraDescription) and count($learningMaterialsExtraDescription))
    <div class="mt-4 rounded-sm border bg-info-light p-15">
        <h3 class="font-16 text-black font-bold mb-15">{{ trans('update.what_you_will_learn') }}</h3>

        @foreach($learningMaterialsExtraDescription as $learningMaterial)
            <p class="flex align-items-start text-sm text-slate-500 mt-10">
                <i data-feather="check" width="18" height="18" class="mr-10 webinar-extra-description-check-icon"></i>
                <span class="">{{ $learningMaterial->value }}</span>
            </p>
        @endforeach
    </div>
@endif

{{--course description--}}
@if($upcomingCourse->description)
    <div class="mt-4">
        <h2 class="section-title after-line">{{ trans('update.course_description') }}</h2>
        <div class="mt-15 course-description">
            {!! clean($upcomingCourse->description) !!}
        </div>
    </div>
@endif
{{-- ./ course description--}}

@if(!empty($companyLogosExtraDescription) and count($companyLogosExtraDescription))
    <div class="mt-4 rounded-sm border bg-white p-15">
        <div class="mb-15">
            <h3 class="font-16 text-black font-bold">{{ trans('update.suggested_by_top_companies') }}</h3>
            <p class="text-sm text-slate-500 mt-5">{{ trans('update.suggested_by_top_companies_hint') }}</p>
        </div>

        <div class="row">
            @foreach($companyLogosExtraDescription as $companyLogo)
                <div class="col text-center">
                    <img src="{{ $companyLogo->value }}" class="webinar-extra-description-company-logos" alt="{{ trans('update.company_logos') }}">
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(!empty($requirementsExtraDescription) and count($requirementsExtraDescription))
    <div class="mt-4">
        <h3 class="font-16 text-black font-bold mb-15">{{ trans('update.requirements') }}</h3>

        @foreach($requirementsExtraDescription as $requirementExtraDescription)
            <p class="flex align-items-start text-sm text-slate-500 mt-10">
                <i data-feather="check" width="18" height="18" class="mr-10 webinar-extra-description-check-icon"></i>
                <span class="">{{ $requirementExtraDescription->value }}</span>
            </p>
        @endforeach
    </div>
@endif


{{-- course FAQ --}}
@if(!empty($upcomingCourse->faqs) and $upcomingCourse->faqs->count() > 0)
    <div class="mt-4">
        <h2 class="section-title after-line">{{ trans('public.faq') }}</h2>

        <div class="accordion-content-wrapper mt-15" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($upcomingCourse->faqs as $faq)
                <div class="accordion-row rounded-sm shadow-lg border mt-4 py-20 px-35">
                    <div class="font-bold text-sm text-black" role="tab" id="faq_{{ $faq->id }}">
                        <div href="#collapseFaq{{ $faq->id }}" aria-controls="collapseFaq{{ $faq->id }}" class="flex items-center justify-between" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                            <span>{{ clean($faq->title,'title') }}</span>
                            <i class="collapse-chevron-icon" data-feather="chevron-down" width="25" class="text-slate-500"></i>
                        </div>
                    </div>
                    <div id="collapseFaq{{ $faq->id }}" aria-labelledby="faq_{{ $faq->id }}" class=" collapse" role="tabpanel">
                        <div class="panel-collapse text-slate-500">
                            {{ clean($faq->answer,'answer') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- ./ course FAQ --}}

{{-- course Comments --}}
@include('web.jiujitsu.includes.comments',[
        'comments' => $upcomingCourse->comments,
        'inputName' => 'upcoming_course_id',
        'inputValue' => $upcomingCourse->id
    ])
{{-- ./ course Comments --}}
