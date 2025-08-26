@extends('layouts.main')
@section('title', 'داشبورد بازاریاب')
@section('content')
<div class="page-content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">داشبورد بازاریاب</h2>
                    <p class="text-muted">کاربران معرفی شده و کمیسیون‌های شما</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    بازگشت به داشبورد کاربری
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['total_referrals'] }}</h4>
                                    <p class="mb-0">کل کاربران معرفی شده</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <p class="mb-0">کمیسیون در انتظار (تومان)</p>
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
                                    <p class="mb-0">کمیسیون پرداخت شده (تومان)</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referrals List -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">کاربران معرفی شده</h5>
                    <a href="{{ route('marketer.referrals') }}" class="btn btn-sm btn-primary">مشاهده همه</a>
                </div>
                <div class="card-body">
                    @if($referrals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>شناسه کاربر</th>
                                        <th>تاریخ ثبت نام</th>
                                        <th>تاریخ کلیک</th>
                                        <th>IP بازدیدکننده</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td><strong>#{{ $referral->referredUser->id }}</strong></td>
                                            <td>
                                                @if($referral->registered_at)
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($referral->registered_at)->format('Y/m/d H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Morilog\Jalali\Jalalian::fromDateTime($referral->clicked_at)->format('Y/m/d H:i') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $referral->visitor_ip }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $referrals->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">هنوز کاربری از طریق شما ثبت نام نکرده است</h5>
                            <p class="text-muted">کاربران معرفی شده در اینجا نمایش داده خواهند شد.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Commissions List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">کمیسیون‌های اخیر</h5>
                    <a href="{{ route('marketer.commissions') }}" class="btn btn-sm btn-primary">مشاهده همه</a>
                </div>
                <div class="card-body">
                    @if($commissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>شناسه کاربر</th>
                                        <th>مبلغ اصلی</th>
                                        <th>کمیسیون</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ کسب</th>
                                        <th>منبع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commissions as $commission)
                                        <tr>
                                            <td><strong>#{{ $commission->referredUser->id }}</strong></td>
                                            <td>{{ number_format($commission->original_amount) }} تومان</td>
                                            <td>
                                                <strong class="text-success">{{ number_format($commission->commission_amount) }} تومان</strong>
                                            </td>
                                            <td>
                                                @if($commission->status === 'pending')
                                                    <span class="badge bg-warning">در انتظار</span>
                                                @elseif($commission->status === 'paid')
                                                    <span class="badge bg-success">پرداخت شده</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $commission->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Morilog\Jalali\Jalalian::fromDateTime($commission->earned_at)->format('Y/m/d H:i') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $commission->commission_source }}</span>
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
