<div class="hidden" id="blogShareModal">
    <h3 class="section-title after-line font-20 text-dark-blue mb-25">{{ trans('public.share') }}</h3>

    <div class="text-center">
        <i data-feather="share-2" width="50" height="50" class="webinar-icon"></i>

        <p class="mt-4 text-sm">{{ trans('update.share_this_post_with_others') }}</p>

        <div class="relative flex items-center justify-between p-15 mt-15 border border-gray250 rounded-sm mt-5">
            <div class="js-blog-share-link font-bold px-16 text-ellipsis text-sm">{{ url($post->getUrl()) }}</div>

            <button type="button" class="js-blog-share-link-copy btn btn-primary btn-sm text-sm font-medium flex-none" data-toggle="tooltip" data-placement="top" title="{{ trans('public.copy') }}">{{ trans('public.copy') }}</button>
        </div>

        <div class="mt-32 mt-lg-40 row items-center text-sm">
            <a href="{{ $post->getShareLink('telegram') }}" target="_blank" class="col text-center">
                <img src="/assets/default/img/social/telegram.svg" width="50" height="50" alt="telegram">
                <span class="mt-10 block">{{ trans('public.telegram') }}</span>
            </a>

            <a href="{{ $post->getShareLink('whatsapp') }}" target="_blank" class="col text-center">
                <img src="/assets/default/img/social/whatsapp.svg" width="50" height="50" alt="whatsapp">
                <span class="mt-10 block">{{ trans('public.whatsapp') }}</span>
            </a>

            <a href="{{ $post->getShareLink('facebook') }}" target="_blank" class="col text-center">
                <img src="/assets/default/img/social/facebook.svg" width="50" height="50" alt="facebook">
                <span class="mt-10 block">{{ trans('public.facebook') }}</span>
            </a>

            <a href="{{ $post->getShareLink('twitter') }}" target="_blank" class="col text-center">
                <img src="/assets/default/img/social/twitter.svg" width="50" height="50" alt="twitter">
                <span class="mt-10 block">{{ trans('public.twitter') }}</span>
            </a>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end">
        <button type="button" class="btn btn-sm bg-red-600 text-white ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>
