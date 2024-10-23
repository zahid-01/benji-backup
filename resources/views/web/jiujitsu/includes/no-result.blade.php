<div class="no-result default-no-result mt-50 flex items-center justify-center flex-col">
    <div class="no-result-logo">
        <img src="/assets/default/img/no-results/{{ $file_name }}" alt="">
    </div>
    <div class="flex items-center flex-col mt-6 text-center">
        <h2 class="text-dark-blue">{{ $title }}</h2>
        <p class="mt-1 text-center text-slate-500 font-medium">{!! $hint !!}</p>
        @if(!empty($btn))
            <a href="{{ $btn['url'] }}" class="btn btn-sm btn-primary mt-25">{{ $btn['text'] }}</a>
        @endif
    </div>
</div>
