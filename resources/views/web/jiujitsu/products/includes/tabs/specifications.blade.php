<div class="product-show-specifications-tab mt-4">
    @if(!empty($selectedSpecifications) and count($selectedSpecifications))
        @foreach($selectedSpecifications as $selectedSpecification)
            <div class="product-show-specification-item flex">
                <div class="specification-item-name {{ ($loop->iteration > 1) ? 'mt-15 pt-15' : '' }}">
                    {{ $selectedSpecification->specification->title }}
                </div>

                <div class="specification-item-value grow {{ ($loop->iteration > 1) ? 'mt-15 pt-15 border-top border-gray200' : '' }}">
                    @if($selectedSpecification->type == 'textarea')
                        {!! nl2br($selectedSpecification->value) !!}
                    @elseif(!empty($selectedSpecification->selectedMultiValues))
                        @foreach($selectedSpecification->selectedMultiValues as $selectedSpecificationValue)
                            @if(!empty($selectedSpecificationValue->multiValue))
                                <span class="block mt-5">{{ $selectedSpecificationValue->multiValue->title }}</span>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
