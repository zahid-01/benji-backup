@extends('web.jiujitsu.layouts.app',['appFooter' => false])

@section('content')
    <div class="instructor-finder-wizard row">
        <div class="col-12 col-lg-4 wizard-left-side hidden d-mblock" style="background-image: url('{{ getPageBackgroundSettings('instructor_finder_wizard') }}')">
            <div class="wizard-left-side-content relative w-full h-100 flex align-items-end justify-center">
                <div class="">
                    <h1 class="font-36 font-bold text-white">{{ trans('update.looking_for_an_instructor') }}</h1>
                    <p class="text-white font-16">{{ trans('update.looking_for_an_instructor_hint') }}</p>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex flex-col items-center">
                            <span class="wizard-stat-icon flex items-center justify-center rounded-full text-white">
                                <i data-feather="user" width="30" height="30" class="text-white"></i>
                            </span>
                            <span class="text-3xl font-bold text-white mt-10">{{ $instructorsCount }}</span>
                            <span class="text-sm text-white">{{ trans('home.instructors') }}</span>
                        </div>

                        <div class="flex flex-col items-center">
                            <span class="wizard-stat-icon flex items-center justify-center rounded-full text-white">
                                <i data-feather="briefcase" width="30" height="30" class="text-white"></i>
                            </span>
                            <span class="text-3xl font-bold text-white mt-10">{{ $organizationsCount }}</span>
                            <span class="text-sm text-white">{{ trans('home.organizations') }}</span>
                        </div>

                        <div class="flex flex-col items-center">
                            <span class="wizard-stat-icon flex items-center justify-center rounded-full text-white">
                                <i data-feather="map-pin" width="30" height="30" class="text-white"></i>
                            </span>
                            <span class="text-3xl font-bold text-white mt-10">{{ $citiesCount }}</span>
                            <span class="text-sm text-white">{{ trans('update.cities') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8 bg-white">
            <div class="row wizard-content flex align-items-lg-center justify-content-lg-center">
                <div class="col-12 col-lg-5">

                    <form action="/instructor-finder/wizard?{{ http_build_query(request()->all()) }}" method="get">
                        @if(!empty(request()->all()) and count(request()->all()))
                            @foreach(request()->all() as $param => $value)
                                @if($param !== 'step')
                                    <input type="hidden" name="{{ $param }}" value="{{ $value }}">
                                @endif
                            @endforeach
                        @endif

                        <input type="hidden" name="step" value="{{ $step + 1 }}">

                        @include('web.jiujitsu.instructorFinder.wizard.step_'.$step)

                        <div class="mt-50 pt-20 border-top border-gray300 flex items-center justify-end">
                            <a href="{{ url()->previous() }}" class="js-prev-btn btn btn-gray300 btn-sm text-slate-500 {{ ($step == 1) ? 'disabled' : '' }}" >{{ trans('update.prev') }}</a>

                            <button type="submit" class="btn btn-primary btn-sm ml-10">{{ trans('webinars.next') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script>
        var selectProvinceLang = '{{ trans('update.select_province') }}';
        var selectCityLang = '{{ trans('update.select_city') }}';
        var selectDistrictLang = '{{ trans('update.select_district') }}';
    </script>

    <script src="/assets/default/js/parts/get-regions.min.js"></script>
    <script src="/assets/default/js/parts/instructor-finder-wizard.min.js"></script>
@endpush
