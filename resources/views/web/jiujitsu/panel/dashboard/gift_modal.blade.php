<div class="text-left">
    <div class="text-center">
        <img src="/assets/default/img/gift/gift_icon.svg" class="" alt="gift_icon" width="246" height="244">

        <h4 class="font-16 font-bold mt-15">{{ trans("update.you_got_a_gift_{$gift->getItemType()}") }}</h4>
        <p class="text-sm font-medium text-slate-500 mt-5">
            {{ trans('update.user_send_item_to_you_as_a_gift',['user' => $gift->user->full_name, 'item_title' => $gift->getItemTitle()]) }}
        </p>
    </div>

    <div class="flex items-center justify-center mt-15">
        @if(!empty($gift->webinar_id))
            <a href="{{ $gift->webinar->getUrl() }}" class="btn btn-primary btn-sm">{{ trans('update.view_gift') }}</a>
        @elseif(!empty($gift->bundle_id))
            <a href="{{ $gift->bundle->getUrl() }}" class="btn btn-primary btn-sm">{{ trans('update.view_gift') }}</a>
        @elseif(!empty($gift->product_id))
            <a href="{{ $gift->product->getUrl() }}" class="btn btn-primary btn-sm">{{ trans('update.view_gift') }}</a>
        @endif

    </div>
</div>
