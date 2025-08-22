<section class="card border-0 shadow-sm rounded-3 mb-5" aria-labelledby="comment-form-title">
    <div class="card-body p-4">
        <h3 id="comment-form-title" class="h4 mb-4 text-primary">افزودن نظر جدید</h3>

        <div class="mb-4">
            <label class="form-label d-block fw-medium mb-3">امتیاز شما:</label>
            <div class="d-flex align-items-center gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <button
                        type="button"
                        wire:click="$set('rating', {{ $i }})"
                        class="btn btn-link p-0 border-0 bg-transparent"
                        aria-label="امتیاز {{ $i }} از ۵"
                    >
                        @if($i <= $rating)
                            <i class="ri-star-fill fs-2 text-warning"></i>
                        @else
                            <i class="ri-star-line fs-2 text-muted"></i>
                        @endif
                    </button>
                @endfor
            </div>
            @error('rating')<small class="text-danger d-block mt-2">{{ $message }}</small>@enderror
        </div>

        <div class="mb-4">
            <label for="comment-text" class="form-label fw-medium">متن نظر شما</label>
            <textarea
                wire:model.live="text"
                id="comment-text"
                class="form-control border-2 py-3"
                rows="4"
                placeholder="نظر خود را بنویسید (حداقل ۲۵ کاراکتر)..."
                aria-label="متن نظر"
            ></textarea>
            @error('text')<small class="text-danger mt-2">{{ $message }}</small>@enderror
        </div>

        <div class="d-flex justify-content-end">
            <button
                wire:click="addComment"
                wire:loading.attr="disabled"
                class="btn btn-primary px-4 py-2 fw-medium"
            >
                <span wire:loading.remove>
                    <i class="ri-send-plane-fill me-1"></i> ثبت نظر
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    در حال ارسال...
                </span>
            </button>
        </div>
    </div>
</section>
