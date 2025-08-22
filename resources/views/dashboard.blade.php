@extends('layouts.main')
@section('title', 'پنل کاربری | آدمک')
@push('styles')
    <!-- jsvectormap css -->
    <link href="../../assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css">
    <!--Swiper slider css-->
    <link href="../../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <!-- apexcharts -->
    <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- Vector map-->
    <script src="../../assets/libs/jsvectormap/jsvectormap.min.js"></script>
    <script src="../../assets/libs/jsvectormap/maps/world-merc.js"></script>
    <!--Swiper slider js-->
    <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- Dashboard init -->
    <script src="../../assets/js/pages/dashboard-ecommerce.init.js"></script>
@endpush
@section('content')
    @if(session('first-family-created'))
        <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
            <i class="ri-check-double-line me-3 align-middle fs-16"></i> <strong>تعریف خانواده شما</strong>با موفقیت انجام شد.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">خوش آمدید به سامانه
                                        <strong class="text-success">آدمک</strong>،
                                            {{$user->name}}
                                            عزیز!
                                        </h4>
                                        <p class="text-muted mb-0">
                                            آدمک، تکنولوژی جدید برای شناخت بیشتر فرزندانمان...
                                        </p>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                        <form action="javascript:void(0);">
                                            <div class="row g-3 mb-0 align-items-center">
                                                <div class="col-auto">
                                                    <a href="{{route('tests.index')}}" type="button" class="btn btn-soft-secondary">
                                                        <i class="ri-add-circle-line align-middle me-1"></i>
                                                        شرکت در آزمون های آدمک
                                                    </a>
                                                </div>
                                                <!--end col-->
                                                <div class="col-auto">
                                                    <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                </div><!-- end card header -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-primary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">کل درآمد</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-white fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>+16.24٪</h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">$<span class="counter-value" data-target="559.25">0</span>k</h4>
                                                <a href="" class="text-decoration-underline text-white-50">مشاهده درآمد خالص</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-white bg-opacity-10 rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-white"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            @livewire('elements.user-dashboard-taken-tests')

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">مشتریان</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-white fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>+29.08٪</h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span class="counter-value" data-target="183.35">0</span>م</h4>
                                                <a href="" class="text-decoration-underline text-white-50">جزئیات را ببینید</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-white bg-opacity-10 rounded fs-3">
                                                            <i class="bx bx-user-circle text-white"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>

                            @livewire('elements.user-dashboard-wallet-card')
                        </div>

                        @if($user->families->count() == 0)
                            <div class="row">
                                <div class="col-xxl-4">
                                    <div class="card border card-border-warning">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">هنوز خانواده خود را برای شرکت در آزمون های <strong>آدمک</strong> معرفی نکرده اید؟!<span class="badge bg-warning align-middle fs-10">ما منتظر شما هستیم</span></h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text" style="text-align: justify">
                                                اکثر آزمون های وب اپلیکیشن
                                                <strong>آدمک</strong>
                                                که توسط مشاوران حرفه ای این تیم بررسی میشود، نیاز به آشنایی سطحی با خانواده شما داریم. بنابراین خانواده خود را تعریف کنید و از تخفیف ویژه شرکت در اولین آزمون ما بهرمند شوید...!
                                            </p>
                                            <div class="text-end">
                                                <a href="{{route('user.family.add')}}" class="link-warning fw-medium">تعریف خانواده جدید<i class="ri-arrow-left-line align-middle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else

                            <div class="col-xxl-4">
                                <!-- Right Ribbon -->
                                <div class="card ribbon-box border shadow-none mb-lg-0 right">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-success"><span>تبریک</span></div>
                                        <h5 class="fs-14 mb-3">
                                            شما
                                            <strong class="text-danger">
                                                {{$user->families->count()}}
                                            </strong>
                                            خانواده در سامانه آدمک ثبت کرده اید
                                        </h5>
                                        <p class="mb-0" style="text-align: justify">
                                            اکنون میتوانید به راحتی در آزمون های ویژه
                                            <strong>آدمک</strong>
                                            شرکت کنید! با ثبت خانواده، مشاوران و متخصصان ما میتوانند نتایج دقیق تری را به شما ارائه کنند.
                                        </p>
                                        <br>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{route('tests.index')}}" class="btn btn-soft-success">مشاهده آزمون ها</a>
                                            <a href="{{route('user.family.show')}}" class="btn btn-soft-secondary">مدیریت خانواده</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endif



                    </div> <!-- end .h-100-->

                </div> <!-- end col -->

                <div class="col-auto layout-rightside-col">
                    <div class="overlay"></div>
                    <div class="layout-rightside">
                        <div class="card h-100 rounded-0">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <h6 class="text-muted mb-0 text-uppercase fw-bold fs-13">فعالیت اخیر</h6>
                                </div>
                                <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                                    <div class="acitivity-timeline acitivity-main">
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                    <i class="ri-shopping-cart-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">خرید توسط جیمز پرایس</h6>
                                                <p class="text-muted mb-1">ساعت هوشمند تکامل نویز محصول</p>
                                                <small class="mb-0 text-muted">02:14 عصر امروز</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">جدید اضافه شد<span class="fw-semibold">مجموعه سبک</span></h6>
                                                <p class="text-muted mb-1">توسط Nesta Technologies</p>
                                                <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                                    <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                        <img src="../../assets/images/products/img-8.png" alt="" class="img-fluid d-block">
                                                    </a>
                                                    <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                        <img src="../../assets/images/products/img-2.png" alt="" class="img-fluid d-block">
                                                    </a>
                                                    <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                        <img src="../../assets/images/products/img-10.png" alt="" class="img-fluid d-block">
                                                    </a>
                                                </div>
                                                <p class="mb-0 text-muted"><small>9:47 عصر دیروز</small></p>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="../../assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle acitivity-avatar">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">ناتاشا کری این محصولات را پسندیده است</h6>
                                                <p class="text-muted mb-1">به کاربران اجازه دهید محصولات موجود در فروشگاه ووکامرس شما را دوست داشته باشند.</p>
                                                <small class="mb-0 text-muted">25 دسامبر 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">پیشنهادات امروز توسط<a href="apps-ecommerce-seller-details.html" class="link-secondary">دیجی‌تک کهکشانی</a></h6>
                                                <p class="text-muted mb-2">این پیشنهاد فقط برای سفارشات 500 روپیه یا بالاتر برای محصولات انتخاب شده معتبر است.</p>
                                                <small class="mb-0 text-muted">12 دسامبر 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                                        <i class="ri-bookmark-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">محصول مورد علاقه</h6>
                                                <p class="text-muted mb-2">استر جیمز محصول مورد علاقه خود را دارد.</p>
                                                <small class="mb-0 text-muted">25 نوامبر 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">فروش فلش شروع شد<span class="text-primary">فردا</span></h6>
                                                <p class="text-muted mb-0">فروش فلش توسط<a href="javascript:void(0);" class="link-secondary fw-medium">مد زئوتیک</a></p>
                                                <small class="mb-0 text-muted">22 اکتبر 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                                        <i class="ri-line-chart-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">گزارش فروش ماهانه</h6>
                                                <p class="text-muted mb-2"><span class="text-danger">2 روز مونده</span>اطلاعیه ارسال گزارش فروش ماهانه<a href="javascript:void(0);" class="link-warning text-decoration-underline">گزارش ساز</a></p>
                                                <small class="mb-0 text-muted">15 اکتبر</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="../../assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle acitivity-avatar">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">فرانک هوک نظر داد</h6>
                                                <p class="text-muted mb-2 fst-italic">"محصولی که نقد و بررسی دارد، بیشتر از یک محصول به فروش می رسد."</p>
                                                <small class="mb-0 text-muted">26 آگوست 2021</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @livewire('elements.post-category-dashboard-sidebar')

                                @livewire('elements.dashboard-comments')

                                @livewire('elements.dashboard-average-stars')

                                <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
                                    <div class="card-body">
                                        <img src="../../assets/images/giftbox.png" alt="">
                                        <div class="mt-4">
                                            <h5>از فروشنده جدید دعوت کنید</h5>
                                            <p class="text-muted lh-base">یک فروشنده جدید را به ما معرفی کنید و به ازای هر مراجعه 100 دلار کسب کنید.</p>
                                            <button type="button" class="btn btn-primary btn-label rounded-pill"><i class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>اکنون دعوت کنید</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end .rightbar-->

                </div> <!-- end col -->
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
