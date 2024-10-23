<section class="mt-6">
    <h2 class="section-title after-line">{{ trans('site.occupations') }}</h2>

    <div class="mt-4 flex items-center flex-wrap">
        @foreach($categories as $category)
            @if(!empty($category->subCategories) and count($category->subCategories))
                @foreach($category->subCategories as $subCategory)
                    <div class="checkbox-button mr-15 mt-10">
                        <input type="checkbox" name="occupations[]" id="checkbox{{ $subCategory->id }}" value="{{ $subCategory->id }}" @if(in_array($subCategory->id,$occupations)) checked="checked" @endif>
                        <label class="text-sm" for="checkbox{{ $subCategory->id }}">{{ $subCategory->title }}</label>
                    </div>
                @endforeach
            @else
                <div class="checkbox-button mr-15 mt-10">
                    <input type="checkbox" name="occupations[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}" @if(in_array($category->id,$occupations)) checked="checked" @endif>
                    <label class="text-sm" for="checkbox{{ $category->id }}">{{ $category->title }}</label>
                </div>
            @endif
        @endforeach
    </div>

    <div class="mt-15">
        <p class="text-sm text-slate-500">- {{ trans('panel.interests_hint_1') }}</p>
        <p class="text-sm text-slate-500">- {{ trans('panel.interests_hint_2') }}</p>
    </div>

</section>
