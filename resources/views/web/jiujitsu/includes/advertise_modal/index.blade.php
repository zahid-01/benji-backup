@php
    $advertisingModalSettings = getAdvertisingModalSettings();
@endphp

@if(!empty($advertisingModalSettings))
    <div class="hidden" id="advertisingModalSettings">
        <div class="flex items-center justify-between">
            <h3 class="section-title font-16 text-dark-blue mb-10">{{ $advertisingModalSettings['title'] ?? '' }}</h3>

            <button type="button" class="btn-close-advertising-modal close-swl btn-ghost flex">
                <i data-feather="x" width="25" height="25" class=""></i>
            </button>
        </div>

        <div class="flex items-center justify-center">
            <img src="{{ $advertisingModalSettings['image'] ?? '' }}" class="img-fluid rounded-lg" alt="{{ $advertisingModalSettings['title'] ?? 'ads' }}">
        </div>

        <p class="text-sm text-slate-500 mt-4">{!! $advertisingModalSettings['description'] ?? '' !!}</p>

        <div class="row items-center mt-4">
            @if(!empty($advertisingModalSettings['button1']) and !empty($advertisingModalSettings['button1']['link']) and !empty($advertisingModalSettings['button1']['title']))
                <div class="col-6">
                    <a href="{{ $advertisingModalSettings['button1']['link'] }}" class="btn btn-primary btn-sm btn-block">{{ $advertisingModalSettings['button1']['title'] }}</a>
                </div>
            @endif

            @if(!empty($advertisingModalSettings['button2']) and !empty($advertisingModalSettings['button2']['link']) and !empty($advertisingModalSettings['button2']['title']))
                <div class="col-6">
                    <a href="{{ $advertisingModalSettings['button2']['link'] }}" class="btn btn-outline-primary btn-sm btn-block">{{ $advertisingModalSettings['button2']['title'] }}</a>
                </div>
            @endif
        </div>
    </div>
@endif
