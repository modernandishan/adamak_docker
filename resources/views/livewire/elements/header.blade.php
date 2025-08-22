<div>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{route('home')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="../../assets/images/logo-sm.png" alt="" height="40">
                        </span>
                            <span class="logo-lg">
                            <img src="../../assets/images/logo-dark.png" alt="" height="40">
                        </span>
                        </a>

                        <a href="{{route('home')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="../../assets/images/logo-sm.png" alt="" height="40">
                        </span>
                            <span class="logo-lg">
                            <img src="../../assets/images/logo-light.png" alt="" height="40">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-md-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="جستجو..." autocomplete="off"
                                   id="search-options" value="">
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                  id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <div data-simplebar style="max-height: 320px;">
                                <!-- item-->
                                <div class="dropdown-header">
                                    <h6 class="text-overflow text-muted mb-0 text-uppercase">جستجوهای اخیر</h6>
                                </div>

                                <div class="dropdown-item bg-transparent text-wrap">
                                    <a href="{{route('home')}}" class="btn btn-soft-secondary btn-sm rounded-pill">نحوه راه
                                        اندازی<i class="mdi mdi-magnify ms-1"></i></a>
                                    <a href="{{route('home')}}" class="btn btn-soft-secondary btn-sm rounded-pill">دکمه ها<i
                                            class="mdi mdi-magnify ms-1"></i></a>
                                </div>
                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-1 text-uppercase">صفحات</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                    <span>داشبورد تجزیه و تحلیل</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                    <span>مرکز راهنمایی</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                    <span>تنظیمات حساب من</span>
                                </a>

                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-2 text-uppercase">اعضا</h6>
                                </div>

                                <div class="notification-list">
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="../../assets/images/users/avatar-2.jpg"
                                                 class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                            <div class="flex-grow-1">
                                                <h6 class="m-0">آنجلا برنیر</h6>
                                                <span class="fs-11 mb-0 text-muted">مدیر</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="../../assets/images/users/avatar-3.jpg"
                                                 class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                            <div class="flex-grow-1">
                                                <h6 class="m-0">دیوید گراسو</h6>
                                                <span class="fs-11 mb-0 text-muted">طراح وب</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="../../assets/images/users/avatar-5.jpg"
                                                 class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                            <div class="flex-grow-1">
                                                <h6 class="m-0">مایک باچ</h6>
                                                <span class="fs-11 mb-0 text-muted">React Developer</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="text-center pt-3 pb-1">
                                <a href="pages-search-results.html" class="btn btn-primary btn-sm">مشاهده همه نتایج<i
                                        class="ri-arrow-left-line ms-1"></i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="جستجو ..."
                                               aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-category-alt fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fw-semibold fs-15">برنامه های وب</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{route('contact')}}" class="btn btn-sm btn-soft-info">مشاهده همه برنامه ها<i
                                                class="ri-arrow-left-s-line align-middle"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                @foreach($socials->chunk(3) as $row)
                                    <div class="row g-0">
                                        @foreach($row as $social)
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{ $social->link }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $social->logo) }}" alt="{{ $social->title }}">
                                                    <span>{{ $social->title }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                            <i class="bx bx-fullscreen fs-22"></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class="bx bx-moon fs-22"></i>
                        </button>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-bell fs-22"></i>
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span
                                    class="visually-hidden">پیام های خوانده نشده</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head bg-secondary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white">اطلاعیه ها</h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge bg-light-subtle text-body fs-13">4 جدید</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                        id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                               role="tab" aria-selected="true">همه (4)</a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab"
                                               aria-selected="false">پیام ها</a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab"
                                               aria-selected="false">هشدارها</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="tab-content position-relative" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">شما<b> نخبگان </b>گرافیک نویسنده
                                                            بهینه سازی<span class="text-secondary"> پاداش </span>است
                                                            آماده!</h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i
                                                                class="mdi mdi-clock-outline"></i>فقط 30 ثانیه پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="all-notification-check01">
                                                        <label class="form-check-label"
                                                               for="all-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-2.jpg"
                                                     class="me-3 rounded-circle avatar-xs flex-shrink-0"
                                                     alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">آنجلا برنیر</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">به نظر شما در مورد پیش بینی جریان نقدی پاسخ داده
                                                            شد
                                                            نمودار 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>48 دقیقه پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="all-notification-check02">
                                                        <label class="form-check-label"
                                                               for="all-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                    <i class="bx bx-message-square-dots"></i>
                                                </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 fs-13 lh-base">دریافت کرده اید <b
                                                                class="text-success">20 </b>پیام های جدید در مکالمه</h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>2 ساعت پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="all-notification-check03">
                                                        <label class="form-check-label"
                                                               for="all-notification-check03"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-8.jpg"
                                                     class="me-3 rounded-circle avatar-xs flex-shrink-0"
                                                     alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">مورین گیبسون</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">ما در مورد پروژه ای در لینکدین صحبت کردیم.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>4 ساعت پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="all-notification-check04">
                                                        <label class="form-check-label"
                                                               for="all-notification-check04"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center view-all">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                مشاهده کنید
                                                همه اعلان ها<i class="ri-arrow-left-line align-middle"></i></button>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel"
                                     aria-labelledby="messages-tab">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-3.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">جیمز لمیر</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">ما در مورد پروژه ای در لینکدین صحبت کردیم.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>30 دقیقه پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check01">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-2.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">آنجلا برنیر</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">به نظر شما در مورد پیش بینی جریان نقدی پاسخ داده
                                                            شد
                                                            نمودار 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>2 ساعت پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check02">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-6.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">کنت براون</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">از شما در کامنت خود در 📃 فاکتور شماره 12501 نام
                                                            برده است.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>10 ساعت پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check03">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check03"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="../../assets/images/users/avatar-8.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="کاربر-عکس">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">مورین گیبسون</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">ما در مورد پروژه ای در لینکدین صحبت کردیم.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i>3 روز پیش</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check04">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check04"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center view-all">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                مشاهده کنید
                                                همه پیام ها<i class="ri-arrow-left-line align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel"
                                     aria-labelledby="alerts-tab"></div>

                                <div class="notification-actions" id="notification-actions">
                                    <div class="d-flex text-muted justify-content-center">انتخاب کنید
                                        <div id="select-content" class="text-body fw-semibold px-1">0</div>
                                        نتیجه
                                        <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                                data-bs-toggle="modal" data-bs-target="#removeNotificationModal">حذف
                                            کنید
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @auth
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="@if($user->profile->avatar == null) {{asset('images/default-avatar.png')}} @else {{Storage::url($user->profile->avatar)}} @endif"
                                 alt="آواتار سرصفحه">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">{{$user->name}}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{$user->family}}</span>
                            </span>
                        </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">خوش آمدی {{$user->name}}!</h6>
                                @role('super_admin')
                                <a class="dropdown-item" href="{{url('/admin')}}"><span
                                        class="badge bg-success-subtle text-success mt-1 float-end">مدیر</span><i
                                        class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">پنل مدیریت</span></a>
                                @endrole
                                <a class="dropdown-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                                   href="{{route('user.dashboard')}}"><i
                                        class="ri-dashboard-2-line text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">داشبورد</span></a>
                                <a class="dropdown-item {{ request()->routeIs('user.profile.edit') ? 'active' : '' }}"
                                   href="{{route('user.profile.edit')}}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">نمایه (پروفایل)</span></a>
                                <a class="dropdown-item" href="apps-chat.html"><i
                                        class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">پیام ها</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ request()->routeIs('user.wallet.charge.form') ? 'active' : '' }}" href="{{route('user.wallet.charge.form')}}"><i
                                        class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">کیف پول:<b> {{$user->wallet->balance}} ریال </b></span></a>
                                @role('super_admin')
                                <a class="dropdown-item" href="{{url('/admin/settings')}}"><span
                                        class="badge bg-success-subtle text-success mt-1 float-end">مدیر</span><i
                                        class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">تنظیمات</span></a>
                                @endrole
                                @auth
                                    <form method="POST" action="{{ route('user.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i><span
                                                class="align-middle" data-key="t-logout">خروج از سیستم</span>
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    @else
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">آدمک</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">حساب کاربری</span>
                            </span>
                        </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">سیستم احراز هویت</h6>
                                <a class="dropdown-item" href="{{route('user.login')}}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">ورود</span></a>
                                <a class="dropdown-item" href="{{route('user.register')}}"><i
                                        class="mdi mdi-account-plus text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">ثبت نام</span></a>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </header>
    <!-- removeNotificationModal -->
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#495057,secondary:#f06548"
                                   style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4 class="fw-bold">مطمئنی؟</h4>
                            <p class="text-muted mx-4 mb-0">آیا مطمئن هستید که می خواهید این اعلان را حذف کنید؟</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">بستن</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">بله، آن را حذف
                            کنید!
                        </button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="{{route('home')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../../assets/images/logo-sm.png" alt="" height="40">
                    </span>
                <span class="logo-lg">
                        <img src="../../assets/images/logo-dark.png" alt="" height="40">
                    </span>
            </a>
            <!-- Light Logo-->
            <a href="{{route('home')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../../assets/images/logo-sm.png" alt="" height="40">
                    </span>
                <span class="logo-lg">
                        <img src="../../assets/images/logo-light.png" alt="" height="40">
                    </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">منو</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('home') ? 'link-info' : '' }}"
                           href="{{route('home')}}">
                            <i class="ri-home-smile-line"></i>صفحه نخست
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('blog') ? 'link-info' : '' }}"
                           href="{{route('blog')}}">
                            <i class="ri-article-fill"></i>وبلاگ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('tests.index') ? 'link-info' : '' }}"
                           href="{{route('tests.index')}}">
                            <i class="ri-test-tube-fill"></i>آزمون‌های آدمک
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
</div>
