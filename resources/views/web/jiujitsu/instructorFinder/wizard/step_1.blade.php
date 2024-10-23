<div class="wizard-step-1">
    <h3 class="font-20 text-dark font-bold">{{ trans('update.skill_topic') }}</h3>

    <span class="block mt-6 text-slate-500 wizard-step-num">
        {{ trans('update.step') }} 1/4
    </span>

    <div class="form-group mt-6">
        <label class="input-label font-medium">{{ trans('update.which_category_are_you_interested') }}</label>

        <select name="category_id" class="form-control mt-4 @error('category_id') is-invalid @enderror">
            <option value="">{{ trans('webinars.select_category') }}</option>

            @if(!empty($categories))
                @foreach($categories as $category)
                    @if(!empty($category->subCategories) and count($category->subCategories))
                        <optgroup label="{{  $category->title }}">
                            @foreach($category->subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @if(request()->get('category_id') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                            @endforeach
                        </optgroup>
                    @else
                        <option value="{{ $category->id }}" @if(request()->get('category_id') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        @error('category_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

</div>
