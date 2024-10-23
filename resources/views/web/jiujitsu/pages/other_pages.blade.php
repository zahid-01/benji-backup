@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="cart-banner relative text-center">
        <div class="container h-100">
            <div class="row h-100 items-center justify-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <h1 class="text-3xl text-white font-bold">{{ $page->title }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-10 mt-md-40">
        <div class="row">
            <div class="col-12">
                <div class="post-show mt-6">
                    {!! nl2br($page->content) !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
