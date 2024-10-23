@if(!empty($instructors) and !$instructors->isEmpty())
    <div class="mt-4 row">

        @foreach($instructors as $instructor)
            <div class="col-lg-4 mt-4">
                @include('web.jiujitsu.pages.instructor_card',['instructor' => $instructor])
            </div>
        @endforeach
    </div>
@else
    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'bio.png',
        'title' => trans('update.this_organization_has_no_instructor'),
        'hint' => '',
    ])
@endif

