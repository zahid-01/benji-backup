@extends('web.jiujitsu.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
    <section>
        <h2 class="section-title">{{ trans('update.overview') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/upcoming.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $totalCourses }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.total_courses') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/webinars.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $releasedCourses }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.released_courses') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/hours.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $notReleased }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.not_released') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-6 mt-md-0 flex items-center justify-center mt-5 mt-md-0">
                    <div class="flex flex-col items-center text-center">
                        <img src="/assets/default/img/activity/49.svg" width="64" height="64" alt="">
                        <strong class="text-3xl text-dark-blue font-bold mt-5">{{ $followers }}</strong>
                        <span class="font-16 text-slate-500 font-medium">{{ trans('update.followers') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-25">
        <div class="flex align-items-start align-items-md-center justify-between flex-col flex-md-row">
            <h2 class="section-title">{{ trans('update.my_upcoming_courses') }}</h2>

            <form action="" method="get">
                <div class="flex items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-4 mt-md-0">
                    <label class="cursor-pointer mb-0 mr-10 font-medium text-sm text-slate-500" for="onlyReleasedSwitch">{{ trans('update.only_not_released_courses') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="only_not_released_courses" @if(request()->get('only_not_released_courses','') == 'on') checked @endif class="custom-control-input" id="onlyReleasedSwitch">
                        <label class="custom-control-label" for="onlyReleasedSwitch"></label>
                    </div>
                </div>
            </form>
        </div>

        @if(!empty($upcomingCourses) and !$upcomingCourses->isEmpty())
            @foreach($upcomingCourses as $upcomingCourse)
                <div class="row mt-6">
                    <div class="col-12">
                        <div class="webinar-card webinar-list flex">
                            <div class="image-box">
                                <img src="{{ $upcomingCourse->getImage() }}" class="img-cover" alt="">

                                @if(!empty($upcomingCourse->webinar_id))
                                    <span class="badge badge-secondary">{{  trans('update.released') }}</span>
                                @else
                                    @switch($upcomingCourse->status)
                                        @case(\App\Models\UpcomingCourse::$active)
                                            <span class="badge badge-primary">{{  trans('public.published') }}</span>
                                            @break
                                        @case(\App\Models\UpcomingCourse::$isDraft)
                                            <span class="badge badge-danger">{{ trans('public.draft') }}</span>
                                            @break
                                        @case(\App\Models\UpcomingCourse::$pending)
                                            <span class="badge badge-warning">{{ trans('public.waiting') }}</span>
                                            @break
                                        @case(\App\Models\UpcomingCourse::$inactive)
                                            <span class="badge badge-danger">{{ trans('public.rejected') }}</span>
                                            @break
                                    @endswitch
                                @endif

                                @if(!empty($upcomingCourse->course_progress))
                                    <div class="progress">
                                        <span class="progress-bar {{ ($upcomingCourse->course_progress < 50) ? 'bg-warning' : '' }}" style="width: {{ $upcomingCourse->course_progress }}%"></span>
                                    </div>
                                @endif
                            </div>

                            <div class="webinar-card-body w-full flex flex-col">
                                <div class="flex items-center justify-between">
                                    <a href="{{ $upcomingCourse->getUrl() }}" target="_blank">
                                        <h3 class="font-16 text-dark-blue font-bold">{{ $upcomingCourse->title }}
                                            <span class="badge badge-dark ml-10 status-badge-dark">{{ trans('webinars.'.$upcomingCourse->type) }}</span>
                                        </h3>
                                    </a>

                                    @if($upcomingCourse->canAccess($authUser))
                                        <div class="btn-group dropdown table-actions">
                                            <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="more-vertical" height="20"></i>
                                            </button>
                                            <div class="dropdown-menu ">
                                                @if(!empty($upcomingCourse->webinar_id))
                                                    <a href="{{ $upcomingCourse->webinar->getUrl() }}" class="webinar-actions block text-primary">{{ trans('update.view_course') }}</a>
                                                @else
                                                    @if($upcomingCourse->status == \App\Models\UpcomingCourse::$isDraft)
                                                        <a href="/panel/upcoming_courses/{{ $upcomingCourse->id }}/step/4" class="js-send-for-reviewer webinar-actions btn-ghost block text-primary">{{ trans('update.send_for_reviewer') }}</a>
                                                    @elseif($upcomingCourse->status == \App\Models\UpcomingCourse::$active)
                                                        <button type="button" data-id="{{ $upcomingCourse->id }}" class="js-mark-as-released webinar-actions btn-ghost block text-primary">{{ trans('update.mark_as_released') }}</button>
                                                    @endif

                                                    <a href="/panel/upcoming_courses/{{ $upcomingCourse->id }}/edit" class="webinar-actions block mt-10">{{ trans('public.edit') }}</a>
                                                @endif

                                                @if($upcomingCourse->status == \App\Models\UpcomingCourse::$active)
                                                    <a href="/panel/upcoming_courses/{{ $upcomingCourse->id }}/followers" class="webinar-actions block mt-10">{{ trans('update.view_followers') }}</a>
                                                @endif

                                                @if($upcomingCourse->creator_id == $authUser->id)
                                                    <a href="/panel/upcoming_courses/{{ $upcomingCourse->id }}/delete" class="webinar-actions block mt-10 text-danger delete-action">{{ trans('public.delete') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between flex-wrap mt-auto">
                                    <div class="flex align-items-start flex-col mt-4 mr-15">
                                        <span class="stat-title">{{ trans('public.item_id') }}:</span>
                                        <span class="stat-value">{{ $upcomingCourse->id }}</span>
                                    </div>

                                    <div class="flex align-items-start flex-col mt-4 mr-15">
                                        <span class="stat-title">{{ trans('public.category') }}:</span>
                                        <span class="stat-value">{{ !empty($upcomingCourse->category_id) ? $upcomingCourse->category->title : '' }}</span>
                                    </div>

                                    @if(!empty($upcomingCourse->duration))
                                        <div class="flex align-items-start flex-col mt-4 mr-15">
                                            <span class="stat-title">{{ trans('public.duration') }}:</span>
                                            <span class="stat-value">{{ convertMinutesToHourAndMinute($upcomingCourse->duration) }} Hrs</span>
                                        </div>
                                    @endif

                                    @if(!empty($upcomingCourse->publish_date))
                                        <div class="flex align-items-start flex-col mt-4 mr-15">
                                            <span class="stat-title">{{ trans('update.estimated_publish_date') }}:</span>
                                            <span class="stat-value">{{ dateTimeFormat($upcomingCourse->publish_date, 'j M Y H:i') }}</span>
                                        </div>
                                    @endif

                                    <div class="flex align-items-start flex-col mt-4 mr-15">
                                        <span class="stat-title">{{ trans('public.price') }}:</span>
                                        <span class="stat-value">{{ (!empty($upcomingCourse->price)) ? handlePrice($upcomingCourse->price) : trans('public.free') }}</span>
                                    </div>

                                    <div class="flex align-items-start flex-col mt-4 mr-15">
                                        <span class="stat-title">{{ trans('update.followers') }}:</span>
                                        <span class="stat-value">{{ $upcomingCourse->followers_count ?? 0 }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="my-30">
                {{ $upcomingCourses->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>

        @else
            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'webinar.png',
                'title' => trans('update.you_not_have_any_upcoming_courses'),
                'hint' =>  trans('update.you_not_have_any_upcoming_courses_hint') ,
                'btn' => ['url' => '/panel/upcoming_courses/new','text' => trans('update.create_a_upcoming_course') ]
            ])
        @endif
    </section>
@endsection

@push('scripts_bottom')

    <script src="/assets/default/js/panel/upcoming_course.min.js"></script>
@endpush
