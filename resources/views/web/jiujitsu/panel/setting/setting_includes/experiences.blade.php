<section class="mt-6">
    <div class="flex justify-between items-center mb-10">
        <h2 class="section-title after-line">{{ trans('site.experiences') }}</h2>
        <button id="userAddExperiences" type="button" class="btn btn-primary btn-sm">{{ trans('site.add_experiences') }}</button>
    </div>

    <div id="userListExperiences">

        @if(!empty($experiences) and !$experiences->isEmpty())
            @foreach($experiences as $experience)

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="experience-card py-15 py-lg-30 px-10 px-lg-25 rounded-sm panel-shadow bg-white flex items-center justify-between">
                            <div class="col-8 text-black font-medium text-left experience-value">{{ $experience->value }}</div>
                            <div class="col-2 text-right">
                                <div class="btn-group dropdown table-actions">
                                    <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-vertical" height="20"></i>
                                    </button>
                                    <div class="dropdown-menu font-weight-normal">
                                        <button type="button" data-experience-id="{{ $experience->id }}" data-user-id="{{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="block btn-ghost edit-experience">{{ trans('public.edit') }}</button>
                                        <a href="/panel/setting/metas/{{ $experience->id }}/delete?user_id={{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="delete-action block mt-10 btn-ghost">{{ trans('public.delete') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'exp.png',
                'title' => trans('auth.experience_no_result'),
                'hint' => trans('auth.experience_no_result_hint'),
            ])
        @endif
    </div>

</section>

<div class="hidden" id="newExperienceModal">
    <h3 class="section-title after-line">{{ trans('site.new_experience') }}</h3>
    <div class="mt-4 text-center">
        <img src="/assets/default/img/info.png" width="108" height="96" class="rounded-full" alt="">
        <h4 class="font-16 mt-4 text-dark-blue font-bold">{{ trans('site.new_experience_hint') }}</h4>
        <span class="block mt-10 text-slate-500 text-sm">{{ trans('site.new_experience_exam') }}</span>
        <div class="form-group mt-15 px-50">
            <input type="text" id="new_experience_val" class="form-control">
            <div class="invalid-feedback">{{ trans('validation.required',['attribute' => 'value']) }}</div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end">
        <button type="button" id="saveExperience" class="btn btn-sm btn-primary">{{ trans('public.save') }}</button>
        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>
