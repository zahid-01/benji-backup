@if(!empty($webinars) and !$webinars->isEmpty())
    <div class="grid grid-cols-1 gap-4 mt-4 filter-tabs">

        @foreach($webinars as $webinar)
            <div class="col-lg-4 mt-4">
                @include('web.jiujitsu.includes.webinar.list-card',['webinar' => $webinar])
            </div>
        @endforeach
    </div>
@else
    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'webinar.png',
        'title' => trans('site.instructor_not_have_webinar'),
        'hint' => '',
    ])
@endif

