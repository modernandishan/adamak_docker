@extends('layouts.main')
@section('title','مدیریت خانواده‌ها | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-sm-0">مدیریت خانواده‌ها</h1>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">داشبورد</a></li>
                                <li class="breadcrumb-item active">خانواده‌ها</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">لیست خانواده‌های شما</h4>
                                <a href="{{ route('user.family.add') }}" class="btn btn-primary">
                                    <i class="ri-add-line align-middle me-1"></i> افزودن خانواده جدید
                                </a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>عنوان خانواده</th>
                                        <th>نام پدر</th>
                                        <th>نام مادر</th>
                                        <th>تعداد اعضا</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($families as $index => $family)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $family->title }}</td>
                                            <td>
                                                {{ $family->father_name ?? '-' }}
                                                @if($family->is_father_gone)
                                                    <span class="badge bg-danger">فوت کرده</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $family->mother_name ?? '-' }}
                                                @if($family->is_mother_gone)
                                                    <span class="badge bg-danger">فوت کرده</span>
                                                @endif
                                            </td>
                                            <td>{{ count($family->members) }}</td>
                                            <td>{{ jdate($family->created_at)->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('user.family.edit', $family->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="ri-edit-line"></i> ویرایش
                                                    </a>
                                                    <form action="{{ route('user.family.delete', $family->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این خانواده مطمئن هستید؟')">
                                                            <i class="ri-delete-bin-line"></i> حذف
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">هیچ خانواده‌ای ثبت نشده است</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($families->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $families->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // نمایش تاییدیه قبل از حذف
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('form[action*="delete"]');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: "پس از حذف، امکان بازیابی وجود ندارد!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'بله، حذف شود',
                        cancelButtonText: 'انصراف'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
