<div class="product-show-description-tab mt-4">
    @if($product->description)
        <div class="course-description">
            {!! $product->description !!}
        </div>
    @endif

    {{-- FAQ --}}
    @if(!empty($product->faqs) and $product->faqs->count() > 0)
        <div class="mt-4 mt-lg-30">
            <h2 class="section-title after-line">{{ trans('public.faq') }}</h2>

            <div class="accordion-content-wrapper mt-15" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($product->faqs as $faq)
                    <div class="accordion-row rounded-sm shadow-lg border mt-4 py-20 px-35">
                        <div class="font-bold text-sm text-black" role="tab" id="faq_{{ $faq->id }}">
                            <div href="#collapseFaq{{ $faq->id }}" aria-controls="collapseFaq{{ $faq->id }}" class="flex items-center justify-between" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                                <span>{{ clean($faq->title,'title') }}?</span>
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
    {{-- ./ FAQ --}}

    @if(!empty(getStoreSettings('activate_comments')) and getStoreSettings('activate_comments'))
        {{-- product Comments --}}
        @include('web.jiujitsu.includes.comments',[
                'comments' => $product->comments,
                'inputName' => 'product_id',
                'inputValue' => $product->id
            ])
        {{-- ./ product Comments --}}
    @endif
</div>
