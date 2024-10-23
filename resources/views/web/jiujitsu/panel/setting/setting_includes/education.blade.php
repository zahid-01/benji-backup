<section class="mt-6">
    <div class="flex justify-between items-center mb-10">
        <h2 class="section-title after-line">{{ trans('site.education') }}</h2>
        <button id="userAddEducations" type="button" class="btn btn-primary btn-sm">{{ trans('site.add_education') }}</button>
    </div>

    <div id="userListEducations">

        @if(!empty($educations) and !$educations->isEmpty())
            @foreach($educations as $education)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="education-card py-15 py-lg-30 px-10 px-lg-25 rounded-sm panel-shadow bg-white flex items-center justify-between">
                            <div class="col-8 text-black text-left font-medium education-value">{{ $education->value }}</div>
                            <div class="col-2 text-right">
                                <div class="btn-group dropdown table-actions">
                                    <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-vertical" height="20"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" data-education-id="{{ $education->id }}" data-user-id="{{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="block btn-ghost edit-education">{{ trans('public.edit') }}</button>
                                        <a href="/panel/setting/metas/{{ $education->id }}/delete?user_id={{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="delete-action block mt-10 btn-ghost">{{ trans('public.delete') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else

            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'edu.png',
                'title' => trans('auth.education_no_result'),
                'hint' => trans('auth.education_no_result_hint'),
            ])
        @endif
    </div>

</section>

<div class="hidden" id="newEducationModal">
    <h3 class="section-title after-line">{{ trans('site.new_education') }}</h3>
    <div class="mt-4 text-center">
        <img src="/assets/default/img/info.png" width="108" height="96" class="rounded-full" alt="">
        <h4 class="font-16 mt-4 text-dark-blue font-bold">{{ trans('site.new_education_hint') }}</h4>
        <span class="block mt-10 text-slate-500 text-sm">{{ trans('site.new_education_exam') }}</span>
        <div class="form-group mt-15 px-50">
            <input type="text" id="new_education_val" class="form-control">
            <div class="invalid-feedback">{{ trans('validation.required',['attribute' => 'value']) }}</div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end">
        <button type="button" id="saveEducation" class="btn btn-sm btn-primary">{{ trans('public.save') }}</button>
        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>
