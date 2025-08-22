@extends('layouts.auth')
@section('content')
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
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
                                    <div>
                                        <h5 class="text-primary">برگشت خوش آمدید!</h5>
                                        <p class="text-muted">برای ادامه و دسترسی به پنل کاربری آدمک، وارد شوید.</p>
                                    </div>

                                    <div class="mt-4">
                                        <form action="{{route('user.login-process')}}" method="POST">
                                            @csrf
                                            @livewire('elements.login-opt-sender')
                                            <div class="mb-3">
                                                {{--<div class="float-end">
                                                    <a href="{{route('user.reset-password')}}" class="text-muted">رمز عبور را فراموش کرده اید؟</a>
                                                </div>--}}
                                                <label class="form-label" for="password-input">کد یکبار مصرف</label>
                                                <div class="position-relative mb-3">
                                                    <input name="opt_code" type="text" class="form-control pe-5 " placeholder="کد یکبار مصرف را وارد کنید" id="password-input">
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="auth_remember_check" name="auth_remember_check" id="auth_remember_check">
                                                <label class="form-check-label" for="auth_remember_check">مرا به خاطر بسپار</label>
                                            </div>

                                            @if ($errors->any())
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    <ul class="m-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif


                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">وارد شوید</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="fs-14 mb-4 title">وارد شوید با</h5>
                                                </div>

                                                <div>
                                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">حساب کاربری ندارید؟<a href="{{route('user.register')}}" class="fw-bold text-primary text-decoration-underline">ثبت نام کنید</a> </p>
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
