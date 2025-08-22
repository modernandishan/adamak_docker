@php
    use App\Models\Setting;
    $settings = Setting::all();
    $theme = $settings->where('meta_title', 'theme')->first();
    $topbar = $settings->where('meta_title', 'topbar')->first();
    $preloader = $settings->where('meta_title', 'preloader')->first();
    $layout_position = $settings->where('meta_title', 'layout-position')->first();
    $layout_width = $settings->where('meta_title', 'layout-width')->first();
@endphp
    <!DOCTYPE html>
<html data-layout-width="{{$layout_position->meta_data ?? 'fluid'}}" data-layout-position="{{$layout_position->meta_data ?? 'scrollable'}}" lang="fa" dir="rtl" data-theme="{{$theme->meta_data  ?? 'creative'}}"
      data-layout="horizontal" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-preloader="{{$topbar->meta_data ?? 'disable'}}" data-sidebar-visibility="hidden" data-topbar="{{$topbar->meta_data ?? 'dark'}}">

<head>

    <meta charset="utf-8">
    <title>
        @yield('title' ?? 'سامانه جامع مشاوره هوشمند آدمک')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Mordad" name="author">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    @stack('styles')
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom-rtl.min.css') }}" rel="stylesheet" type="text/css">


</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">
    @livewire('elements.header')

    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        @yield('content')
        @livewire('elements.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">در حال بارگذاری...</span>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
@stack('scripts')
<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
</body>

</html>
