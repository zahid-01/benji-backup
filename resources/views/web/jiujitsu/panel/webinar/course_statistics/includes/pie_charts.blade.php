<div class="col-12 col-md-3 mt-4">
    <div class="course-statistic-cards-shadow pt-15 px-15 pb-25 rounded-sm bg-white">
        <span class="block font-16 font-bold text-black">{{ $cardTitle }}</span>
        <div class="mt-25 statistic-pie-charts">
            <canvas id="{{ $cardId }}" height="197"></canvas>
        </div>

        <div class="mt-25">
            <div class="flex items-center">
                <span class="cart-label-color rounded-full bg-primary mr-5"></span>
                <span class="text-sm font-medium text-slate-500">{{ $cardPrimaryLabel }}</span>
            </div>
            <div class="flex items-center">
                <span class="cart-label-color rounded-full bg-secondary mr-5"></span>
                <span class="text-sm font-medium text-slate-500">{{ $cardSecondaryLabel }}</span>
            </div>
            <div class="flex items-center">
                <span class="cart-label-color rounded-full bg-warning mr-5"></span>
                <span class="text-sm font-medium text-slate-500">{{ $cardWarningLabel }}</span>
            </div>
        </div>
    </div>
</div>
