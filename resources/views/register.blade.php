@extends('layouts.auth')
@section('content')
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden m-0">
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

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <h5 class="text-primary">ثبت حساب</h5>
                                        <p class="text-muted">اکنون بصورت رایگان حساب آدمک خود را ایجاد کنید.</p>
                                    </div>

                                    <div class="mt-4">
                                        <form action="{{route('user.register-process')}}" method="POST">
                                            @csrf
                                            @if(request('ref'))
                                                <input type="hidden" name="ref" value="{{ request('ref') }}">
                                            @endif
                                            
                                            <div class="mb-3">
                                                <label for="name" class="form-label">نام<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                                       value="{{ old('name') }}" placeholder="نام خود را وارد کنید" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="family" class="form-label">نام خانوادگی<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('family') is-invalid @enderror" id="family" name="family" 
                                                       value="{{ old('family') }}" placeholder="نام خانوادگی خود را وارد کنید" required>
                                                @error('family')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            @livewire('elements.register-otp-sender')

                                            <div class="mb-3">
                                                <label class="form-label" for="opt_code">کد یکبار مصرف<span class="text-danger">*</span></label>
                                                <div class="position-relative mb-3">
                                                    <input name="opt_code" type="text" class="form-control @error('opt_code') is-invalid @enderror" 
                                                           placeholder="کد یکبار مصرف را وارد کنید" id="opt_code" required>
                                                    @error('opt_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <p class="mb-0 fs-13 text-muted fst-italic">درصورت ثبت نام با شرایط آدمک موافقت کرده اید: <a href="#" class="text-primary text-decoration-underline fst-normal fw-semibold">شرایط استفاده</a></p>
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
                                                <button class="btn btn-success w-100" type="submit">ثبت نام کنید</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="fs-14 mb-4 title text-muted">ایجاد حساب کاربری با</h5>
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
                                        <p class="mb-0">از قبل حساب کاربری دارید؟<a href="{{route('user.login')}}" class="fw-bold text-primary text-decoration-underline">وارد شوید</a> </p>
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