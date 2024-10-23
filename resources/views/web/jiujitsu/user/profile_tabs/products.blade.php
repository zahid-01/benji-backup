@if(!empty($user->products) and !$user->products->isEmpty())
    <div class="row">

        @foreach($user->products as $product)
            <div class="col-12 col-md-6 col-lg-4 mt-4">
                @include('web.jiujitsu.products.includes.card')
            </div>
        @endforeach
    </div>
@else
    @include(getTemplate() . '.includes.no-result',[
        'file_name' => 'webinar.png',
        'title' => trans('update.instructor_not_have_products'),
        'hint' => '',
    ])
@endif

