@extends('layouts.main')
@section('title', $post->title . ' | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $post->title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blog') }}">وبلاگ</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blog.category.show', $post->category->slug) }}">
                                    {{ $post->category->title }}
                                    </a></li>
                                <li class="breadcrumb-item active">{{ $post->title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <p class="text-success text-uppercase mb-2">{{ $post->category->title }}</p>
                                <h4 class="mb-2">{{ $post->title }}</h4>
                                <p class="text-muted mb-4">{{ $post->excerpt }}</p>

                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 mb-3">
                                    @if($post->tags && count($post->tags) > 0)
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('blog.tag.show', $tag) }}"
                                               class="badge bg-primary-subtle text-primary">
                                                {{ $tag }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-eye-line me-1 text-muted"></i>
                                        <span class="text-muted">{{ number_format($post->view_count) }} بازدید</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-calendar-event-line me-1 text-muted"></i>
                                        <span class="text-muted">{{ $post->jalali_published_at }}</span>
                                    </div>
                                </div>
                            </div>



                            <div class="row mt-4">
                                <div class="col-lg-3">
                                    <img src="{{ Storage::url($post->thumbnail) }}"
                                         alt="{{ $post->title }}"
                                         class="img-thumbnail rounded w-100 object-fit-cover mb-3">
                                    <h6 class="pb-1">نوشته شده توسط:</h6>
                                    <div class="d-flex gap-2 mb-3">
                                        <div class="flex-shrink-0">
                                            @if($post->author->profile->avatar)
                                                <img src="{{ Storage::url($post->author->profile->avatar) }}"
                                                     alt="{{ $post->author->name }}"
                                                     class="avatar-sm rounded">
                                            @else
                                                <div class="avatar-sm rounded bg-secondary text-white d-flex align-items-center justify-content-center">
                                                    {{ substr($post->author->name, 0, 1) }}{{ substr($post->author->family, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-2">{{ $post->author->role ? $post->author->role->title : 'نویسنده' }}</p>
                                            <h5 class="mb-1">{{ $post->author->name }} {{ $post->author->family }}</h5>
                                            <p class="text-muted mb-0">تاریخ انتشار: {{ $post->jalali_published_at }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-top">
                                        <h6 class="mb-3">پست های مرتبط</h6>
                                        @foreach($relatedPosts as $related)
                                            <a href="{{ route('blog.detail', $related->slug) }}" class="d-block mb-3 text-decoration-none">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2">
                                                        <img src="{{ Storage::url($related->thumbnail) }}"
                                                             alt="{{ $related->title }}"
                                                             class="avatar-md rounded object-fit-cover">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 text-truncate">{{ $related->title }}</h6>
                                                        <small class="text-muted">{{ $related->jalali_published_at }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-9">
                                    <div class="post-content">
                                        {!! $post->renderContentWithGalleries() !!}
                                    </div>

                                    <div class="mt-5 pt-4 border-top">
                                        {{--<h5 class="mb-4">دیدگاه‌ها</h5>
                                        <div class="bg-light p-3 rounded mb-4">
                                            <p class="text-center text-muted mb-0">
                                                سیستم دیدگاه‌ها در حال توسعه است
                                            </p>
                                        </div>--}}
                                        <livewire:elements.add-comment-form
                                            :modelId="$post->id"
                                            modelType="App\Models\Post"
                                            wire:key="add-comment-to-post-{{ $post->id }}"
                                        />
                                        <livewire:elements.comment-list
                                            :modelId="$post->id"
                                            modelType="App\Models\Post"
                                            wire:key="comments-of-post-{{ $post->id }}"
                                        />
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* استایل‌های جدید برای کامپوننت‌های کامنت */
        .transition-all-hover {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
            transform: translateY(-2px);
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background-color: #f0f2f5;
        }

        .avatar-lg {
            width: 56px;
            height: 56px;
            font-size: 1.25rem;
        }

        /* بهبود صفحه‌بندی */
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 4px;
            border: none;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.25);
        }

        /* استایل ستاره‌ها */
        .ri-star-fill, .ri-star-line {
            font-size: 1.25rem;
        }

        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .post-content h1,
        .post-content h2,
        .post-content h3,
        .post-content h4,
        .post-content h5,
        .post-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .post-content p {
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .post-content ul,
        .post-content ol {
            padding-right: 2rem;
            margin-bottom: 1.5rem;
        }

        .post-content li {
            margin-bottom: 0.5rem;
        }

        .post-content blockquote {
            border-right: 4px solid #0d6efd;
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
            margin: 1.5rem 0;
            font-style: italic;
        }

        .post-content .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .post-content .gallery-item {
            text-align: center;
            cursor: pointer;
        }

        .post-content .gallery-item img {
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .post-content .gallery-item img:hover {
            transform: scale(1.05);
        }

        .post-content .gallery-item p {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image modals
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            const modalImg = document.querySelector('#imageModal .modal-body img');
            const modalTitle = document.querySelector('#imageModal .modal-title');

            document.querySelectorAll('.gallery-item img').forEach(img => {
                img.addEventListener('click', function() {
                    modalImg.src = this.src;
                    modalImg.alt = this.alt;
                    modalTitle.textContent = this.dataset.imgTitle || this.alt;
                    imageModal.show();
                });
            });
        });
        document.addEventListener('livewire:initialized', () => {
            // مدیریت اسکرول بعد از افزودن کامنت
            Livewire.on('addCommentSuccessful', () => {
                const commentSection = document.getElementById('comments-section');
                if (commentSection) {
                    setTimeout(() => {
                        commentSection.scrollIntoView({ behavior: 'smooth' });
                    }, 300);
                }
            });

            // مدیریت محدودیت ارسال کامنت
            Livewire.on('totalCommentAllowedLimit', () => {
                Toastify({
                    text: "شما فقط یک بار در روز می‌توانید نظر بدهید",
                    duration: 5000,
                    gravity: "top",
                    position: "left",
                    backgroundColor: "#dc3545",
                    className: "fw-medium"
                }).showToast();
            });
        });
    </script>
@endpush
