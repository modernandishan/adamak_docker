<div class="p-3">
    <h6 class="text-muted mb-3 text-uppercase fw-bold fs-13">آخرین نظرات کاربران آدمک</h6>
    <!-- Swiper -->
    <div class="swiper vertical-swiper" style="height: 250px;">
        <div class="swiper-wrapper">
            @foreach($comments as $comment)
                <div class="swiper-slide">
                    <div class="card border border-dashed shadow-none">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    @if($comment->user->profile->avatar)
                                        <img src="{{ '/storage/'.$comment->user->profile->avatar }}" alt="{{ $comment->user->name }}" class="avatar-sm rounded">
                                    @else
                                        <div class="avatar-sm rounded bg-light d-flex align-items-center justify-content-center">
                                            <i class="ri-user-line fs-18"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div>
                                        <p class="text-muted mb-1 fst-italic text-truncate-two-lines">"{{ $comment->text }}"</p>
                                        <div class="fs-11 align-middle text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $comment->rating)
                                                    <i class="ri-star-fill"></i>
                                                @else
                                                    <i class="ri-star-line"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="text-end mb-0 text-muted">
                                        - توسط <cite title="Source Title">{{ $comment->user->name }}</cite>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
