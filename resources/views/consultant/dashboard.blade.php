@extends('layouts.main')
@section('title', 'داشبورد مشاور')
@section('content')
<div class="page-content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">داشبورد مشاور</h2>
                    <p class="text-muted">آزمون‌های اختصاص یافته به شما</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    بازگشت به داشبورد کاربری
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['total'] }}</h4>
                                    <p class="mb-0">کل آزمون‌ها</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clipboard-list fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['pending'] }}</h4>
                                    <p class="mb-0">در انتظار بررسی</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['completed'] }}</h4>
                                    <p class="mb-0">تکمیل شده</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tests List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">آزمون‌های اختصاص یافته</h5>
                </div>
                <div class="card-body">
                    @if($attempts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>کاربر</th>
                                        <th>آزمون</th>
                                        <th>وضعیت</th>
                                        <th>خانواده</th>
                                        <th>تاریخ تخصیص</th>
                                        <th>تاریخ تکمیل</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attempts as $attempt)
                                        <tr>
                                            <td><strong>#{{ $attempt->id }}</strong></td>
                                            <td>
                                                <div>
                                                    <strong>{{ $attempt->user->name }} {{ $attempt->user->family }}</strong>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $attempt->test->title }}</span>
                                            </td>
                                            <td>
                                                @if(!$attempt->started_at)
                                                    <span class="badge bg-secondary">تخصیص یافته</span>
                                                @elseif(!$attempt->completed_at)
                                                    <span class="badge bg-primary">در حال انجام</span>
                                                @else
                                                    <span class="badge bg-success">تکمیل شده</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attempt->family)
                                                    <span class="badge bg-info">{{ $attempt->family->title }}</span>
                                                @else
                                                    <span class="badge bg-light text-dark">بدون خانواده</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->assigned_at)->format('Y/m/d H:i') }}</strong>
                                            </td>
                                            <td>
                                                @if($attempt->completed_at)
                                                    <strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($attempt->completed_at)->format('Y/m/d H:i') }}</strong>
                                                @else
                                                    <small class="text-muted">تکمیل نشده</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('consultant.test-details', $attempt->id) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    مشاهده جزئیات
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $attempts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">هنوز آزمونی به شما اختصاص داده نشده است</h5>
                            <p class="text-muted">آزمون‌های اختصاص یافته در اینجا نمایش داده خواهند شد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endpush
