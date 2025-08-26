@extends('layouts.main')
@section('title', 'کمیسیون‌های من')
@section('content')
<div class="page-content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">کمیسیون‌های من</h2>
                    <p class="text-muted">لیست کامل کمیسیون‌های کسب شده از کاربران معرفی شده</p>
                </div>
                <a href="{{ route('marketer.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    بازگشت به داشبورد
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ number_format($stats['total_commissions']) }}</h4>
                                    <p class="mb-0">کل کمیسیون (تومان)</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ number_format($stats['pending_commissions']) }}</h4>
                                    <p class="mb-0">در انتظار (تومان)</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ number_format($stats['paid_commissions']) }}</h4>
                                    <p class="mb-0">پرداخت شده (تومان)</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['total_transactions'] }}</h4>
                                    <p class="mb-0">کل تراکنش‌ها</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commissions List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">لیست کمیسیون‌ها</h5>
                </div>
                <div class="card-body">
                    @if($commissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>شناسه کاربر</th>
                                        <th>مبلغ اصلی</th>
                                        <th>درصد کمیسیون</th>
                                        <th>کمیسیون</th>
                                        <th>وضعیت</th>
                                        <th>منبع</th>
                                        <th>تاریخ کسب</th>
                                        <th>تاریخ پرداخت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commissions as $commission)
                                        <tr>
                                            <td><strong>#{{ $commission->referredUser->id }}</strong></td>
                                            <td>{{ number_format($commission->original_amount) }} تومان</td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $commission->commission_percentage }}%</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($commission->commission_amount) }} تومان</strong>
                                            </td>
                                            <td>
                                                @if($commission->status === 'pending')
                                                    <span class="badge bg-warning">در انتظار</span>
                                                @elseif($commission->status === 'paid')
                                                    <span class="badge bg-success">پرداخت شده</span>
                                                @elseif($commission->status === 'cancelled')
                                                    <span class="badge bg-danger">لغو شده</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $commission->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($commission->commission_source === 'test_purchase')
                                                    <span class="badge bg-info">خرید آزمون</span>
                                                @elseif($commission->commission_source === 'wallet_charge')
                                                    <span class="badge bg-primary">شارژ کیف پول</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $commission->commission_source }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Morilog\Jalali\Jalalian::fromDateTime($commission->earned_at)->format('Y/m/d H:i') }}
                                            </td>
                                            <td>
                                                @if($commission->paid_at)
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($commission->paid_at)->format('Y/m/d H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $commissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">هنوز کمیسیونی کسب نکرده‌اید</h5>
                            <p class="text-muted">کمیسیون‌های شما در اینجا نمایش داده خواهند شد.</p>
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
