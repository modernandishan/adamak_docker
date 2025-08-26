@extends('layouts.main')
@section('title', 'جزئیات آزمون')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">جزئیات آزمون: {{ $attempt->test->title }}</h2>
                            <p class="text-muted">شناسه آزمون: #{{ $attempt->id }}</p>
                        </div>
                        <a href="{{ route('consultant.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            بازگشت به لیست
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- User Information -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        اطلاعات کاربر
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>نام و نام خانوادگی:</strong></div>
                                        <div class="col-sm-8">{{ $attempt->user->name }} {{ $attempt->user->family }}</div>
                                    </div>
                                    <hr>
                                    @if($attempt->user->profile)
                                        <div class="row">
                                            <div class="col-sm-4"><strong>استان:</strong></div>
                                            <div class="col-sm-8">{{ $attempt->user->profile->province ?? 'ثبت نشده' }}</div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4"><strong>کد ملی:</strong></div>
                                            <div class="col-sm-8">{{ $attempt->user->profile->national_code ?? 'ثبت نشده' }}</div>
                                        </div>
                                        <hr>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-4"><strong>تاریخ ثبت نام:</strong></div>
                                        <div class="col-sm-8"><strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->user->created_at)->format('Y/m/d H:i') }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Test Information -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-clipboard-list text-success me-2"></i>
                                        اطلاعات آزمون
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>عنوان آزمون:</strong></div>
                                        <div class="col-sm-8">{{ $attempt->test->title }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>تاریخ تخصیص:</strong></div>
                                        <div class="col-sm-8"><strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->assigned_at)->format('Y/m/d H:i') }}</strong></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>تاریخ شروع:</strong></div>
                                        <div class="col-sm-8">
                                            @if($attempt->started_at)
                                                <strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->started_at)->format('Y/m/d H:i') }}</strong>
                                            @else
                                                <span class="text-muted">شروع نشده</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>تاریخ تکمیل:</strong></div>
                                        <div class="col-sm-8">
                                            @if($attempt->completed_at)
                                                <strong class="text-success">{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->completed_at)->format('Y/m/d H:i') }}</strong>
                                            @else
                                                <span class="text-muted">تکمیل نشده</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Information -->
                    @if($attempt->family)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-users text-purple me-2"></i>
                                    اطلاعات خانواده
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <div class="col-sm-4"><strong>عنوان خانواده:</strong></div>
                                            <div class="col-sm-8">{{ $attempt->family->title }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4"><strong>نام پدر:</strong></div>
                                            <div class="col-sm-8">
                                                {{ $attempt->family->father_name }}
                                                @if($attempt->family->is_father_gone)
                                                    <span class="badge bg-danger ms-2">فوت شده</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4"><strong>نام مادر:</strong></div>
                                            <div class="col-sm-8">
                                                {{ $attempt->family->mother_name }}
                                                @if($attempt->family->is_mother_gone)
                                                    <span class="badge bg-danger ms-2">فوت شده</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($attempt->family->members)
                                        <div class="col-md-6">
                                            <strong>اعضای خانواده:</strong>
                                            <div class="mt-2">
                                                @foreach($attempt->family->members as $member)
                                                    <div class="border rounded p-2 mb-2 bg-light">
                                                        <strong>{{ $member['name'] ?? 'نامشخص' }}</strong>
                                                        @if(isset($member['relation']))
                                                            - <span class="text-muted">{{ $member['relation'] }}</span>
                                                        @endif
                                                        @if(isset($member['age']))
                                                            - <span class="text-muted">{{ $member['age'] }} سال</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- User Answers -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-question-circle text-warning me-2"></i>
                                پاسخ‌های کاربر
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($attempt->answers->count() > 0)
                                @foreach($attempt->test->questions->sortBy('sort_order') as $question)
                                    @php
                                        $answer = $attempt->answers->where('question_id', $question->id)->first();
                                    @endphp

                                    <div class="border rounded p-3 mb-3">
                                        <div class="mb-3">
                                            <h6 class="mb-1">{{ $question->title }}</h6>
                                            @if($question->description)
                                                <p class="text-muted small mb-2">{{ $question->description }}</p>
                                            @endif
                                            <span
                                                class="badge {{ $question->type === 'text' ? 'bg-primary' : 'bg-success' }}">
                                        {{ $question->type_name }}
                                    </span>
                                        </div>

                                        @if($answer)
                                            <div class="bg-light rounded p-3">
                                                <h6 class="text-dark mb-2">پاسخ کاربر:</h6>

                                                @if($question->type === 'text' && $answer->text_answer)
                                                    <div class="text-dark">
                                                        {!! nl2br(e($answer->text_answer)) !!}
                                                    </div>
                                                @elseif($question->type === 'upload' && $answer->file_path)
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file text-muted me-2"></i>
                                                        <a href="{{ asset('storage/' . $answer->file_path) }}"
                                                           target="_blank"
                                                           class="text-primary text-decoration-none">
                                                            مشاهده فایل
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="text-muted fst-italic mb-0">پاسخ ارائه نشده</p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="bg-warning bg-opacity-10 border border-warning rounded p-3">
                                                <p class="text-warning mb-0">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    کاربر به این سوال پاسخ نداده است
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">هنوز پاسخی ثبت نشده است</h5>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Consultant Response Form -->
                    @if($attempt->completed_at)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-reply text-info me-2"></i>
                                    ارسال پاسخ مشاوره
                                    @if($attempt->consultantResponse)
                                        <span class="badge bg-success ms-2">
                                ارسال شده در <strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->consultantResponse->sent_at)->format('Y/m/d H:i') }}</strong>
                            </span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('consultant.store-response', $attempt->id) }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="response_text" class="form-label">متن پاسخ مشاوره <span
                                                class="text-danger">*</span></label>
                                        <textarea name="response_text" id="response_text"
                                                  class="form-control @error('response_text') is-invalid @enderror"
                                                  rows="8"
                                                  required>{{ old('response_text', $attempt->consultantResponse?->response_text) }}</textarea>
                                        @error('response_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="recommendations" class="form-label">توصیه‌ها و راهکارها</label>
                                        <textarea name="recommendations" id="recommendations"
                                                  class="form-control @error('recommendations') is-invalid @enderror"
                                                  rows="4"
                                                  placeholder="توصیه‌های خاص برای این کاربر...">{{ old('recommendations', $attempt->consultantResponse?->recommendations) }}</textarea>
                                        @error('recommendations')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_urgent" id="is_urgent"
                                                   class="form-check-input" value="1"
                                                {{ old('is_urgent', $attempt->consultantResponse?->is_urgent) ? 'checked' : '' }}>
                                            <label for="is_urgent" class="form-check-label">
                                                نیاز به پیگیری فوری دارد
                                            </label>
                                            <div class="form-text">در صورت فعال بودن، این پاسخ به عنوان فوری علامت‌گذاری
                                                می‌شود
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            {{ $attempt->consultantResponse ? 'بروزرسانی پاسخ' : 'ارسال پاسخ' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>آزمون هنوز تکمیل نشده</strong><br>
                            تا زمانی که کاربر آزمون را تکمیل نکند، نمی‌توانید پاسخ مشاوره ارسال کنید.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .text-purple {
            color: #6f42c1 !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
