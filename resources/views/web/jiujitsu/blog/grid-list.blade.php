<div class="blog-grid-card">
    <div class="blog-grid-image">
        <img src="{{ $post->image }}" class="img-cover" alt="{{ $post->title }}">

        <span class="badge created-at flex items-center">
            <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
            <span>{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
        </span>
    </div>

    <div class="blog-grid-detail">
        <a href="{{ $post->getUrl() }}">
            <h3 class="blog-grid-title mt-10">{{ $post->title }}</h3>
        </a>

        <div class="mt-4 blog-grid-desc">{!! truncate(strip_tags($post->description), 160) !!}</div>

        <div class="blog-grid-footer flex items-center justify-between mt-15">
            <span>
                <i data-feather="user" width="20" height="20" class=""></i>
                 @if(!empty($post->author->full_name))
                <span class="ml-2">{{ $post->author->full_name }}</span>
                 @endif
              </span>

            <span class="flex items-center">
                <i data-feather="message-square" width="20" height="20" class=""></i>
                <span class="ml-2">{{ $post->comments_count }}</span>
            </span>
        </div>
    </div>
</div>
