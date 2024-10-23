<div id="upcomingAssignCourseModal" class="" data-action="/panel/upcoming_courses/{{ $upcomingCourse->id }}/assign-course">
    <div class="custom-modal-body">
        <h2 class="section-title after-line">{{ trans('update.assign_published_course') }}</h2>

        <div class="mt-4">
            <input type="hidden" name="upcoming_id" value="{{ $upcomingCourse->id }}">

            <div class="form-group">
                <label class="input-label">{{ trans('product.course') }}</label>
                <select name="course" class="js-ajax-course form-control js-select2">
                    <option value="">{{ trans('update.select_a_course') }}</option>
                    @foreach($webinars as $webinar)
                        <option value="{{ $webinar->id }}">{{ $webinar->title }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback block"></div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="js-save-assign-course btn btn-sm btn-primary">{{ trans('public.save') }}</button>
                <button type="button" class="close-swl btn btn-sm bg-red-600 text-white ml-2">{{ trans('public.close') }}</button>
            </div>
        </div>
    </div>
</div>
