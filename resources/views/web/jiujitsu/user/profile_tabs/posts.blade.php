<div class="row py-10">
    @if (!empty($user->blog) and !$user->blog->isEmpty())

        @foreach ($user->blog as $post)
            <div class="col-12 col-md-4">
                <div class="mt-6">
                    @include('web.jiujitsu.blog.grid-list', ['post' => $post])
                </div>
            </div>
        @endforeach
    @else
        @include(getTemplate() . '.includes.no-result', [
            'file_name' => 'webinar.png',
            'title' => trans('update.instructor_not_have_posts'),
            'hint' => '',
        ])
    @endif
</div>
