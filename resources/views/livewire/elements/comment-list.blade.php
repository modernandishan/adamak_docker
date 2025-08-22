@if($comments->isEmpty())
    <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body p-4 text-center">
            <i class="ri-chat-3-line ri-2x text-muted mb-3"></i>
            <h3 class="h5 text-muted">هنوز نظری ثبت نشده است</h3>
            <p class="mb-0">اولین نفری باشید که نظر می‌دهد!</p>
        </div>
    </div>
@else
    <section class="mb-5" aria-labelledby="comments-section">
        <div class="d-flex align-items-center gap-3 mb-4">
            <i class="ri-chat-3-line ri-lg text-primary"></i>
            <h2 id="comments-section" class="h4 mb-0">نظرات کاربران</h2>
            <span class="badge bg-primary rounded-pill">{{ $comments->total() }}</span>
        </div>

        <div class="row g-4">
            @foreach($comments as $comment)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 h-100 transition-all-hover hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-lg rounded-circle bg-light text-primary d-flex align-items-center justify-content-center">
                                        @if($comment->user->profile_image)
                                            <img
                                                src="{{ asset($comment->user->profile_image) }}"
                                                class="rounded-circle"
                                                alt="تصویر {{ $comment->user->name }}"
                                                loading="lazy"
                                            >
                                        @else
                                            {{ substr($comment->user->name, 0, 1) }}
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                        <h3 class="h5 mb-0">{{ $comment->user->name }} {{ $comment->user->last_name }}</h3>
                                        <div class="d-flex align-items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $comment->rating)
                                                    <i class="ri-star-fill text-warning"></i>
                                                @else
                                                    <i class="ri-star-line text-muted"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-secondary mb-3" style="text-align: justify; line-height: 1.8;">
                                        {{ $comment->text }}
                                    </p>

                                    <div class="d-flex align-items-center gap-3 text-muted">
                                        <small>
                                            <i class="ri-calendar-line me-1"></i>
                                            <time datetime="{{ $comment->created_at->toIso8601String() }}">
                                                {{ \Morilog\Jalali\Jalalian::fromCarbon($comment->created_at)->format('Y/m/d') }}
                                            </time>
                                        </small>
                                        <small>
                                            <i class="ri-time-line me-1"></i>
                                            {{ $comment->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($comments->hasPages())
            <div class="mt-4">
                {{ $comments->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
@endif
