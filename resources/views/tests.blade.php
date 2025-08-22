@extends('layouts.main')
@section('title', 'آزمون‌ها | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-sm-0">آزمون‌ها</h1>
                        <div class="page-title-right">
                            @if(request()->routeIs('tests.category.show'))
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('tests.index')}}">آزمون‌ها</a></li>
                                    <li class="breadcrumb-item active">
                                        <span class="text-success">دسته‌بندی: {{$category->title}}</span>
                                    </li>
                                </ol>
                            @elseif(request()->routeIs('tests.archive'))
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('tests.index')}}">آزمون‌ها</a></li>
                                    <li class="breadcrumb-item active">
                <span class="text-success">
                    آرشیو: {{$month}} - {{$year}}
                </span>
                                    </li>
                                </ol>
                            @elseif(request()->filled('search'))
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('tests.index')}}">آزمون‌ها</a></li>
                                    <li class="breadcrumb-item active">
                                        <span class="text-success">جستجو: {{request()->query('search')}}</span>
                                    </li>
                                </ol>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- سایدبار -->
                <div class="col-xxl-3">
                    <div class="card">
                        <div class="card-body p-4">
                            <!-- آزمون‌های محبوب -->
                            <div>
                                <h3 class="text-warning mb-2">آزمون‌های محبوب</h3>
                                @foreach($popular_tests as $test)
                                    <div class="list-group list-group-flush">
                                        <a href="{{route('test.detail', $test->slug)}}" class="list-group-item text-muted py-3 px-2">
                                            <div class="d-flex align-items-center">
                                                @if($test->image)
                                                    <div class="flex-shrink-0 me-3">
                                                        <img src="{{Storage::url($test->image)}}" alt="{{$test->title}}"
                                                             class="avatar-md h-auto d-block rounded">
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="fs-15 text-truncate">{{$test->title}}</h4>
                                                    <p class="mb-0">
                                                        <span class="badge bg-soft-success">
                                                            {{ $test->attempts_count }} شرکت‌کننده
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <!-- دسته‌بندی‌ها -->
                            <div class="mt-4 pt-4 border-top">
                                <h3 class="text-warning">دسته‌بندی‌ها</h3>
                                @if($test_categories->count() > 0)
                                    <ul class="list-unstyled fw-medium">
                                        @foreach($test_categories as $category)
                                            <li>
                                                <a href="{{ route('tests.category.show', $category->slug) }}"
                                                   class="text-muted py-2 d-block {{ request()->is('tests/category/'.$category->slug) ? 'text-warning fw-bold' : '' }}">
                                                    {{$category->title}}
                                                    <span class="badge bg-soft-primary rounded-pill float-end ms-1">
                {{$category->tests_count}}
            </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">هیچ دسته‌بندی ایجاد نشده است</p>
                                @endif
                            </div>

                            <!-- آرشیو -->
                            {{-- در بخش آرشیو --}}
                            <div class="mt-4 pt-4 border-top">
                                <h4 class="text-warning">آرشیو آزمون‌ها</h4>
                                <ul class="list-unstyled fw-medium">
                                    @foreach($archives as $year_jalali => $months)
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="text-muted py-2 d-block archive-year"
                                               data-year="{{ $year_jalali }}">
                                                <i class="mdi mdi-chevron-right me-1"></i>
                                                {{ $year_jalali }}
                                                <span class="badge badge-soft-success rounded-pill float-end ms-1 font-size-12">
                        {{ $months->sum('test_count') }}
                    </span>
                                            </a>
                                            <ul class="list-unstyled archive-months ms-3" id="months-{{ $year_jalali }}" style="display: none;">
                                                @foreach($months as $month)
                                                    <li>
                                                        <a href="{{ route('tests.archive', [
                                'year' => $year_jalali,
                                'month' => $month['month_jalali']
                            ]) }}"
                                                           class="text-muted py-2 d-block {{ isset($currentMonth) && $currentMonth == $month['month_jalali'] ? 'text-warning fw-bold' : '' }}">
                                                            {{ $month['month_name'] }}
                                                            <span class="badge badge-soft-info rounded-pill float-end ms-1 font-size-12">
                                    {{ $month['test_count'] }}
                                </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- محتوای اصلی -->
                <div class="col-xxl-9">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                @role('super_admin')
                                <a href="{{ url('/admin/tests/create') }}" class="btn btn-success">
                                    <i class="ri-add-line align-bottom me-1"></i> افزودن آزمون جدید
                                </a>
                                @endrole
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end gap-2">
                                <div class="search-box ms-2">
                                    <form action="{{ route('tests.index') }}" method="GET">
                                        <input type="search"
                                               name="search"
                                               class="form-control"
                                               placeholder="جستجوی آزمون..."
                                               value="{{ request('search') }}">
                                        <i class="ri-search-line search-icon"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($tests->count() > 0)
                        <div class="row">
                            @foreach($tests as $test)
                                <div class="col-xxl-4 col-lg-6">
                                    <div class="card overflow-hidden blog-grid-card">
                                        <div class="position-relative overflow-hidden">
                                            @if($test->image)
                                                <img src="{{ Storage::url($test->image) }}" alt="{{ $test->title }}" class="blog-img object-fit-cover">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <i class="ri-test-tube-line fs-1 text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="badge bg-soft-primary">
                                                    {{ $test->category->title ?? 'بدون دسته‌بندی' }}
                                                </span>
                                                <div>
                                                    <span class="text-muted">
                                                        <i class="ri-time-line align-bottom"></i>
                                                        {{ $test->required_time }}
                                                    </span>
                                                    <span class="badge bg-soft-info ms-2">
                                                        <i class="ri-user-line align-bottom"></i>
                                                        {{ $test->attempts_count }}
                                                    </span>
                                                </div>
                                            </div>

                                            <h5 class="card-title">
                                                <a href="{{ route('test.detail', $test->slug) }}" class="text-reset">
                                                    {{ $test->title }}
                                                </a>
                                            </h5>

                                            <p class="text-muted mb-2">
                                                {!! \Illuminate\Support\Str::limit($test->description, 100)  !!}
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                @if($test->isFree)
                                                    <span class="badge bg-soft-success fs-6">رایگان</span>
                                                @else
                                                    <div>
                                                        @if($test->sale > 0)
                                                            <span class="text-decoration-line-through text-muted me-2">
                                                                {{ number_format($test->price) }} تومان
                                                            </span>
                                                        @endif
                                                        <span class="badge bg-soft-danger fs-6">
                                                            {{ number_format($test->final_price) }} تومان
                                                        </span>
                                                    </div>
                                                @endif

                                                <a href="{{ route('test.detail', $test->slug) }}" class="btn btn-primary btn-sm">
                                                    مشاهده آزمون
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $tests->links() }}
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <strong>هیچ آزمونی یافت نشد!</strong>
                            @if(request()->filled('search'))
                                <p>برای جستجوی «{{ request('search') }}» نتیجه‌ای پیدا نشد</p>
                            @endif
                            <a class="btn btn-warning" href="{{ route('tests.index') }}">نمایش همه آزمون‌ها</a>
                        </div>
                    @endif
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
        .object-fit-cover {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }
    </style>
@endpush
