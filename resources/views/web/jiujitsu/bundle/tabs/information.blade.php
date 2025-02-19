
{{-- Installments --}}
@if(!empty($installments) and count($installments) and getInstallmentsSettings('installment_plans_position') == 'top_of_page')
    @foreach($installments as $installmentRow)
        @include('web.jiujitsu.installment.card',['installment' => $installmentRow, 'itemPrice' => $bundle->getPrice(), 'itemId' => $bundle->id, 'itemType' => 'bundles'])
    @endforeach
@endif

{{--course description--}}
@if($bundle->description)
    <div class="mt-4">
        <h2 class="section-title after-line">{{ trans('update.bundle_description') }}</h2>
        <div class="mt-15 course-description">
            {!! clean($bundle->description) !!}
        </div>
    </div>
@endif
{{-- ./ course description--}}


{{-- course FAQ --}}
@if(!empty($bundle->faqs) and $bundle->faqs->count() > 0)
    <div class="mt-4">
        <h2 class="section-title after-line">{{ trans('public.faq') }}</h2>

        <div class="accordion-content-wrapper mt-15" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($bundle->faqs as $faq)
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


{{-- Installments --}}
@if(!empty($installments) and count($installments) and getInstallmentsSettings('installment_plans_position') == 'bottom_of_page')
    @foreach($installments as $installmentRow)
        @include('web.jiujitsu.installment.card',['installment' => $installmentRow, 'itemPrice' => $bundle->getPrice(), 'itemId' => $bundle->id, 'itemType' => 'bundles'])
    @endforeach
@endif


{{-- course Comments --}}
@include('web.jiujitsu.includes.comments',[
        'comments' => $bundle->comments,
        'inputName' => 'bundle_id',
        'inputValue' => $bundle->id
    ])
{{-- ./ course Comments --}}
