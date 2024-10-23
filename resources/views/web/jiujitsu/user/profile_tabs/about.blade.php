@if($user->offline)
    <div class="user-offline-alert flex mt-4">
        <div class="p-15">
            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
            <p class="text-sm font-medium text-slate-500 mt-15">{{ $user->offline_message }}</p>
        </div>

        <div class="offline-icon offline-icon-right ml-auto flex align-items-stretch">
            <div class="flex items-center">
                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
            </div>
        </div>
    </div>
@endif

@if((!empty($educations) and !$educations->isEmpty()) or (!empty($experiences) and !$experiences->isEmpty()) or (!empty($occupations) and !$occupations->isEmpty()) or !empty($user->about))
    @if(!empty($educations) and !$educations->isEmpty())
        <div class="mt-4">
            <h3 class="font-16 text-dark-blue font-bold">{{ trans('site.education') }}</h3>

            <ul class="list-group-custom">
                @foreach($educations as $education)
                    <li class="mt-15 text-slate-500">{{ $education->value }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!empty($experiences) and !$experiences->isEmpty())
        <div class="mt-4">
            <h3 class="font-16 text-dark-blue font-bold">{{ trans('site.experiences') }}</h3>

            <ul class="list-group-custom">
                @foreach($experiences as $experience)
                    <li class="mt-15 text-slate-500">{{ $experience->value }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!empty($user->about))
        <div class="mt-4">
            <h3 class="font-16 text-dark-blue font-bold">{{ trans('site.about') }}</h3>

            <div class="mt-6">
                {!! nl2br($user->about) !!}
            </div>
        </div>
    @endif

    @if(!empty($occupations) and !$occupations->isEmpty())
        <div class="my-14 pb-14">
            <h3 class="font-16 text-dark-blue font-bold">{{ trans('site.occupations') }}</h3>

            <div class="flex flex-wrap items-center pt-2">
                @foreach($occupations as $occupation)
                    <div class="bg-slate-300 text-sm rounded mt-1 px-3 py-2 text-slate-500 mr-3">{{ $occupation->category->title }}</div>
                @endforeach
            </div>
        </div>
    @endif

@else

    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'bio.png',
        'title' => trans('site.not_create_bio'),
        'hint' => '',
    ])

@endif

