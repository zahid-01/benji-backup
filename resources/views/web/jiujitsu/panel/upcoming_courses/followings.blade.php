@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')

    <section>
        <div class="flex items-center justify-between">
            <h2 class="section-title">{{ trans('update.following_courses') }}</h2>
        </div>

        @if(!empty($upcomingCourses) and $upcomingCourses->isNotEmpty())

            @foreach($upcomingCourses as $upcomingCourse)
                <div class="row mt-6">
                    <div class="col-12">
                        <div class="webinar-card webinar-list flex">
                            <div class="image-box">
                                <img src="{{ $upcomingCourse->getImage() }}" class="img-cover" alt="">

                                {{--@if(!empty($upcomingCourse->webinar_id))
                                    <span class="badge badge-secondary">{{  trans('update.released') }}</span>
                                @elseif($upcomingCourse->status == \App\Models\UpcomingCourse::$active)
                                    <span class="badge badge-primary">{{  trans('public.published') }}</span>
                                @endif--}}

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
                                            <span class="stat-title">{{ trans('webinars.next_session_duration') }}:</span>
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
                                        <span class="stat-value">{{ (!empty($upcomingCourse->price) and $upcomingCourse->price > 0) ? handlePrice($upcomingCourse->price) : trans('free') }}</span>
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
                'file_name' => 'student.png',
                'title' => trans('update.no_result_following_course'),
                'hint' =>  trans('update.no_result_following_course_hint') ,
            ])
        @endif

    </section>
@endsection
