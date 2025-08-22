@extends('layouts.main')
@section('title','تعریف خانواده جدید | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-sm-0">تعریف خانواده جدید</h1>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">داشبورد</a></li>
                                <li class="breadcrumb-item active">تعریف خانواده جدید</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.family.create') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="title" class="form-label">عنوان خانواده <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    <small class="form-text text-muted">مثال: خانواده قانع دستجردی</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">نام پدر</label>
                                            <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mother_name" class="form-label">نام مادر</label>
                                            <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_father_gone" name="is_father_gone" value="1" {{ old('is_father_gone') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_father_gone">پدر فوت کرده است</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_mother_gone" name="is_mother_gone" value="1" {{ old('is_mother_gone') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_mother_gone">مادر فوت کرده است</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3">اعضای خانواده <span class="text-danger">*</span></h5>

                                    <div id="members-container">
                                        @php $memberIndex = old('members') ? count(old('members')) : 1; @endphp
                                        @for ($i = 0; $i < $memberIndex; $i++)
                                            <div class="card border mb-3 member-item">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-danger btn-sm float-end remove-member" {{ $i === 0 ? 'disabled' : '' }}>&times;</button>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">نقش در خانواده</label>
                                                                <input type="text" class="form-control" name="members[{{ $i }}][role]" value="{{ old("members.$i.role") }}" required>
                                                                <small class="form-text text-muted">مثال: پدر، مادر، فرزند اول</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">سن</label>
                                                                <input type="number" class="form-control" name="members[{{ $i }}][age]" min="1" max="120" value="{{ old("members.$i.age") }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">جنسیت</label>
                                                                <select class="form-select" name="members[{{ $i }}][gender]" required>
                                                                    <option value="male" {{ old("members.$i.gender") == 'male' ? 'selected' : '' }}>مرد</option>
                                                                    <option value="female" {{ old("members.$i.gender") == 'female' ? 'selected' : '' }}>زن</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                    <button type="button" id="add-member" class="btn btn-outline-primary btn-sm">
                                        <i class="ri-user-add-line align-middle me-1"></i> افزودن عضو جدید
                                    </button>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary px-4">ذخیره خانواده</button>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-light px-4">انصراف</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // افزودن عضو جدید
            document.getElementById('add-member').addEventListener('click', function() {
                const container = document.getElementById('members-container');
                const index = container.children.length;
                const memberItem = document.createElement('div');
                memberItem.className = 'card border mb-3 member-item';
                memberItem.innerHTML = `
                <div class="card-body">
                    <button type="button" class="btn btn-danger btn-sm float-end remove-member">&times;</button>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">نقش در خانواده</label>
                                <input type="text" class="form-control" name="members[${index}][role]" required>
                                <small class="form-text text-muted">مثال: پدر، مادر، فرزند اول</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">سن</label>
                                <input type="number" class="form-control" name="members[${index}][age]" min="1" max="120" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">جنسیت</label>
                                <select class="form-select" name="members[${index}][gender]" required>
                                    <option value="male">مرد</option>
                                    <option value="female">زن</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                container.appendChild(memberItem);

                // فعال کردن دکمه‌های حذف
                document.querySelectorAll('.remove-member').forEach(btn => {
                    btn.disabled = false;
                });
            });

            // حذف عضو
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-member')) {
                    const memberItem = e.target.closest('.member-item');
                    if (memberItem) {
                        memberItem.remove();

                        // غیرفعال کردن دکمه حذف اگر فقط یک عضو باقی مانده باشد
                        const members = document.querySelectorAll('.member-item');
                        if (members.length === 1) {
                            members[0].querySelector('.remove-member').disabled = true;
                        }
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .member-item {
            position: relative;
        }
        .remove-member {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush
