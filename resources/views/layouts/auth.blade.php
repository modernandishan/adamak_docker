<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="creative" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8">
    <title>@yield('title') | آدمک</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Mordad" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="../../assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="../../assets/css/app-rtl.min.css" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="../../assets/css/custom-rtl.min.css" rel="stylesheet" type="text/css">


</head>

<body>

<!-- auth-page wrapper -->
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    @yield('content')
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-center">©
                            <script>document.write(new Date().getFullYear())</script>
                            ساخته شده با <i class="mdi mdi-heart text-danger"></i> توسط مدرن اندیشان جی
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../../assets/libs/node-waves/waves.min.js"></script>
<script src="../../assets/libs/feather-icons/feather.min.js"></script>
<script src="../../assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="../../assets/js/plugins.js"></script>

<!-- validation init -->
<script src="../../assets/js/pages/form-validation.init.js"></script>
<!-- password create init -->
<script src="../../assets/js/pages/passowrd-create.init.js"></script>

@stack('scripts')
</body>

</html>
