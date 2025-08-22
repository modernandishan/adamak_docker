@extends('layouts.main')
@section('title', $test->title . ' | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            جزئیات آزمون
                            <strong class="text-warning">
                                {{$test->title}}
                            </strong>
                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">آزمون‌ها</a></li>
                                <li class="breadcrumb-item active">{{ $test->title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <p class="text-success text-uppercase mb-2">
                                    {{ $test->category->title ?? 'بدون دسته‌بندی' }}
                                </p>
                                <h1 class="mb-2">{{ $test->title }}</h1>
                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="ri-time-line align-middle me-1"></i>
                                        {{ $test->required_time }} <!-- استفاده از accessor جدید -->
                                    </span>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="ri-user-line align-middle me-1"></i>
                                        {{ $test->age_range }} <!-- استفاده از accessor جدید -->
                                    </span>
                                    @if($test->is_free) <!-- استفاده از accessor جدید -->
                                    <span class="badge bg-success-subtle text-success">رایگان</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            {{ number_format($test->final_price) }} ریال <!-- استفاده از accessor جدید -->
                                        </span>
                                    @endif
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="ri-question-line align-middle me-1"></i>
                                        {{ $test->active_questions_count }} سوال
                                    </span>
                                </div>
                            </div>


                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            @if($test->image)
                                                <img src="{{ Storage::url($test->image) }}" alt="{{ $test->title }}" class="img-thumbnail rounded">
                                                <br>
                                                <br>
                                            @endif
                                            <h5 class="card-title mb-3">مشخصات آزمون</h5>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>دسته‌بندی:</span>
                                                    <span class="fw-medium">
                                                        {{ $test->category->title ?? '-' }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>مدت زمان:</span>
                                                    <span class="fw-medium">{{ $test->required_time }}</span> <!-- استفاده از accessor جدید -->
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>رده سنی:</span>
                                                    <span class="fw-medium">{{ $test->age_range }}</span> <!-- استفاده از accessor جدید -->
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>تعداد سوالات:</span>
                                                    <span class="fw-medium">{{ $test->active_questions_count }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>نوع آزمون:</span>
                                                    <span class="fw-medium">{{ $test->type ?: 'عمومی' }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>وضعیت:</span>
                                                    <span class="badge bg-{{ $test->status == 'Published' ? 'success' : 'warning' }}-subtle text-{{ $test->status == 'Published' ? 'success' : 'warning' }}">
                                                        {{ $test->status == 'Published' ? 'منتشر شده' : 'پیش‌نویس' }}
                                                    </span>
                                                </li>


                                                @if(($test->price === 0 && $test->sale === null) || ($test->price === 0 && $test->sale === 0))
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت:</span>
                                                        <span class="badge bg-success-subtle text-success }}">
                                                            رایگان
                                                        </span>
                                                    </li>
                                                @elseif($test->price !== 0 && $test->sale === 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت:</span>
                                                        <span class="badge bg-secondary-subtle text-secondary text-decoration-line-through">
                                                            {{$test->price}}
                                                            ریال
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت با تخفیف:</span>
                                                        <span class="badge bg-success-subtle text-success }}">
                                                            رایگان
                                                        </span>
                                                    </li>
                                                @elseif($test->price > 0 && $test->sale > 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت:</span>
                                                        <span class="badge bg-secondary-subtle text-secondary text-decoration-line-through">
                                                            {{$test->price}}
                                                            ﷼
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت با تخفیف:</span>
                                                        <span class="badge bg-success-subtle text-success }}">
                                                            {{$test->sale}}
                                                            ریال
                                                        </span>
                                                    </li>
                                                @elseif($test->price > 0 && $test->sale === null)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>هزینه شرکت:</span>
                                                        <span class="badge bg-secondary-subtle text-secondary">
                                                            {{$test->price}}
                                                            ﷼
                                                        </span>
                                                    </li>
                                                @endif

                                            </ul>

                                            <div class="mt-4 text-center">
                                                @if($user && $user->wallet->balance >= $test->final_price && $test->status == 'Published')
                                                    <a href="{{ route('user.test.start', $test->slug) }}" class="btn btn-primary w-100">
                                                        <i class="ri-shopping-cart-line align-middle me-1"></i>
                                                        شرکت در آزمون
                                                    </a>
                                                @elseif($user && $user->wallet->balance < $test->final_price && $test->status == 'Published')
                                                    <!-- Toggle Between Modals -->
                                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#firstmodal">
                                                        <i class="ri-information-fill align-middle me-1"></i>
                                                        شرکت در آزمون
                                                    </button>
                                                    <!-- First modal dialog -->
                                                    <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <lord-icon
                                                                        src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                        trigger="loop"
                                                                        colors="primary:#f7b84b,secondary:#405189"
                                                                        style="width:130px;height:130px">
                                                                    </lord-icon>
                                                                    <div class="mt-4 pt-4">
                                                                        <h4>موجود ناکافی</h4>
                                                                        <p class="text-muted">
                                                                            کاربر محترم، لطفاً توجه داشته باشید که برای شرکت در این آزمون، موجودی کیف پول شما باید حداقل به اندازه هزینه آزمون باشد. در حال حاضر موجودی کیف پول شما کافی نیست.
                                                                        </p>
                                                                        <!-- Toogle to second dialog -->
                                                                        <button class="btn btn-outline-warning" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                            بازگشت
                                                                        </button>
                                                                        <a href="{{route('user.wallet.charge.form')}}" class="btn btn-warning">
                                                                            افزایش اعتبار کیف پول
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <!-- Toggle Between Modals -->
                                                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#firstmodal">
                                                        <i class="ri-information-fill align-middle me-1"></i>
                                                        شرکت در آزمون (وارد شوید)
                                                    </button>
                                                    <!-- First modal dialog -->
                                                    <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <lord-icon
                                                                        src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                        trigger="loop"
                                                                        colors="primary:#f7b84b,secondary:#405189"
                                                                        style="width:130px;height:130px">
                                                                    </lord-icon>
                                                                    <div class="mt-4 pt-4">
                                                                        <h4>ورود به حساب کاربری</h4>
                                                                        <p class="text-muted">
                                                                            دوست عزیز، ابتدا وارد سامانه جامع
                                                                            <strong>آدمک</strong>
                                                                            شوید سپس اقدام به شرکت در آزمون کنید.
                                                                        </p>
                                                                        <!-- Toogle to second dialog -->
                                                                        <button class="btn btn-outline-dark" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                            بازگشت
                                                                        </button>
                                                                        <a href="{{route('user.login')}}" class="btn btn-dark">
                                                                            ورود | ثبت نام
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">توضیحات آزمون</h5>
                                            <div class="text-muted" style="text-align: justify">
                                                {!! $test->description !!}
                                            </div>

                                            @if($test->admin_note)
                                                <div class="alert alert-info mt-4">
                                                    <h6 class="alert-heading">یادداشت ادمین:</h6>
                                                    <p class="mb-0">{{ $test->admin_note }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card border mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">سوالات متداول</h5>

                                            <div class="accordion accordion-flush" id="faqAccordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="faqHeadingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                                            این آزمون برای چه کسانی مناسب است؟
                                                        </button>
                                                    </h2>
                                                    <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                                                        <div class="accordion-body">
                                                            این آزمون برای افراد {{ $test->age_range }} طراحی شده و برای {{ $test->description_short }} مفید می‌باشد.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="faqHeadingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                                            نتایج آزمون چگونه ارائه می‌شود؟
                                                        </button>
                                                    </h2>
                                                    <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                                                        <div class="accordion-body">
                                                            پس از اتمام آزمون، گزارش کاملی از نقاط قوت و ضعف شما به همراه راهکارهای بهبود ارائه خواهد شد.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="faqHeadingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                                                            آیا امکان مرور سوالات پس از آزمون وجود دارد؟
                                                        </button>
                                                    </h2>
                                                    <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                                                        <div class="accordion-body">
                                                            بله، پس از اتمام آزمون می‌توانید سوالات و پاسخ‌های خود را مرور کنید.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">ساختار آزمون</h5>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>عنوان بخش</th>
                                                        <th>تعداد سوالات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($test->questions->groupBy('catalog') as $catalog => $questions)
                                                        <tr>
                                                            <td>{{ $catalog ?: 'عمومی' }}</td>
                                                            <td>{{ count($questions) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="table-info">
                                                        <td class="fw-semibold">جمع کل</td>
                                                        <td class="fw-semibold">{{ $test->active_questions_count }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-3">
                                                <h6 class="mb-2">انواع سوالات:</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($test->questions->groupBy('type') as $type => $questions)
                                                        <span class="badge bg-info-subtle text-info">
                                                            {{ $questions->first()->type_name }} ({{ count($questions) }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
