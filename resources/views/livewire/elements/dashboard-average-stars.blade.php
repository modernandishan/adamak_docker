<div class="p-3">
    <h6 class="text-muted mb-3 text-uppercase fw-bold fs-13">میانگین امتیاز های شما</h6>

    <div class="bg-light px-3 py-2 rounded-2 mb-2">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="fs-16 align-middle text-warning">
                    @php
                        $fullStars = floor($averageRating);
                        $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                    @endphp

                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="ri-star-fill"></i>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <i class="ri-star-half-fill"></i>
                        @else
                            <i class="ri-star-line"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <div class="flex-shrink-0">
                <h6 class="mb-0">{{ number_format($averageRating, 1) }} از 5</h6>
            </div>
        </div>
    </div>

    <div class="text-center">
        <div class="text-muted">مجموع <span class="fw-semibold">{{ number_format($totalReviews) }}</span> بررسی</div>
    </div>

    <div class="mt-3">
        @foreach($ratingDistribution as $rating => $count)
            @php
                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;

                // تعیین رنگ بر اساس امتیاز
                $progressBarColor = 'bg-success';
                if ($rating <= 2) {
                    $progressBarColor = 'bg-danger';
                } elseif ($rating == 3) {
                    $progressBarColor = 'bg-warning';
                }
            @endphp

            <div class="row align-items-center g-2">
                <div class="col-auto">
                    <div class="p-1">
                        <h6 class="mb-0">{{ $rating }} ستاره</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="p-1">
                        <div class="progress animated-progress progress-sm">
                            <div class="progress-bar {{ $progressBarColor }}" role="progressbar"
                                 style="width: {{ $percentage }}%"
                                 aria-valuenow="{{ $percentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="p-1">
                        <h6 class="mb-0 text-muted">{{ $count }}</h6>
                    </div>
                </div>
            </div>
            <!-- end row -->
        @endforeach
    </div>
</div>
