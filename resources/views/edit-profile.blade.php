@extends('layouts.main')
@section('title', 'پنل کاربری | آدمک')
@push('scripts')
    <!-- profile-setting init js -->
    <script src="../../assets/js/pages/profile-setting.init.js"></script>
    <script src="../../assets/libs/@JalaliDatePicker/dist/jalalidatepicker.min.js"></script>
    <script>
        jalaliDatepicker.startWatch({ time: true });
        
        // Ensure Bootstrap tabs work properly
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs
            var tabTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
            tabTriggerList.forEach(function(tabTriggerEl) {
                new bootstrap.Tab(tabTriggerEl);
            });
            
            // Handle tab switching
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tabEl) {
                tabEl.addEventListener('click', function(e) {
                    e.preventDefault();
                    var tab = new bootstrap.Tab(this);
                    tab.show();
                });
            });
        });
    </script>
@endpush
@push('styles')
    <!-- Css:Persian Datepicker -->
    <link rel="stylesheet" href="../../assets/libs/@JalaliDatePicker/dist/jalalidatepicker.min.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="../../assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
                    {{--<div class="overlay-content">
                        <div class="text-end p-3">
                            <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                    <i class="ri-image-edit-line align-bottom me-1"></i>تغییر جلد</label>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3">
                    @livewire('elements.avatar-update')
                    @livewire('elements.profile-progress')
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                        <i class="fas fa-home"></i>جزئیات شخصی</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    @if(auth()->user()->hasRole('consultant'))
                                        <a class="nav-link text-success" data-bs-toggle="tab" href="#consultant" role="tab" aria-selected="false" tabindex="-1">
                                            <i class="fas fa-user-tie"></i>بیوگرافی مشاور</a>
                                    @else
                                        <a class="nav-link" data-bs-toggle="tab" href="#consultant" role="tab" aria-selected="false" tabindex="-1">
                                            <i class="fas fa-user-tie"></i>بیوگرافی مشاور</a>
                                    @endif
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#marketer" role="tab" aria-selected="false" tabindex="-1">
                                        <i class="fas fa-bullhorn"></i>اطلاعات بازاریاب</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab" aria-selected="false" tabindex="-1">
                                        <i class="far fa-envelope"></i>سیاست حفظ حریم خصوصی</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                                    <form action="{{route('user.profile.update')}}" method="POST">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-warning mt-4" role="alert">
                                                <ul class="m-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">نام</label>
                                                    <input type="text" class="form-control" id="firstnameInput" name="name" placeholder="نام کوچک خود را وارد کنید" value="{{$user->name}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">نام خانوادگی</label>
                                                    <input type="text" class="form-control" id="lastnameInput" name="family" placeholder="نام خانوادگی خود را وارد کنید" value="{{$user->family}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput" class="form-label">شماره تلفن</label>
                                                    <input disabled type="tel" class="form-control" id="phonenumberInput" placeholder="شماره تلفن خود را وارد کنید" value="{{$user->mobile}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="JoiningdatInput" class="form-label">تاریخ عضویت</label>
                                                    <input id="JoiningdatInput" disabled data-jdp type="text" class="form-control"  data-jdp-only-date value="{{$created_at}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="designationInput" class="form-label">کدملی</label>
                                                    <input type="text" class="form-control" id="designationInput" name="national_code" placeholder="کدملی یکتای شما" value="{{$user->profile->national_code}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="websiteInput1" class="form-label">کدپستی</label>
                                                    <input type="text" class="form-control" id="websiteInput1" name="postal_code" placeholder="کدپستی محل سکونت" value="{{$user->profile->postal_code}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="cityInput" class="form-label">استان</label>
                                                    <input name="province" type="text" class="form-control" id="cityInput" placeholder="استان محل سکونت" value="{{$user->profile->province}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">تایخ تولد</label>
                                                    <input id="JoiningdatInput" name="birth" data-jdp type="text" class="form-control" placeholder="--/--/----" data-jdp-only-date value="{{$birth_date}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <label for="exampleFormControlTextarea" class="form-label">نشانی کد پستی</label>
                                                    <textarea name="address" class="form-control" id="exampleFormControlTextarea" placeholder="آدرس محل سکونت خود را وارد کنید" rows="3">{{$user->profile->address}}</textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">ذخیره شود</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="consultant" role="tabpanel">
                                    @if(auth()->user()->hasRole('consultant'))
                                        <!-- فرم بیوگرافی مشاور -->
                                        <div class="mb-4 pb-2">
                                            <h5 class="card-title text-decoration-underline mb-3 text-success">بیوگرافی مشاور</h5>
                                        </div>
                                        
                                        <form action="{{ url('/user/consultant/biography/update') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            @if(session('biography_success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('biography_success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
                                            
                                            @if ($errors->any() && !$errors->has('consultant') && !$errors->has('marketer'))
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    <ul class="m-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <!-- عنوان شغلی -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">عنوان شغلی *</label>
                                                        <input type="text" class="form-control @error('professional_title') is-invalid @enderror"
                                                               name="professional_title" 
                                                               placeholder="مثال: روانشناس بالینی، مشاور خانواده"
                                                               value="{{ old('professional_title', $consultantBio?->professional_title ?? '') }}" required>
                                                        @error('professional_title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- تلفن تماس -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">تلفن تماس</label>
                                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                               name="phone" 
                                                               placeholder="شماره تلفن برای تماس مراجعان"
                                                               value="{{ old('phone', $consultantBio?->phone ?? '') }}">
                                                        @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- بیوگرافی اصلی -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">بیوگرافی و معرفی *</label>
                                                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror"
                                                                  rows="4" 
                                                                  placeholder="معرفی کامل خود، تجربیات، رویکرد کاری و نحوه کمک به مراجعان را شرح دهید..."
                                                                  required>{{ old('bio', $consultantBio?->bio ?? '') }}</textarea>
                                                        @error('bio')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- تخصص‌ها -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">حوزه‌های تخصصی</label>
                                                        <input type="text" class="form-control @error('specialties_input') is-invalid @enderror"
                                                               name="specialties_input" 
                                                               placeholder="مثال: مشاوره ازدواج، روانشناسی کودک، مدیریت استرس"
                                                               value="{{ old('specialties_input', is_array($consultantBio?->specialties ?? []) ? implode('، ', $consultantBio?->specialties ?? []) : '') }}">
                                                        <small class="text-muted">حوزه‌های تخصصی خود را با کاما از هم جدا کنید</small>
                                                        @error('specialties_input')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- زبان‌ها -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">زبان‌های مکالمه</label>
                                                        <input type="text" class="form-control @error('languages_input') is-invalid @enderror"
                                                               name="languages_input" 
                                                               placeholder="مثال: فارسی، انگلیسی، عربی"
                                                               value="{{ old('languages_input', is_array($consultantBio?->languages ?? []) ? implode('، ', $consultantBio?->languages ?? []) : '') }}">
                                                        <small class="text-muted">زبان‌هایی که به آن مشاوره می‌دهید را با کاما جدا کنید</small>
                                                        @error('languages_input')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- روش‌های مشاوره -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">روش‌های ارائه مشاوره</label>
                                                        <div class="form-check-container">
                                                            @php
                                                                $consultationMethods = old('consultation_methods', $consultantBio?->consultation_methods ?? []);
                                                                if (!is_array($consultationMethods)) {
                                                                    $consultationMethods = [];
                                                                }
                                                            @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="consultation_methods[]" value="حضوری" id="in_person" {{ in_array('حضوری', $consultationMethods) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="in_person">حضوری</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="consultation_methods[]" value="آنلاین" id="online" {{ in_array('آنلاین', $consultationMethods) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="online">آنلاین (ویدئو کال)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="consultation_methods[]" value="تلفنی" id="phone_consult" {{ in_array('تلفنی', $consultationMethods) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="phone_consult">تلفنی</label>
                                                            </div>
                                                        </div>
                                                        @error('consultation_methods')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- درصد کمیسیون آزمون -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">درصد کمیسیون آزمون</label>
                                                        <input disabled type="number" class="form-control @error('test_commission_percentage') is-invalid @enderror"
                                                               name="test_commission_percentage" 
                                                               placeholder="50"
                                                               min="0" max="100" step="0.01"
                                                               value="{{ old('test_commission_percentage', $consultantBio?->test_commission_percentage ?? 50) }}">
                                                        <small class="form-text text-muted">درصدی از هزینه آزمون که به شما تعلق می‌گیرد (پیش‌فرض: 50%)</small>
                                                        @error('test_commission_percentage')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- خدمات ارائه شده -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">خدمات ارائه شده</label>
                                                        <textarea name="services_offered" class="form-control @error('services_offered') is-invalid @enderror"
                                                                  rows="3" 
                                                                  placeholder="انواع خدمات مشاوره‌ای که ارائه می‌دهید را توضیح دهید...">{{ old('services_offered', $consultantBio?->services_offered ?? '') }}</textarea>
                                                        @error('services_offered')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- رویکرد کاری -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">رویکرد مشاوره</label>
                                                        <textarea name="approach" class="form-control @error('approach') is-invalid @enderror"
                                                                  rows="3" 
                                                                  placeholder="رویکرد و متدولوژی کاری خود را شرح دهید...">{{ old('approach', $consultantBio?->approach ?? '') }}</textarea>
                                                        @error('approach')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- ایمیل تماس -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">ایمیل تماس</label>
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                               name="email" 
                                                               placeholder="ایمیل برای تماس مراجعان"
                                                               value="{{ old('email', $consultantBio?->email ?? '') }}">
                                                        @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- وب‌سایت -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">وب‌سایت شخصی</label>
                                                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                                                               name="website" 
                                                               placeholder="https://your-website.com"
                                                               value="{{ old('website', $consultantBio?->website ?? '') }}">
                                                        @error('website')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- دستاورها -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">دستاورها و افتخارات</label>
                                                        <textarea name="achievements" class="form-control @error('achievements') is-invalid @enderror"
                                                                  rows="2" 
                                                                  placeholder="جوایز، گواهینامه‌ها، انتشارات علمی و سایر دستاوردها...">{{ old('achievements', $consultantBio?->achievements ?? '') }}</textarea>
                                                        @error('achievements')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- نمایش عمومی -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_public" value="1" id="is_public" 
                                                                   {{ old('is_public', $consultantBio?->is_public ?? true) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="is_public">
                                                                نمایش عمومی پروفایل مشاور
                                                            </label>
                                                            <small class="form-text text-muted d-block">در صورت فعال بودن، پروفایل شما در لیست مشاوران سایت نمایش داده خواهد شد</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- دکمه ذخیره -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-success">ذخیره بیوگرافی</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <!-- درخواست مشاوره -->
                                        <div class="mb-4 pb-2">
                                            <h5 class="card-title text-decoration-underline mb-3">آیا شما یک مشاور متخصص هستید؟</h5>
                                        </div>
                                        
                                        <form action="{{ route('user.form-submissions.consultant') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- نمایش خطای عمومی (برای درخواست‌های تکراری) -->
                                            @if ($errors->has('consultant'))
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    {{ $errors->first('consultant') }}
                                                </div>
                                            @endif

                                            <!-- نمایش پیام موفقیت -->
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <!-- نمایش خطاهای اعتبارسنجی -->
                                            @if ($errors->any() && !$errors->has('consultant'))
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    <ul class="m-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <!-- زمینه تخصصی -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">زمینه تخصصی مشاوره</label>
                                                        <select class="form-select @error('field_of_expertise') is-invalid @enderror" name="field_of_expertise" required>
                                                            <option value="" selected disabled>انتخاب کنید</option>
                                                            <option value="روانشناسی" {{ old('field_of_expertise') == 'روانشناسی' ? 'selected' : '' }}>روانشناسی</option>
                                                            <option value="مالی و سرمایه‌گذاری" {{ old('field_of_expertise') == 'مالی و سرمایه‌گذاری' ? 'selected' : '' }}>مالی و سرمایه‌گذاری</option>
                                                            <option value="تحصیلی و آموزشی" {{ old('field_of_expertise') == 'تحصیلی و آموزشی' ? 'selected' : '' }}>تحصیلی و آموزشی</option>
                                                            <option value="شغلی و حرفه‌ای" {{ old('field_of_expertise') == 'شغلی و حرفه‌ای' ? 'selected' : '' }}>شغلی و حرفه‌ای</option>
                                                            <option value="خانواده و ازدواج" {{ old('field_of_expertise') == 'خانواده و ازدواج' ? 'selected' : '' }}>خانواده و ازدواج</option>
                                                            <option value="سلامت و تغذیه" {{ old('field_of_expertise') == 'سلامت و تغذیه' ? 'selected' : '' }}>سلامت و تغذیه</option>
                                                        </select>
                                                        @error('field_of_expertise')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- مدرک تحصیلی -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">مدرک تحصیلی</label>
                                                        <select class="form-select @error('degree') is-invalid @enderror" name="degree" required>
                                                            <option value="" selected disabled>انتخاب کنید</option>
                                                            <option value="دیپلم" {{ old('degree') == 'دیپلم' ? 'selected' : '' }}>دیپلم</option>
                                                            <option value="کارشناسی" {{ old('degree') == 'کارشناسی' ? 'selected' : '' }}>کارشناسی</option>
                                                            <option value="کارشناسی ارشد" {{ old('degree') == 'کارشناسی ارشد' ? 'selected' : '' }}>کارشناسی ارشد</option>
                                                            <option value="دکتری" {{ old('degree') == 'دکتری' ? 'selected' : '' }}>دکتری</option>
                                                            <option value="فوق دکتری" {{ old('degree') == 'فوق دکتری' ? 'selected' : '' }}>فوق دکتری</option>
                                                        </select>
                                                        @error('degree')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- سابقه کار -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">سابقه کار مرتبط (سال)</label>
                                                        <input type="number" class="form-control @error('work_experience') is-invalid @enderror"
                                                               name="work_experience" placeholder="تعداد سال سابقه کار"
                                                               min="0" max="50" value="{{ old('work_experience') }}" required>
                                                        @error('work_experience')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- مدارک و گواهینامه‌ها -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">مدارک و گواهینامه‌ها (اختیاری)</label>
                                                        <input type="text" class="form-control @error('certificates') is-invalid @enderror"
                                                               name="certificates" placeholder="مدارک خود را با کاما جدا کنید"
                                                               value="{{ old('certificates') }}">
                                                        @error('certificates')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- رزومه -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">رزومه (PDF, Word)</label>
                                                        <input type="file" class="form-control @error('resume') is-invalid @enderror"
                                                               name="resume" accept=".pdf,.doc,.docx">
                                                        @error('resume')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="form-text text-muted">حداکثر حجم فایل: 2MB</small>
                                                    </div>
                                                </div>

                                                <!-- توضیحات -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3 pb-2">
                                                        <label class="form-label">توضیحات بیشتر درباره تخصص و تجربیات</label>
                                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                                                  rows="4" placeholder="تجربیات، مهارت‌ها و توضیحات مرتبط" required>{{ old('description') }}</textarea>
                                                        @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- دکمه ارسال -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">ارسال درخواست مشاوره</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="marketer" role="tabpanel">
                                    <div class="mb-4 pb-2">
                                        <h5 class="card-title text-decoration-underline mb-3">آیا شما یک بازاریاب متخصص هستید؟</h5>
                                        <form action="{{ route('user.form-submissions.marketer') }}" method="POST">
                                            @csrf

                                            <!-- نمایش خطای عمومی (برای درخواست‌های تکراری) -->
                                            @if ($errors->has('marketer'))
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    {{ $errors->first('marketer') }}
                                                </div>
                                            @endif

                                            <!-- نمایش پیام موفقیت -->
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <!-- نمایش خطاهای اعتبارسنجی -->
                                            @if ($errors->any() && !$errors->has('marketer'))
                                                <div class="alert alert-warning mt-4" role="alert">
                                                    <ul class="m-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <!-- تجربه بازاریابی -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">نوع تجربه بازاریابی</label>
                                                        <select class="form-select @error('marketing_experience') is-invalid @enderror" name="marketing_experience" required>
                                                            <option value="" selected disabled>انتخاب کنید</option>
                                                            <option value="دیجیتال مارکتینگ" {{ old('marketing_experience') == 'دیجیتال مارکتینگ' ? 'selected' : '' }}>دیجیتال مارکتینگ</option>
                                                            <option value="بازاریابی شبکه‌های اجتماعی" {{ old('marketing_experience') == 'بازاریابی شبکه‌های اجتماعی' ? 'selected' : '' }}>بازاریابی شبکه‌های اجتماعی</option>
                                                            <option value="بازاریابی محتوا" {{ old('marketing_experience') == 'بازاریابی محتوا' ? 'selected' : '' }}>بازاریابی محتوا</option>
                                                            <option value="تبلیغات آنلاین" {{ old('marketing_experience') == 'تبلیغات آنلاین' ? 'selected' : '' }}>تبلیغات آنلاین</option>
                                                            <option value="SEO و بهینه‌سازی موتور جستجو" {{ old('marketing_experience') == 'SEO و بهینه‌سازی موتور جستجو' ? 'selected' : '' }}>SEO و بهینه‌سازی موتور جستجو</option>
                                                            <option value="بازاریابی ایمیلی" {{ old('marketing_experience') == 'بازاریابی ایمیلی' ? 'selected' : '' }}>بازاریابی ایمیلی</option>
                                                            <option value="بازاریابی وابسته" {{ old('marketing_experience') == 'بازاریابی وابسته' ? 'selected' : '' }}>بازاریابی وابسته (Affiliate Marketing)</option>
                                                        </select>
                                                        @error('marketing_experience')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- پلتفرم‌های بازاریابی -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">پلتفرم‌های تبلیغاتی (حداقل یک گزینه انتخاب کنید)</label>
                                                        <div class="form-check-container">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="اینستاگرام" id="instagram" {{ in_array('اینستاگرام', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="instagram">اینستاگرام</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="تلگرام" id="telegram" {{ in_array('تلگرام', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="telegram">تلگرام</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="گوگل ادز" id="google_ads" {{ in_array('گوگل ادز', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="google_ads">گوگل ادز</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="فیسبوک" id="facebook" {{ in_array('فیسبوک', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="facebook">فیسبوک</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="یوتیوب" id="youtube" {{ in_array('یوتیوب', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="youtube">یوتیوب</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="platforms[]" value="لینکدین" id="linkedin" {{ in_array('لینکدین', old('platforms', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="linkedin">لینکدین</label>
                                                            </div>
                                                        </div>
                                                        @error('platforms')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- سابقه کار -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">سابقه کار بازاریابی (سال)</label>
                                                        <input type="number" class="form-control @error('work_experience') is-invalid @enderror"
                                                               name="work_experience" placeholder="تعداد سال سابقه کار"
                                                               min="0" max="50" value="{{ old('work_experience') }}" required>
                                                        @error('work_experience')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- لینک نمونه کار -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">لینک نمونه کار یا پورتفولیو (اختیاری)</label>
                                                        <input type="url" class="form-control @error('portfolio_url') is-invalid @enderror"
                                                               name="portfolio_url" placeholder="https://example.com/portfolio"
                                                               value="{{ old('portfolio_url') }}">
                                                        @error('portfolio_url')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- مهارت‌های بازاریابی -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">مهارت‌های بازاریابی (اختیاری)</label>
                                                        <input type="text" class="form-control @error('marketing_skills') is-invalid @enderror"
                                                               name="marketing_skills" placeholder="مثال: Google Analytics، Facebook Ads Manager، Photoshop"
                                                               value="{{ old('marketing_skills') }}">
                                                        @error('marketing_skills')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- توضیحات -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3 pb-2">
                                                        <label class="form-label">توضیحات بیشتر درباره تجربیات و سابقه بازاریابی</label>
                                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                                                  rows="4" placeholder="تجربیات، پروژه‌های انجام شده، و توضیحات مرتبط" required>{{ old('description') }}</textarea>
                                                        @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- دکمه ارسال -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">ارسال درخواست بازاریابی</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="privacy" role="tabpanel">
                                    <div class="mb-4 pb-2">
                                        <h5 class="card-title text-decoration-underline mb-3">امنیت:</h5>
                                        <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                            <div class="flex-grow-1">
                                                <h6 class="fs-15 mb-1">احراز هویت دو مرحله ای</h6>
                                                <p class="text-muted">احراز هویت دو مرحله ای یک ابزار امنیتی پیشرفته است. پس از فعال شدن، هنگام ورود به Google Authentication و SMS پشتیبانی می شود، باید دو نوع شناسایی ارائه دهید.</p>
                                            </div>
                                            <div class="flex-shrink-0 ms-sm-3">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary">احراز هویت دو مرحله ای را فعال کنید</a>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                            <div class="flex-grow-1">
                                                <h6 class="fs-15 mb-1">تأیید ثانویه</h6>
                                                <p class="text-muted">عامل اول رمز عبور است و عامل دوم معمولاً شامل متنی با کدی است که به تلفن هوشمند شما ارسال می شود یا بیومتریک با استفاده از اثر انگشت، صورت یا شبکیه چشم شما.</p>
                                            </div>
                                            <div class="flex-shrink-0 ms-sm-3">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary">راه اندازی روش ثانویه</a>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                            <div class="flex-grow-1">
                                                <h6 class="fs-15 mb-1">کدهای پشتیبان</h6>
                                                <p class="text-muted mb-sm-0">هنگامی که احراز هویت دو مرحله ای را از طریق برنامه توییتر iOS یا Android خود روشن می کنید، یک کد پشتیبان به طور خودکار برای شما ایجاد می شود. همچنین می توانید یک کد پشتیبان در twitter.com ایجاد کنید.</p>
                                            </div>
                                            <div class="flex-shrink-0 ms-sm-3">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary">کدهای پشتیبان تولید کنید</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h5 class="card-title text-decoration-underline mb-3">اطلاعیه های برنامه:</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex">
                                                <div class="flex-grow-1">
                                                    <label for="directMessage" class="form-check-label fs-14">پیام های مستقیم</label>
                                                    <p class="text-muted">پیام های افرادی که دنبال می کنید</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="directMessage" checked="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mt-2">
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label fs-15" for="desktopNotification">نمایش اعلان های دسکتاپ</label>
                                                    <p class="text-muted">گزینه ای را که می خواهید به عنوان تنظیمات پیش فرض خود انتخاب کنید. مسدود کردن یک سایت: در کنار «مجاز برای ارسال اعلان‌ها نیست»، روی «افزودن» کلیک کنید.</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="desktopNotification" checked="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mt-2">
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label fs-15" for="emailNotification">نمایش اعلان های ایمیل</label>
                                                    <p class="text-muted">در قسمت تنظیمات، اعلان‌ها را انتخاب کنید. در بخش انتخاب حساب، حسابی را برای فعال کردن اعلان‌ها انتخاب کنید.</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="emailNotification">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mt-2">
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label fs-15" for="chatNotification">نمایش اعلان های چت</label>
                                                    <p class="text-muted">برای جلوگیری از اعلان‌های تکراری تلفن همراه از برنامه‌های Gmail و Chat، در تنظیمات، اعلان‌های گپ را خاموش کنید.</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="chatNotification">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mt-2">
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label fs-15" for="purchaesNotification">نمایش اعلان‌های خرید</label>
                                                    <p class="text-muted">برای محافظت از خود در برابر هزینه‌های جعلی، هشدارهای خرید بی‌درنگ دریافت کنید.</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="purchaesNotification">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-decoration-underline mb-3">حذف این اکانت:</h5>
                                        <p class="text-muted">به بخش داده و حریم خصوصی حساب پروفایل خود بروید. به «گزینه‌های داده‌ها و حریم خصوصی شما» بروید. اکانت پروفایل خود را حذف کنید برای حذف حساب خود دستورالعمل ها را دنبال کنید:</p>
                                        <div>
                                            <input type="password" class="form-control" id="passwordInput" placeholder="رمز عبور خود را وارد کنید" value="make@321654987" style="max-width: 265px;">
                                        </div>
                                        <div class="hstack gap-2 mt-3">
                                            <a href="javascript:void(0);" class="btn btn-soft-danger">بستن و حذف این حساب</a>
                                            <a href="javascript:void(0);" class="btn btn-light">لغو کنید</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
