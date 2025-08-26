@extends('layouts.main')
@section('title', 'شارژ کیف پول | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-sm-0">
                            مدیریت کیف پول آدمک
                        </h1>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">داشبورد</a></li>
                                <li class="breadcrumb-item active">مدیریت کیف پول</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- ستون فرم شارژ -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0">شارژ کیف پول</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5>موجودی فعلی:
                                    <span class="badge bg-success fs-4">
                                        {{ number_format($wallet->balance) }} ریال
                                    </span>
                                </h5>
                            </div>

                            <form method="POST" action="{{ route('user.wallet.charge.submit') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label">مبلغ شارژ (تومان)</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="amount"
                                        name="amount"
                                        min="{{ \App\Services\PaymentGatewayService::getMinChargeAmount() }}"
                                        max="{{ \App\Services\PaymentGatewayService::getMaxChargeAmount() }}"
                                        required
                                        placeholder="حداقل {{ number_format(\App\Services\PaymentGatewayService::getMinChargeAmount()) }} تومان"
                                    >
                                    <div class="form-text">مبلغ را به تومان وارد کنید (حداقل: {{ number_format(\App\Services\PaymentGatewayService::getMinChargeAmount()) }} تومان - حداکثر: {{ number_format(\App\Services\PaymentGatewayService::getMaxChargeAmount()) }} تومان)</div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-wallet-line me-2"></i>
                                    پرداخت و شارژ کیف پول
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ستون تاریخچه تراکنش‌ها -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4 class="card-title mb-0">تاریخچه تراکنش‌ها</h4>
                        </div>
                        <div class="card-body">
                            @if($transactions->isEmpty())
                                <div class="alert alert-info text-center">
                                    هیچ تراکنشی ثبت نشده است.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>مبلغ (تومان)</th>
                                            <th>نوع</th>
                                            <th>وضعیت</th>
                                            <th>زمان</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ number_format($transaction->amount) }}</td>
                                                <td>
                                                    @if($transaction->type === 'charge')
                                                        <span class="badge bg-success">شارژ</span>
                                                    @else
                                                        <span class="badge bg-warning">برداشت</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->status === 'completed')
                                                        <span class="badge bg-success">موفق</span>
                                                    @elseif($transaction->status === 'pending')
                                                        <span class="badge bg-secondary">در انتظار</span>
                                                    @else
                                                        <span class="badge bg-danger">ناموفق</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->created_at->format('Y/m/d H:i') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $transactions->links() }}
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
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            height: 100%;
        }
        .card-header {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            padding: 1.2rem 1.5rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            height: 48px;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            background-color: #3b7ddd;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #2f68b7;
            transform: translateY(-2px);
        }
        .badge {
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(59, 125, 221, 0.05);
        }
        .alert {
            border-radius: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // اعتبارسنجی سمت کلاینت
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const amountInput = document.getElementById('amount');
                if (amountInput.value < 1000) {
                    e.preventDefault();
                    alert('حداقل مبلغ شارژ 1000 ریال می‌باشد');
                }
            });

            // اتوماتیک انتخاب کردن مقدار ورودی هنگام کلیک
            amountInput.addEventListener('click', function() {
                this.select();
            });
        });
    </script>
@endpush
