<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="creative" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8">
    <title>
        @yield('title' ?? 'سامانه جامع مشاوره هوشمند آدمک')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Mordad" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <!--Swiper slider css-->
    <link href="{{asset('assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom-rtl.min.css')}}" rel="stylesheet" type="text/css">


</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

<!-- Begin page -->
<div class="layout-wrapper landing">
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top job-navbar" id="navbar">
        <div class="container-fluid custom-container">
            <a class="navbar-brand" href="index.html">
                <img src="../../assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="آرم تیره" height="17">
                <img src="../../assets/images/logo-light.png" class="card-logo card-logo-light" alt="نور لوگو" height="17">
            </a>
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item">
                        <a class="nav-link fs-16 active" href="#hero">صفحه اصلی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-16" href="#process">فرآیند</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-16" href="#categories">دسته بندی ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-16" href="#findJob">شغل پیدا کنید</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-16" href="#candidates">نامزدها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-16" href="#blog">وبلاگ</a>
                    </li>
                </ul>

                <div class="">
                    <a href="auth-signin-basic.html" class="btn btn-soft-danger"><i class="ri-user-3-line align-bottom me-1"></i>ورود و ثبت نام</a>
                </div>
            </div>

        </div>
    </nav>
    <!-- end navbar -->

    <!-- start hero section -->
    <section class="section job-hero-section bg-light pb-0" id="hero">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div>
                        <h1 class="display-6 fw-bold text-capitalize mb-3 lh-base">شغل بعدی خود را پیدا کنید و رویای خود را در اینجا بسازید</h1>
                        <p class="lead text-muted lh-base mb-4">شغل پیدا کنید، رزومه های قابل پیگیری ایجاد کنید و برنامه های خود را غنی کنید. پس از تجزیه و تحلیل نیازهای صنایع مختلف به دقت ساخته شده است.</p>
                        <form action="#" class="job-panel-filter">
                            <div class="row g-md-0 g-2">
                                <div class="col-md-4">
                                    <div>
                                        <input type="search" id="job-title" class="form-control filter-input-box" placeholder="شغل، نام شرکت ...">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-4">
                                    <div>
                                        <select class="form-control" data-choices>
                                            <option value="">نوع کار را انتخاب کنید</option>
                                            <option value="Full Time">تمام وقت</option>
                                            <option value="Part Time">پاره وقت</option>
                                            <option value="Freelance">آزادکار</option>
                                            <option value="Internship">کارآموزی</option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-4">
                                    <div class="h-100">
                                        <button class="btn btn-primary submit-btn w-100 h-100" type="submit"><i class="ri-search-2-line align-bottom me-1"></i>شغل پیدا کن</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>

                        <ul class="treding-keywords list-inline mb-0 mt-3 fs-13">
                            <li class="list-inline-item text-danger fw-semibold"><i class="mdi mdi-tag-multiple-outline align-middle"></i>کلمات کلیدی پرطرفدار:</li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="link-secondary">طراحی،</a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="link-secondary">توسعه،</a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="link-secondary">مدیر،</a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="link-secondary">ارشد</a></li>
                        </ul>
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
                                <h5 class="fs-15 lh-base mb-0">استعلام کار از ولـزون</h5>
                            </div>
                        </div>

                        <div class="card p-3 rounded shadow-lg application-box">
                            <h5 class="fs-15 lh-base mb-3">برنامه های کاربردی</h5>
                            <div class="avatar-group">
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                    <div class="avatar-xs">
                                        <img src="../../assets/images/users/avatar-3.jpg" alt="" class="rounded-circle img-fluid">
                                    </div>
                                </a>
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ellen Smith">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded-circle bg-danger">اس</div>
                                    </div>
                                </a>
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ellen Smith">
                                    <div class="avatar-xs">
                                        <img src="../../assets/images/users/avatar-10.jpg" alt="" class="rounded-circle img-fluid">
                                    </div>
                                </a>
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded-circle bg-success">ز</div>
                                    </div>
                                </a>
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                    <div class="avatar-xs">
                                        <img src="../../assets/images/users/avatar-9.jpg" alt="" class="rounded-circle img-fluid">
                                    </div>
                                </a>
                                <a href="javascript:%20void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="More Appliances">
                                    <div class="avatar-xs">
                                        <div class="avatar-title fs-13 rounded-circle bg-light border-dashed border text-primary">معادله +</div>
                                    </div>
                                </a>
                            </div>
                        </div>
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
                        <h1 class="mb-3 ff-secondary fw-bold lh-base">چگونه<span class="text-primary">این کار است</span>مشاغل خلاقانه و ویژگی های سریع</h1>
                        <p class="text-muted">یک فرد خلاق توانایی ابداع و توسعه ایده های بدیع به ویژه در هنر را دارد. مانند بسیاری از افراد خلاق، او هرگز راضی نبود.</p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!--end row-->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <h1 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                <div class="job-icon-effect"></div>
                                <span>1</span>
                            </h1>
                            <h6 class="fs-17 mb-2">ثبت حساب</h6>
                            <p class="text-muted mb-0 fs-15">ابتدا باید یک حساب کاربری ایجاد کنید.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-none">
                        <div class="card-body p-4">
                            <h1 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                <div class="job-icon-effect"></div>
                                <span>2</span>
                            </h1>
                            <h6 class="fs-17 mb-2">ایجاد رزومه</h6>
                            <p class="text-muted mb-0 fs-15">یک رزومه برای شغل خود ایجاد کنید.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-none">
                        <div class="card-body p-4">
                            <h1 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                <div class="job-icon-effect"></div>
                                <span>3</span>
                            </h1>

                            <h6 class="fs-17 mb-2">شغل پیدا کن</h6>
                            <p class="text-muted mb-0 fs-15">مشاغل رویایی خود را از velzon جستجو کنید.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-none">
                        <div class="card-body p-4">
                            <h1 class="fw-bold display-5 ff-secondary mb-4 text-success position-relative">
                                <div class="job-icon-effect"></div>
                                <span>4</span>
                            </h1>
                            <h6 class="fs-17 mb-2">درخواست شغل</h6>
                            <p class="text-muted mb-0 fs-15">به شرکت مراجعه کنید و منتظر مصاحبه باشید.</p>
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
                        <img src="../../assets/images/about.jpg" alt="" class="img-fluid mx-auto rounded-3">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-muted">
                        <h1 class="mb-3 fw-bold lh-base">خودت را پیدا کن<span class="text-primary">شغل رویایی</span>در یک مکان</h1>
                        <p class="ff-secondary fs-16 mb-2">اولین قدم برای پیدا کردن خود<b> شغل رویایی </b>در حال تصمیم گیری است که کجا به دنبال بینش دست اول باشد. با متخصصانی که در حال حاضر در صنایع یا موقعیت های مورد علاقه شما کار می کنند تماس بگیرید.</p>
                        <p class="ff-secondary fs-16">مصاحبه‌های اطلاعاتی و تماس‌های تلفنی را برنامه‌ریزی کنید یا از فرصتی بخواهید که آنها را در محل کار تحت الشعاع قرار دهید.</p>

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
                                    <p class="mb-0">اطلاعات پلاگین را راه اندازی کنید.</p>
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
                                    <p class="mb-0">اطلاعات سفارشی سازی تم</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="#!" class="btn btn-secondary">مشاغل خود را پیدا کنید<i class="ri-arrow-left-line align-bottom ms-1"></i></a>
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
                        <h1 class="mb-3 ff-secondary fw-bold text-capitalize lh-base">آخرین ما<span class="text-primary">اخبار</span></h1>
                        <p class="text-muted mb-4">زمانی که ایده‌های نوآورانه ارائه می‌کنیم، پیشرفت می‌کنیم، اما همچنین می‌دانیم که یک مفهوم هوشمند باید با نتایج قابل اندازه‌گیری faucibus sapien odio پشتیبانی شود.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="../../assets/images/small/img-8.jpg" alt="" class="img-fluid rounded">
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
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="../../assets/images/small/img-6.jpg" alt="" class="img-fluid rounded">
                        </div>
                        <div class="card-body">
                            <ul class="list-inline fs-14 text-muted">
                                <li class="list-inline-item">
                                    <i class="ri-calendar-line align-bottom me-1"></i>02 اکتبر 2021</li>
                                <li class="list-inline-item">
                                    <i class="ri-message-2-line align-bottom me-1"></i>245 نظر</li>
                            </ul>
                            <a href="javascript:void(0);">
                                <h5>هوشمندترین برنامه های کاربردی برای کسب و کار؟</h5>
                            </a>
                            <p class="text-muted fs-14">به دلیل استفاده گسترده از آن به عنوان متن پرکننده برای چیدمان ها، ناخوانایی از اهمیت زیادی برخوردار است: درک انسان.</p>

                            <div>
                                <a href="#!" class="link-success">بیشتر بدانید<i class="ri-arrow-left-line align-bottom ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="../../assets/images/small/img-9.jpg" alt="" class="img-fluid rounded">
                        </div>
                        <div class="card-body">
                            <ul class="list-inline fs-14 text-muted">
                                <li class="list-inline-item">
                                    <i class="ri-calendar-line align-bottom me-1"></i>23 سپتامبر 2021</li>
                                <li class="list-inline-item">
                                    <i class="ri-message-2-line align-bottom me-1"></i>354 نظر</li>
                            </ul>
                            <a href="javascript:void(0);">
                                <h5>چگونه اپلیکیشن ها دنیای فناوری اطلاعات را تغییر می دهند</h5>
                            </a>
                            <p class="text-muted fs-14">ذاتاً فرصت های شهودی و پتانسیل های زمان واقعی را انکوبه کنید فن آوری یک به یک را به طور مناسب ارتباط برقرار کنید.</p>

                            <div>
                                <a href="#!" class="link-success">بیشتر بدانید<i class="ri-arrow-left-line align-bottom ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

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

    <!-- Start footer -->
    <footer class="custom-footer bg-dark py-5 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mt-4">
                    <div>
                        <div>
                            <img src="../../assets/images/logo-light.png" alt="نور لوگو" height="17">
                        </div>
                        <div class="mt-4 fs-15">
                            <p>الگوی مدیریت چند منظوره و داشبورد ممتاز</p>
                            <p>شما می توانید هر نوع برنامه وب مانند تجارت الکترونیک، CRM، CMS، برنامه های مدیریت پروژه، پنل های مدیریت و غیره را با استفاده از Velzon بسازید.</p>
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <a href="javascript:%20void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript:%20void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-github-fill"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript:%20void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-linkedin-fill"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript:%20void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-google-fill"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript:%20void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-dribbble-line"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ms-lg-auto">
                    <div class="row">
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">شرکت</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list fs-15">
                                    <li><a href="pages-profile.html">درباره ما</a></li>
                                    <li><a href="pages-gallery.html">گالری</a></li>
                                    <li><a href="pages-team.html">تیم</a></li>
                                    <li><a href="pages-pricing.html">قیمت گذاری</a></li>
                                    <li><a href="pages-timeline.html">جدول زمانی</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">برای مشاغل</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list fs-15">
                                    <li><a href="apps-job-lists.html">لیست شغل</a></li>
                                    <li><a href="apps-job-application.html">کاربرد</a></li>
                                    <li><a href="apps-job-new.html">شغل جدید</a></li>
                                    <li><a href="apps-job-companies-lists.html">لیست شرکت</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">پشتیبانی کنید</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list fs-15">
                                    <li><a href="pages-faqs.html">سوالات متداول</a></li>
                                    <li><a href="pages-faqs.html">تماس بگیرید</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row text-center text-sm-start align-items-center mt-5">
                <div class="col-sm-6">
                    <div>
                        <p class="copy-rights mb-0">
                            <script> document.write(new Date().getFullYear()) </script>© Velzon - Mordad</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end mt-3 mt-sm-0">
                        <ul class="list-inline mb-0 footer-list gap-4 fs-15">
                            <li class="list-inline-item">
                                <a href="pages-privacy-policy.html">سیاست حفظ حریم خصوصی</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="pages-term-conditions.html">شرایط و ضوابط</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="pages-privacy-policy.html">امنیت</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->


    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-info btn-icon landing-back-top" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

</div>
<!-- end layout wrapper -->


<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>

<!--Swiper slider js-->
<script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

<!--job landing init -->
<script src="{{asset('assets/js/pages/job-lading.init.js')}}"></script>
</body>

</html>
