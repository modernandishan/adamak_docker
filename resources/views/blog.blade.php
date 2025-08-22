@extends('layouts.main')
@section('title','وبلاگ | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-sm-0">وبلاگ</h1>
                        <div class="page-title-right">
                            <p>
                                {{number_format($all_views)}}
                                <i class="mdi mdi-eye"></i>
                            </p>
                            @if(request()->routeIs('blog.tag.show'))
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{route('blog')}}">وبلاگ</a></li>
                                        <li class="breadcrumb-item active">
                                            <span class="text-success">برچسب: {{request()->route('tag')}}</span>
                                        </li>
                                    </ol>
                                </div>
                            @elseif(request()->routeIs('blog.archive'))
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{route('blog')}}">وبلاگ</a></li>
                                        <li class="breadcrumb-item active">
                                            <span class="text-success">
                                                آرشیو: {{request()->route('month') . ' - ' . request()->route('year')}}
                                            </span>
                                        </li>
                                    </ol>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3">
                    <div class="card">
                        <div class="card-body p-4">
                            <div>
                                <h3 class="text-warning mb-2">پست های محبوب</h3>
                                @foreach($most_viewed_posts as $most_viewed_post)
                                    <div class="list-group list-group-flush">
                                        <a href="{{route('blog.detail',$most_viewed_post->slug)}}" class="list-group-item text-muted py-3 px-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="{{Storage::url($most_viewed_post->thumbnail)}}" alt="{{$most_viewed_post->title}}"
                                                         class="avatar-md h-auto d-block rounded">
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="fs-15 text-truncate">{{$most_viewed_post->title}}</h4>
                                                    <p class="mb-0 text-truncate">{{$most_viewed_post->jalali_published_at}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-4 border-top border-dashed border-bottom-0 border-start-0 border-end-0">
                                <h3 class="text-warning">دسته بندی ها</h3>
                                @if($post_categories->count() > 0)
                                    <ul class="list-unstyled fw-medium">
                                        @foreach($post_categories as $post_category)
                                            <li>
                                                <a href="{{route('blog.category.show',$post_category->slug)}}"
                                                   class="text-muted py-2 d-block">
                                                    {{$post_category->title}}
                                                    <i class="mdi mdi-chevron-left me-1"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>هنوز دسته بندی ای از محتوا در سامانه آدمک ایجاد نشده است!</p>
                                    @role('super_admin')
                                    <a class="link link-secondary" href="{{url('/admin/post-categories/create')}}">ایجاد دسته بندی پست ها</a>
                                    @endrole
                                @endif
                            </div>

                            <div class="mt-4 pt-4 border-top border-dashed border-bottom-0 border-start-0 border-end-0">
                                <h4 class="text-warning">آرشیو</h4>
                                <ul class="list-unstyled fw-medium">
                                    @foreach($archives as $year_jalali => $months)
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="text-muted py-2 d-block archive-year"
                                               data-year="{{ $year_jalali }}">
                                                <i class="mdi mdi-chevron-right me-1"></i>
                                                {{ $year_jalali }}
                                                <span class="badge badge-soft-success rounded-pill float-end ms-1 font-size-12">
                                                    {{ $months->sum('post_count') }}
                                                </span>
                                            </a>
                                            <ul class="list-unstyled archive-months ms-3" id="months-{{ $year_jalali }}" style="display: none;">

                                                @foreach($months as $month)
                                                    <li>
                                                        <a href="{{ route('blog.archive', [
                                                            'year' => $year_jalali,
                                                            'month' => $month['month_jalali']
                                                        ]) }}"
                                                           class="text-muted py-2 d-block">
                                                            {{ $month['month_name'] }}
                                                            <span class="badge badge-soft-info rounded-pill float-end ms-1 font-size-12">
                                                                {{ $month['post_count'] }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-4 pt-4 border-top border-dashed border-bottom-0 border-start-0 border-end-0">
                                <p class="text-muted">برچسب ها</p>
                                <div class="d-flex flex-wrap gap-2 widget-tag">
                                    @foreach($allTags as $postTag)
                                        <a href="{{ route('blog.tag.show', $postTag) }}"
                                           class="badge bg-light text-muted font-size-12 {{ request()->is('blog/tag/'.$postTag) ? 'bg-success text-white' : '' }}">
                                            {{ $postTag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                @role('super_admin')
                                <a href="{{url('/admin/posts/create')}}" class="btn btn-success"><i
                                        class="ri-add-line align-bottom me-1"></i>افزودن پست جدید</a>
                                @endrole
                            </div>
                        </div>
                        <div class="d-flex justify-content-sm-end gap-2">
                            <div class="search-box ms-2">
                                <form action="{{ route('blog') }}" method="GET">
                                    <input type="search" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
                                    <i class="ri-search-line search-icon"></i>
                                </form>
                            </div>
                        </div>
                    </div><!--end row-->
                    <div class="row gx-4">
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                                <div class="col-xxl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row g-4">
                                                <div class="col-xxl-3 col-lg-5">
                                                    <a href="{{route('blog.detail',$post->slug)}}">
                                                        <img src="{{Storage::url($post->thumbnail)}}" alt="{{$post->title}}"
                                                             class="img-fluid rounded w-100 object-fit-cover">
                                                    </a>
                                                </div><!--end col-->
                                                <div class="col-xxl-9 col-lg-7">
                                                    <a href="{{route('blog.category.show',$post->category->slug)}}" class="mb-2 text-primary text-uppercase">
                                                        {{$post->category->title}}
                                                    </a>
                                                    <a href="{{route('blog.detail',$post->slug)}}">
                                                        <h3 class="fs-15 fw-semibold">
                                                            {{$post->title}}
                                                        </h3>
                                                    </a>
                                                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                                        <span class="text-muted"><i class="ri-calendar-event-line me-1"></i>{{$post->jalali_published_at}}</span>|
                                                        <span class="text-muted"><i class="ri-eye-line me-1"></i>{{number_format($post->view_count)}}</span>|
                                                        <span class="text-muted"><i class="ri-user-3-line me-1"></i>{{$post->author->name . ' ' . $post->author->family}}</span>
                                                    </div>
                                                    <p class="text-muted mb-2">
                                                        {{$post->excerpt}}
                                                    </p>
                                                    <a href="{{route('blog.detail',$post->slug)}}" class="link link-secondary">
                                                        بیشتر مطالعه کنیم
                                                        <i class="ri-arrow-left-line"></i>
                                                    </a>
                                                    <div class="d-flex align-items-center gap-2 mt-3 flex-wrap">
                                                        @foreach($post->tags as $tag)
                                                            <a href="{{route('blog.tag.show',$tag)}}" class="badge text-success bg-success-subtle">
                                                                {{$tag}}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <strong>هیچ پستی یافت نشد!</strong> لطفا جستجو کنید یا به دسته بندی های دیگر مراجعه کنید.
                                    <a class="btn btn-warning" href="{{route('blog')}}">بازگشت به وبلاگ</a>
                                </div>
                            </div>

                        @endif

                    </div><!--end row-->
                    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
                        {{$posts->links()}}
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.archive-year').forEach(item => {
            item.addEventListener('click', function() {
                const year = this.getAttribute('data-year');
                const monthsList = document.getElementById(`months-${year}`);

                if (monthsList.style.display === 'none') {
                    monthsList.style.display = 'block';
                    this.querySelector('i').classList.add('mdi-chevron-down');
                    this.querySelector('i').classList.remove('mdi-chevron-right');
                } else {
                    monthsList.style.display = 'none';
                    this.querySelector('i').classList.add('mdi-chevron-right');
                    this.querySelector('i').classList.remove('mdi-chevron-down');
                }
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        .archive-months {
            transition: all 0.3s ease;
        }
        .archive-year {
            cursor: pointer;
        }
        .archive-year:hover {
            color: #ffc107 !important;
        }
    </style>
@endpush
