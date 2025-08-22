@extends('layouts.main')
@section('title','صفحه نخست | آدمک')
@push('styles')
    <link href="{{asset('assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/job-lading.init.js')}}"></script>
@endpush
@section('content')
    <div class="layout-wrapper landing">

        <!-- start hero section -->
        <section class="section job-hero-section bg-light pb-0" id="hero">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6">
                        <div>
                            <h1 class="display-6 fw-bold text-capitalize mb-3 lh-base">
                                آدمک؛ تکنولوژی جدید برای شناخت بهتر کودکانمان
                            </h1>
                            <p style="text-align: justify" class="lead text-muted lh-base mb-4">
                                آدمک، یک سامانه جامع پیشرفته مبتنی بر هوش مصنوعی و متخصصان مشاور است، که با تحلیل آزمون های روان شناسی (با استاندارد های جهانی)
                                در شناخت بهتر کودکان و نوجوانان به والدین و مربیان کمک می کند.
                            </p>

                            @livewire('elements.home-tests-category-list')
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-4">
                        <div class="position-relative home-img text-center mt-5 mt-lg-0">
                            <div class="card p-3 rounded shadow-lg inquiry-box">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0 me-3">
                                        <div class="avatar-title bg-danger-subtle text-danger rounded fs-18">
                                            <i class="ri-mail-send-line"></i>
                                        </div>
                                    </div>
                                    <h5 class="fs-15 lh-base mb-0">تحلیل روان شناختی نقاشی کودک شما</h5>
                                </div>
                            </div>

                            @livewire('elements.home-consultants-list')

                            <img src="../../assets/images/job-profile2.png" alt="" class="user-img">

                            <div class="circle-effect">
                                <div class="circle"></div>
                                <div class="circle2"></div>
                                <div class="circle3"></div>
                                <div class="circle4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end hero section -->

        <section class="section" id="process">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="mb-3 ff-secondary fw-bold lh-base">
                                چطور و از کجا باید شروع کنم و از امکانات
                                <span class="text-primary">
                                    آدمک
                                </span>
                                ،
                                بهرمند شوم؟
                            </h2>
                            <p class="text-muted">
                                کار با سامانه آدمک بسیار ساده هست؛ کافی است مراحل زیر را طی کنید و هر کجا سوالی داشتید با
                                <a href="https://t.me/adamak_ai" target="_blank" class="text-decoration-underline text-primary">پشتیبانی آدمک</a>
                                در ارتباط باشید.
                            </p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!--end row-->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-lg border">
                            <div class="card-body p-4">
                                <h4 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                    <div class="job-icon-effect"></div>
                                    <span>1</span>
                                </h4>
                                <h6 class="fs-17 mb-2">ایجاد حساب کاربری</h6>
                                <a class="btn btn-soft-success w-100" href="{{route('user.register')}}">صفحه ثبت نام / ورود</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none border">
                            <div class="card-body p-4">
                                <h4 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                    <div class="job-icon-effect"></div>
                                    <span>2</span>
                                </h4>
                                <h6 class="fs-17 mb-2">تکمیل نمایه (پروفایل)</h6>
                                <p style="text-align: justify" class="text-muted mb-0 fs-15">
                                    نمایه خود را با اطلاعات دقیق و به روز تکمیل کنید تا بتوانید از امکانات سامانه به بهترین شکل استفاده کنید.
                                </p>
                                <a href="{{route('user.profile.edit')}}" class="btn btn-soft-info w-100">ویرایش نمایه</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none border">
                            <div class="card-body p-4">
                                <h4 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                    <div class="job-icon-effect"></div>
                                    <span>3</span>
                                </h4>
                                <h6 class="fs-17 mb-2">معرفی و ساختار خانواده</h6>
                                <p style="text-align: justify" class="text-muted mb-0 fs-15">
                                    برای افزایش دقت در تحلیل های کارشناسان و یا هوش مصنوعی آدمک، خانواده خود را تعریف کنید.
                                </p>
                                <a href="{{route('user.family.show')}}" class="btn btn-soft-warning w-100">مدیریت خانواده</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none border">
                            <div class="card-body p-4">
                                <h4 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                    <div class="job-icon-effect"></div>
                                    <span>4</span>
                                </h4>
                                <h6 class="fs-17 mb-2">شرکت در آزمون های آدمک</h6>
                                <p style="text-align: justify" class="text-muted mb-0 fs-15">
                                    شرکت در آزمون های مرتبط با فرزندتان، به شما کمک می کند تا شناخت بهتری از شخصیت و نیازهای او پیدا کنید.
                                </p>
                                <a href="{{route('tests.index')}}" class="btn btn-primary w-100">مشاهده آزمون ها</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end container-->
        </section>

        <!-- start features -->
        <section class="section">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-center gy-4">
                    <div class="col-lg-5 col-sm-7">
                        <div class="about-img-section mb-5 mb-lg-0 text-center">
                            <div class="card rounded shadow-lg inquiry-box d-none d-lg-block">
                                <div class="card-body d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0 me-3">
                                        <div class="avatar-title bg-info-subtle text-info rounded-circle fs-18">
                                            <i class="ri-briefcase-2-line"></i>
                                        </div>
                                    </div>
                                    <h5 class="fs-15 lh-base mb-0">جستجو در<span class="text-secondary fw-bold">1,00,000+</span>مشاغل</h5>
                                </div>
                            </div>

                            <div class="card feedback-box">
                                <div class="card-body d-flex shadow-lg">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="../../assets/images/users/avatar-10.jpg" alt="" class="avatar-sm rounded-circle">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-14 lh-base mb-0">تونیا نوبل</h5>
                                        <p class="text-muted fs-11 mb-1">طراح UI/UX</p>

                                        <div class="text-warning">
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img src="../../assets/images/about.png" alt="" class="img-fluid mx-auto rounded-3">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-muted">
                            <h2 class="mb-3 fw-bold lh-base">
                                چرا
                                <span class="text-primary">آدمک</span>؟
                            </h2>
                            <p class="ff-secondary fs-16 mb-2">
                                امروزه خانواده ها برای شناخت فرزندانشان، راه های مختلفی را امتحان می کنند. اما سامانه جامع آدمک،
                                با استاندارد های بین المللی، آزمون های بسیار ساده ای را از کودک شما دریافت میکند،
                                و گزارش دقیقی از روان شناسی کودک شما را ارائه میکنند.
                            </p>
                            <p class="ff-secondary fs-16">
                                علاوه بر این، آدمک با استفاده از هوش مصنوعی و مشاوران متخصص، میتواند راهکار و دستور العمل برای برطرف کردن اختلالات رفتاری و... برای کودک شما ارائه کند.
                            </p>

                            <div class="vstack gap-2 mb-4 pb-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">محتوای پویا</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">امکان ارتباط زنده با مشاوران</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">برنامه مدوم برای کودک شما (متناسب با ویژگی ها و سن)</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <a href="{{route('tests.index')}}" class="btn btn-secondary">
                                    شرکت در آزمون
                                    <i class="ri-arrow-left-line align-bottom ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end features -->

        <!-- start services -->
        <section class="section bg-light" id="categories">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 ff-secondary fw-bold text-capitalize lh-base">مشاغل پر تقاضا<span class="text-primary">دسته بندی ها</span>شکسته</h1>
                            <p class="text-muted">یک شغل ارسال کنید تا در مورد پروژه خود به ما بگویید. ما به سرعت شما را با فریلنسرهای مناسب هماهنگ خواهیم کرد.</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-pencil-ruler-2-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">فناوری اطلاعات و نرم افزار</h5>
                                </a>
                                <p class="mb-0 text-muted">1543 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-airplay-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">ساخت و ساز / تاسیسات</h5>
                                </a>
                                <p class="mb-0 text-muted">3241 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm mb-4 mx-auto position-relative">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-bank-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">دولت</h5>
                                </a>
                                <p class="mb-0 text-muted">876 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-focus-2-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">بازاریابی و تبلیغات</h5>
                                </a>
                                <p class="mb-0 text-muted">465 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-pencil-ruler-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">آموزش و پرورش</h5>
                                </a>
                                <p class="mb-0 text-muted">105 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-line-chart-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">دیجیتال مارکتینگ</h5>
                                </a>
                                <p class="mb-0 text-muted">377 شغل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow-none text-center py-3">
                            <div class="card-body py-4">
                                <div class="avatar-sm position-relative mb-4 mx-auto">
                                    <div class="job-icon-effect"></div>
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-briefcase-2-line fs-1"></i>
                                    </div>
                                </div>
                                <a href="#!" class="stretched-link">
                                    <h5 class="fs-17 pt-1">پذیرایی و گردشگری</h5>
                                </a>
                                <p class="mb-0 text-muted">85 شغل</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end services -->

        <!-- start cta -->
        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-sm">
                        <div>
                            <h4 class="text-white fw-bold mb-2">آماده برای شروع؟</h4>
                            <p class="text-white-50 mb-0">یک حساب کاربری جدید ایجاد کنید و دوست خود را معرفی کنید</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div>
                            <a href="#!" class="btn bg-gradient btn-danger">ایجاد حساب کاربری رایگان</a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end cta -->

        <section class="section" id="findJob">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 ff-secondary fw-bold text-capitalize lh-base">خودت را پیدا کن<span class="text-primary">شغلی</span>شما سزاوار آن هستید</h1>
                            <p class="text-muted">یک شغل ارسال کنید تا در مورد پروژه خود به ما بگویید. ما به سرعت شما را با فریلنسرهای مناسب هماهنگ خواهیم کرد.</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning-subtle rounded">
                                            <img src="../../assets/images/companies/img-3.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>طراح UI/UX</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>فن آوری های نستا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>ایالات متحده آمریکا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>$aqq - برادرت</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-success-subtle text-success">طراحی</span>
                                            <span class="badge bg-danger-subtle text-danger">UI/UX</span>
                                            <span class="badge bg-primary-subtle text-primary">Adobe XD</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-primary-subtle rounded">
                                            <img src="../../assets/images/companies/img-2.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>کارشناس فروش محصولات</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>دیجی‌تک کهکشانی</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>اسپانیا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>10 تا 15 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-primary-subtle text-primary">فروش</span>
                                            <span class="badge bg-secondary-subtle text-secondary">محصول</span>
                                            <span class="badge bg-info-subtle text-info">تجارت</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle active" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-danger-subtle rounded">
                                            <img src="../../assets/images/companies/img-4.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>مدیر بازاریابی</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>Meta4 Systems</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>سوئد</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>20 تا 25 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-warning-subtle text-warning">بازاریابی</span>
                                            <span class="badge bg-info-subtle text-info">تجارت</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle active" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-success-subtle rounded">
                                            <img src="../../assets/images/companies/img-9.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>طراح محصول</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>نام تجاری تم</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>ایالات متحده آمریکا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>+40 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-success-subtle text-success">طراحی</span>
                                            <span class="badge bg-danger-subtle text-danger">UI/UX</span>
                                            <span class="badge bg-primary-subtle text-primary">Adobe XD</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-info-subtle rounded">
                                            <img src="../../assets/images/companies/img-1.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>مدیر پروژه</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>Syntyce Solutions</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>آلمان</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>18 تا 26 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-danger-subtle text-danger">منابع انسانی</span>
                                            <span class="badge bg-success-subtle text-success">مدیر</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-success-subtle rounded">
                                            <img src="../../assets/images/companies/img-7.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>همکار تجاری</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>فن آوری های نستا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>ایالات متحده آمریکا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>$aqq - برادرت</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-success-subtle text-success">طراحی</span>
                                            <span class="badge bg-danger-subtle text-danger">UI/UX</span>
                                            <span class="badge bg-primary-subtle text-primary">Adobe XD</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle active" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-info-subtle rounded">
                                            <img src="../../assets/images/companies/img-8.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>هماهنگ کننده استخدام</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>مد زئوتیک</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>نامیبیا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>12 تا 15 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-success-subtle text-success">تمام وقت</span>
                                            <span class="badge bg-info-subtle text-info">از راه دور</span>
                                            <span class="badge bg-primary-subtle text-primary">مد</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle active" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning-subtle rounded">
                                            <img src="../../assets/images/companies/img-5.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <a href="#!">
                                            <h5>مامور گمرک</h5>
                                        </a>
                                        <ul class="list-inline text-muted mb-3">
                                            <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i>فن آوری های نستا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-map-pin-2-line align-bottom me-1"></i>ایالات متحده آمریکا</li>
                                            <li class="list-inline-item">
                                                <i class="ri-money-dollar-circle-line align-bottom me-1"></i>41 تا 45 هزار دلار</li>
                                        </ul>
                                        <div class="hstack gap-2">
                                            <span class="badge bg-success-subtle text-success">طراحی</span>
                                            <span class="badge bg-danger-subtle text-danger">UI/UX</span>
                                            <span class="badge bg-primary-subtle text-primary">Adobe XD</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                            <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                            <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-center mt-4">
                            <a href="#!" class="btn btn-ghost-info">مشاهده مشاغل بیشتر<i class="ri-arrow-left-line align-bottom"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- start find jobs -->
        <section class="section">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="text-muted mt-5 mt-lg-0">
                            <h5 class="fs-12 text-uppercase text-danger fw-semibold">شرکت برجسته داغ</h5>
                            <h1 class="mb-3 ff-secondary fw-bold text-capitalize lh-base">دریافت کنید<span class="text-primary">10000+</span>شرکت های برجسته</h1>
                            <p class="ff-secondary mb-2">تقاضا برای خدمات نوشتن محتوا در حال افزایش است. این به این دلیل است که محتوا تقریباً در هر صنعتی مورد نیاز است.<b> بسیاری از شرکت ها کشف کرده اند که بازاریابی محتوا چقدر موثر است. </b>این یکی از دلایل اصلی این افزایش تقاضا است.</p>
                            <p class="mb-4 ff-secondary">یک محتوانویس حرفه ای است که مقالات آموزنده و جذاب می نویسد تا به برندها کمک کند محصولات خود را به نمایش بگذارند.</p>

                            <div class="mt-4">
                                <a href="index.html" class="btn btn-primary">مشاهده شرکت های بیشتر<i class="ri-arrow-left-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4 col-sm-7 col-10 ms-lg-auto mx-auto order-1 order-lg-2">
                        <div>
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <button type="button" class="btn btn-icon btn-soft-primary float-end" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                                    <div class="avatar-sm mb-4">
                                        <div class="avatar-title bg-secondary-subtle rounded">
                                            <img src="../../assets/images/companies/img-1.png" alt="" class="avatar-xxs">
                                        </div>
                                    </div>
                                    <a href="#!">
                                        <h5>طراح وب جدید</h5>
                                    </a>
                                    <p class="text-muted">نام تجاری تم</p>

                                    <div class="d-flex gap-4 mb-3">
                                        <div>
                                            <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</div>

                                        <div>
                                            <i class="ri-time-line text-primary me-1 align-bottom"></i>3 دقیقه پیش</div>
                                    </div>

                                    <p class="text-muted">به عنوان یک طراح محصول، شما در یک تیم تحویل محصول که با استعدادهای UX، مهندسی، محصول و داده ترکیب شده است، کار خواهید کرد.</p>

                                    <div class="hstack gap-2">
                                        <span class="badge bg-success-subtle text-success">تمام وقت</span>
                                        <span class="badge bg-primary-subtle text-primary">آزادکار</span>
                                        <span class="badge bg-danger-subtle text-danger">فوری</span>
                                    </div>

                                    <div class="mt-4 hstack gap-2">
                                        <a href="#!" class="btn btn-soft-primary w-100">درخواست شغل</a>
                                        <a href="#!" class="btn btn-soft-success w-100">نمای کلی</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-lg bg-secondary mb-0 features-company-widgets rounded-3">
                                <div class="card-body">
                                    <h5 class="text-white fs-16 mb-4">بیش از 10000 شرکت برجسته</h5>

                                    <div class="d-flex gap-1">
                                        <a href="javascript:%20void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light bg-opacity-25 rounded-circle">
                                                    <img src="../../assets/images/companies/img-5.png" alt="" height="15">
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:%20void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light bg-opacity-25 rounded-circle">
                                                    <img src="../../assets/images/companies/img-2.png" alt="" height="15">
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:%20void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light bg-opacity-25 rounded-circle">
                                                    <img src="../../assets/images/companies/img-8.png" alt="" height="15">
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:%20void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light bg-opacity-25 rounded-circle">
                                                    <img src="../../assets/images/companies/img-7.png" alt="" height="15">
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:%20void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="More Companies">
                                            <div class="avatar-xs">
                                                <div class="avatar-title fs-11 rounded-circle bg-light bg-opacity-25 text-white">1k+</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end find jobs -->

        <!-- start candidates -->
        <section class="section bg-light" id="candidates">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 ff-secondary fw-bold text-capitalize lh-base">استخدام کارشناسان<span class="text-primary">تیم</span></h1>
                            <p class="text-muted mb-4">هزینه استخدام کارشناسان در هر ساعت بیشتر از استخدام فریلنسرهای ابتدایی یا متوسط ​​است، اما آنها معمولاً می توانند کار را سریعتر و بهتر انجام دهند.</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper candidate-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <div class="card-body p-4">
                                            <img src="../../assets/images/users/avatar-2.jpg" alt="" class="rounded-circle avatar-md mx-auto d-block">
                                            <h5 class="fs-17 mt-3 mb-2">نانسی مارتینو</h5>
                                            <p class="text-muted fs-13 mb-3">طراح خلاق</p>

                                            <p class="text-muted mb-4 fs-14">
                                                <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</p>

                                            <a href="#!" class="btn btn-secondary w-100">مشاهده نمایه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <div class="card-body p-4">
                                            <img src="../../assets/images/users/avatar-3.jpg" alt="" class="rounded-circle avatar-md mx-auto d-block">
                                            <h5 class="fs-17 mt-3 mb-2">گلن ماتنی</h5>
                                            <p class="text-muted fs-13 mb-3">مدیر بازاریابی</p>

                                            <p class="text-muted mb-4 fs-14">
                                                <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</p>

                                            <a href="#!" class="btn btn-secondary w-100">مشاهده نمایه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <div class="card-body p-4">
                                            <img src="../../assets/images/users/avatar-10.jpg" alt="" class="rounded-circle avatar-md mx-auto d-block">
                                            <h5 class="fs-17 mt-3 mb-2">الکسیس کلارک</h5>
                                            <p class="text-muted fs-13 mb-3">مدیر محصول</p>

                                            <p class="text-muted mb-4 fs-14">
                                                <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</p>

                                            <a href="#!" class="btn btn-secondary w-100">مشاهده نمایه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <div class="card-body p-4">
                                            <img src="../../assets/images/users/avatar-8.jpg" alt="" class="rounded-circle avatar-md mx-auto d-block">
                                            <h5 class="fs-17 mt-3 mb-2">جیمز پرایس</h5>
                                            <p class="text-muted fs-13 mb-3">طراح محصول</p>

                                            <p class="text-muted mb-4 fs-14">
                                                <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</p>

                                            <a href="#!" class="btn btn-secondary w-100">مشاهده نمایه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <div class="card-body p-4">
                                            <img src="../../assets/images/users/avatar-5.jpg" alt="" class="rounded-circle avatar-md mx-auto d-block">
                                            <h5 class="fs-17 mt-3 mb-2">مایکل موریس</h5>
                                            <p class="text-muted fs-13 mb-3">توسعه دهنده Full Stack</p>

                                            <p class="text-muted mb-4 fs-14">
                                                <i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>اسکوندیدو، کالیفرنیا</p>

                                            <a href="#!" class="btn btn-secondary w-100">مشاهده نمایه</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </section>
        <!-- end candidates -->

        <!-- start blog -->
        <section class="section" id="blog">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="mb-3 ff-secondary fw-bold text-capitalize lh-base"> آخرین مطالب <span class="text-primary">وبلاگ</span></h2>
                            <p class="text-muted mb-4">

                            </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    @if($latestPosts->count() > 0)
                        @foreach($latestPosts as $post)
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{Storage::url($post->thumbnail)}}" alt="" class="img-fluid rounded">
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-inline fs-14 text-muted">
                                            <li class="list-inline-item">
                                                <i class="ri-calendar-line align-bottom me-1"></i>30 اکتبر 2021</li>
                                            <li class="list-inline-item">
                                                <i class="ri-message-2-line align-bottom me-1"></i>364 نظر</li>
                                        </ul>
                                        <a href="javascript:void(0);">
                                            <h5>برنامه های خود را به روش خود طراحی کنید؟</h5>
                                        </a>
                                        <p class="text-muted fs-14">یکی از معایب Lorum Ipsum این است که در طرح های لاتین حروف خاصی بیشتر از بقیه ظاهر می شوند.</p>

                                        <div>
                                            <a href="#!" class="link-success">بیشتر بدانید<i class="ri-arrow-left-line align-bottom ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">
                            <strong>هیچ پستی برای نمایش وجود ندارد.</strong>
                        </p>
                    @endif
                </div>
            </div>
            <!-- end container -->
        </section>
        <!-- end blog -->

        <!-- start cta -->
        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-sm">
                        <div>
                            <h4 class="text-white fw-bold">دریافت اعلان مشاغل جدید!</h4>
                            <p class="text-white text-opacity-75 mb-0">مشترک شوید و همه اعلان مشاغل مرتبط را دریافت کنید.</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <button class="btn btn-danger" type="button">اکنون مشترک شوید<i class="ri-arrow-left-line align-bottom"></i></button>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end cta -->

    </div>
@endsection
