{{-- <div class="mt-8">
    <div class="grid grid-cols-12 items-center">
        <div class="col-span-3 text-center">
            <div class="reviews-rate text-4xl font-bold text-primary">{{ $course->getRate() }}</div>

            <div class="text-center">
                @include(getTemplate() . '.includes.webinar.rate',[
                    'rate' => round($course->getRate(),1),
                    'dontShowRate' => true,
                    'className' => 'justify-center mt-0'
                ])
                <div class="mt-4">{{ $course->reviews->pluck('creator_id')->count() }}  {{ trans('product.reviews') }}</div>
            </div>
        </div>

        <div class="col-span-9">
            <div class="flex items-center justify-between py-2">
                <div class="progress course-progress rounded-lg w-[80%]">
                    <span class="progress-bar rounded-lg bg-yellow-400 h-full block" style="width: {{ $course->reviews->avg('content_quality') / 5 * 100 }}%"></span>
                </div>
                <span class="ml-15 text-sm text-slate-500 text-left">{{ trans('product.content_quality') }} ({{ $course->reviews->count() > 0 ? round($course->reviews->avg('content_quality'), 1) : 0 }})</span>
            </div>

            <div class="mt-25 flex items-center justify-between py-2">
                <div class="progress course-progress rounded-lg w-[80%]">
                    <span class="progress-bar rounded-lg bg-yellow-400 h-full block" style="width: {{ $course->reviews->avg('instructor_skills') / 5 * 100 }}%"></span>
                </div>
                <span class="ml-15 text-sm text-slate-500 text-left">{{ trans('product.instructor_skills') }} ({{ $course->reviews->count() > 0 ? round($course->reviews->avg('instructor_skills'), 1) : 0 }})</span>
            </div>

            <div class="mt-25 flex items-center justify-between py-2">
                <div class="progress course-progress rounded-lg w-[80%]">
                    <span class="progress-bar rounded-lg bg-yellow-400 h-full block" style="width: {{ $course->reviews->avg('purchase_worth') / 5 * 100 }}%"></span>
                </div>
                <span class="ml-15 text-sm text-slate-500 text-left">{{ trans('product.purchase_worth') }} ({{ $course->reviews->count() > 0 ? round($course->reviews->avg('purchase_worth'), 1) : 0 }})</span>
            </div>

            <div class="mt-25 flex items-center justify-between py-2">
                <div class="progress course-progress rounded-lg w-[80%]">
                    <span class="progress-bar rounded-lg bg-yellow-400 h-full block" style="width: {{ $course->reviews->avg('support_quality') / 5 * 100 }}%"></span>
                </div>
                <span class="ml-15 text-sm text-slate-500 text-left">{{ trans('product.support_quality') }} ({{ $course->reviews->count() > 0 ? round($course->reviews->avg('support_quality'), 1) : 0 }})</span>
            </div>

        </div>
    </div>
</div> --}}

<section class="mt-14">
    {{-- <h2 class="divider">{{ trans('product.reviews') }} ({{ $course->reviews->pluck('creator_id')->count() }})</h2> --}}

    {{-- <form action="/reviews/store" class="mt-6" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="webinar_id" value="{{ $course->id }}"/>
        
        <div class="form-group">
            <textarea name="description" class="textarea textarea-bordered w-full h-40" rows="10"></textarea>
        </div>

        <div class="flex items-center justify-between">

            <div class="col-6 col-md-3 flex flex-col items-center justify-center barrating-stars">
                <span class="text-sm text-slate-500">{{ trans('product.content_quality') }}</span>
                <select name="content_quality" data-rate="1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="col-6 col-md-3 flex flex-col items-center justify-center barrating-stars">
                <span class="text-sm text-slate-500">{{ trans('product.instructor_skills') }}</span>
                <select name="instructor_skills" data-rate="1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="col-6 col-md-3 flex flex-col items-center justify-center barrating-stars">
                <span class="text-sm text-slate-500">{{ trans('product.purchase_worth') }}</span>
                <select name="purchase_worth" data-rate="1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="col-6 col-md-3 flex flex-col items-center justify-center barrating-stars">
                <span class="text-sm text-slate-500">{{ trans('product.support_quality') }}</span>
                <select name="support_quality" data-rate="1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-sm btn-primary mt-4">{{ trans('product.post_review') }}</button>
        </div>
    </form> --}}

    <div class="mt-10">
        @if($course->reviews->count() > 0)
            @foreach($course->reviews as $review)

                <div class="comments-card shadow-lg rounded-lg border border-slate-400 p-4" data-address="/reviews/store-reply-comment" data-csrf="{{ csrf_token() }}" data-id="{{ $review->id }}">
                    <div class="flex items-center justify-between">
                        <div class="user-inline-avatar flex items-center">
                            <div class="avatar bg-gray200 w-14 h-14 rounded-full">
                                <img src="{{ $review->creator->getAvatar() }}" class="w-full he-full rounded-full" alt="">
                            </div>
                            <div class="flex flex-col ml-2">
                                <span class="font-medium text-black">{{ $review->creator->full_name }}</span>

                                @include(getTemplate() . '.includes.webinar.rate',[
                                        'rate' => $review->rates,
                                        'dontShowRate' => true,
                                        'className' => 'justify-content-start mt-0'
                                    ])
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm text-slate-500 mr-10">{{ dateTimeFormat($review->created_at, 'j M Y | H:i') }}</span>

                            <div class="dropdown dropdown-end">
                                <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" height="20"></i>
                                </button>
                                <div class="dropdown-content z-[1] menu p-2 shadow-xl bg-base-100 w-24">
                                    <a href="/reviews/store-reply-comment" class="webinar-actions block text-hover-primary reply-comment">{{ trans('panel.reply') }}</a>

                                    @if(!empty($user) and $user->id == $review->creator_id)
                                        <a href="/reviews/{{ $review->id }}/delete" class="webinar-actions block mt-10 text-hover-primary">{{ trans('public.delete') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-slate-500 text-sm">
                        {!! clean($review->description,'description') !!}
                    </div>

                    @if($review->comments->count() > 0)
                        @foreach($review->comments as $comment)
                            <div class="shadow-lg rounded-lg border px-20 py-15 mt-6">
                                <div class="flex items-center justify-between">
                                    <div class="user-inline-avatar flex items-center mt-10">
                                        <div class="avatar bg-gray200">
                                            <img src="{{ $comment->user->getAvatar() }}" class="img-cover" alt="{{ $comment->user->full_name }}">
                                        </div>
                                        <div class="flex flex-col ml-2">
                                            <span class="font-medium text-black">{{ $comment->user->full_name }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <span class="text-sm text-slate-500 mr-10">{{ dateTimeFormat($comment->created_at, 'j M Y | H:i') }}</span>

                                        <div class="btn-group dropdown table-actions">
                                            <button type="button" class="btn-ghost dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="more-vertical" height="20"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="" class="webinar-actions block text-hover-primary reply-comment">{{ trans('panel.reply') }}</a>
                                                <a href="/comments/{{ $comment->id }}/delete" class="webinar-actions block mt-10 text-hover-primary">{{ trans('public.delete') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-slate-500">
                                    {!! clean($comment->comment,'comment') !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</section>
