<div class="mt-8">
    <h2 class="font-bold">{{ $comments->count() }} {{ trans('panel.comments') }}</h2>

    <div class="mt-4">
        <form action="/comments/store" method="post">

            <input type="hidden" name="_token" value=" {{ csrf_token() }}">
            <input type="hidden" id="commentItemId" name="item_id" value="{{ $inputValue }}">
            <input type="hidden" id="commentItemName" name="item_name" value="{{ $inputName }}">

            <div class="form-group">
                <textarea name="comment"
                    class="input input-bordered w-full border-slate-500 h-28 @error('comment') is-invalid @enderror" rows="10"></textarea>
                <div class="invalid-feedback">
                    @error('comment')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="btn btn-sm btn-primary text-black font-light">{{ trans('product.post_comment') }}</button>
        </form>
    </div>

    @if (!empty(session()->has('msg')))
        <div class="alert alert-success my-25">
            {{ session()->get('msg') }}
        </div>
    @endif

    @if ($comments)
        @foreach ($comments as $comment)
            <div class="mt-8 border border-slate-300 rounded-lg p-4" data-address="/comments/{{ $comment->id }}/reply"
                data-csrf="{{ csrf_token() }}" data-id="{{ $comment->id }}">

                <div class="flex justify-between">
                    <div class="flex">
                        <img src="{{ $comment->user->getAvatar() }}" class="rounded-full w-14 h-14" alt="">
                        <div class="flex flex-col ml-3">
                            <span class="font-medium">{{ $comment->user->full_name }}</span>
                            <span class="text-sm text-slate-500">
                                @if ($comment->user->isUser() or !empty($course) and $course->checkUserHasBought($comment->user))
                                    {{ trans('quiz.student') }}
                                @elseif(
                                    !$comment->user->isUser() and
                                        !empty($course) and
                                        ($course->creator_id == $comment->user->id or $course->teacher_id == $comment->user->id))
                                    {{ trans('panel.teacher') }}
                                @elseif($comment->user->isAdmin())
                                    {{ trans('panel.staff') }}
                                @else
                                    {{ trans('panel.user') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <span
                            class="text-sm text-slate-500">{{ dateTimeFormat($comment->created_at, 'j M Y | H:i') }}</span>

                        <div class="dropdown dropdown-end">
                            <button type="button" class="btn btn-link text-black btn-sm">
                                <i data-feather="more-vertical" height="20"></i>
                            </button>
                            <div class="p-2 shadow menu dropdown-content rounded">
                                <button type="button" class="btn btn-ghost">{{ trans('panel.reply') }}</button>
                                <button type="button" class="btn btn-ghost" data-item-id="{{ $inputValue }}"
                                    data-comment-id="{{ $comment->id }}"
                                    class="">{{ trans('panel.report') }}</button>

                                @if (auth()->check() and auth()->user()->id == $comment->user_id)
                                    <a href="/comments/{{ $comment->id }}/delete"
                                        class="webinar-actions block mt-10 text-hover-primary"
                                        class="btn btn-ghost">{{ trans('public.delete') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-sm mt-8">
                    {!! nl2br(clean($comment->comment)) !!}
                </div>

                @if (!empty($comment->replies) and $comment->replies->count() > 0)
                    @foreach ($comment->replies as $reply)
                        <div class="mt-8 border border-slate-300 rounded-lg p-4">
                            <div class="flex justify-between">
                                <div class="flex">

                                    <img src="{{ $reply->user->getAvatar() }}" class="rounded-full w-14 h-14"
                                        alt="">

                                    <div class="flex flex-col ml-3">
                                        <span class="font-medium">{{ $reply->user->full_name }}</span>
                                        <span class="text-sm text-slate-500">
                                            @if ($reply->user->isUser() or !empty($course) and $course->checkUserHasBought($reply->user))
                                                {{ trans('quiz.student') }}
                                            @elseif(
                                                !$reply->user->isUser() and
                                                    !empty($course) and
                                                    ($course->creator_id == $reply->user->id or $course->teacher_id == $reply->user->id))
                                                {{ trans('panel.teacher') }}
                                            @elseif($reply->user->isAdmin())
                                                {{ trans('panel.staff') }}
                                            @else
                                                {{ trans('panel.user') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <span
                                        class="text-sm text-slate-500">{{ dateTimeFormat($reply->created_at, 'j M Y | H:i') }}</span>

                                    <div class="dropdown dropdown-end">
                                        <button type="button" class="btn btn-link text-black btn-sm">
                                            <i data-feather="more-vertical" height="20"></i>
                                        </button>
                                        <div class="p-2 shadow menu dropdown-content rounded">
                                            <button type="button"
                                                class="btn btn-ghost">{{ trans('panel.reply') }}</button>
                                            <button type="button" data-item-id="{{ $inputValue }}"
                                                data-comment-id="{{ $reply->id }}"
                                                class="btn btn-ghost">{{ trans('panel.report') }}</button>

                                            @if (auth()->check() and auth()->user()->id == $reply->user_id)
                                                <a href="/comments/{{ $reply->id }}/delete"
                                                    class="btn btn-ghost">{{ trans('public.delete') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm mt-8">
                                {!! nl2br(clean($reply->comment)) !!}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    @endif
</div>
