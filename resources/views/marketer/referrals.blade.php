@extends('layouts.main')
@section('title', 'کاربران معرفی شده')
@section('content')
<div class="page-content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">کاربران معرفی شده</h2>
                    <p class="text-muted">لیست کامل کاربرانی که از طریق شما ثبت نام کرده‌اند</p>
                </div>
                <a href="{{ route('marketer.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    بازگشت به داشبورد
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 text-white">{{ $stats['total_clicks'] }}</h4>
                                    <p class="mb-0">کل کلیک‌های معرفی</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-mouse-pointer fa-2x opacity-75"></i>
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
                                    <h4 class="mb-0 text-white">{{ $stats['conversion_rate'] }}%</h4>
                                    <p class="mb-0">نرخ تبدیل</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referrals List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">لیست کاربران معرفی شده</h5>
                </div>
                <div class="card-body">
                    @if($referrals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>شناسه کاربر</th>
                                        <th>توکن معرفی</th>
                                        <th>IP بازدیدکننده</th>
                                        <th>User Agent</th>
                                        <th>تاریخ کلیک</th>
                                        <th>تاریخ ثبت نام</th>
                                        <th>فاصله زمانی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td><strong>#{{ $referral->referredUser->id }}</strong></td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $referral->referral_token }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $referral->visitor_ip }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($referral->user_agent, 50) }}</small>
                                            </td>
                                            <td>
                                                {{ \Morilog\Jalali\Jalalian::fromDateTime($referral->clicked_at)->format('Y/m/d H:i') }}
                                            </td>
                                            <td>
                                                @if($referral->registered_at)
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($referral->registered_at)->format('Y/m/d H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($referral->registered_at)
                                                    @php
                                                        $clickedAt = \Carbon\Carbon::parse($referral->clicked_at);
                                                        $registeredAt = \Carbon\Carbon::parse($referral->registered_at);
                                                        $diff = $clickedAt->diffForHumans($registeredAt, true);
                                                    @endphp
                                                    <span class="badge bg-success">{{ $diff }}</span>
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
