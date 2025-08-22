@extends('layouts.auth')
@section('content')
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row justify-content-center g-0">
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 auth-one-bg h-100">
                                    <div class="bg-overlay"></div>
                                    <div class="position-relative h-100 d-flex flex-column">
                                        <div class="mb-4">
                                            <a href="{{route('home')}}" class="d-block">
                                                <img src="../../assets/images/logo-light.png" alt="" height="18">
                                            </a>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-3">
                                                <i class="ri-double-quotes-l display-4 text-success"></i>
                                            </div>

                                            <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner text-center text-white-50 pb-5">
                                                    <div class="carousel-item active">
                                                        <p class="fs-15 fst-italic">"عالی! کد تمیز، طراحی تمیز، سفارشی سازی آسان. بسیار متشکرم!"</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">"موضوع با پشتیبانی شگفت انگیز مشتری واقعا عالی است."</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">"عالی! کد تمیز، طراحی تمیز، سفارشی سازی آسان. بسیار متشکرم!"</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <h5 class="text-primary">رمز عبور را فراموش کرده اید؟</h5>
                                    <p class="text-muted">بازنشانی رمز عبور با پیامک</p>

                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl">
                                        </lord-icon>
                                    </div>

                                    <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">شماره تماس خود را وارد کنید و دستورالعمل ها برای شما ارسال خواهد شد!</div>
                                    <div class="p-2">
                                        <form>
                                            <div class="mb-4">
                                                <label for="mobile" class="form-label">شماره تماس</label>
                                                <input type="tel" class="form-control" id="mobile" placeholder="شماره تماس خود را به فرمت 09123456789 وارد کنید.">
                                            </div>

                                            <div class="text-center mt-4">
                                                <button class="btn btn-success w-100" type="submit">ارسال لینک بازنشانی</button>
                                            </div>
                                        </form><!-- end form -->
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">صبر کن، رمز عبورم را به خاطر دارم...<a href="{{route('user.login')}}" class="fw-bold text-primary text-decoration-underline">اینجا را کلیک کنید</a> </p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
