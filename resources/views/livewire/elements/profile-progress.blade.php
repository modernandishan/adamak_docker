<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-5">
            <div class="flex-grow-1">
                <h5 class="card-title mb-0">نمایه خود را تکمیل کنید</h5>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('user.profile.edit') }}" class="badge bg-light text-primary fs-12">
                    <i class="ri-edit-box-line align-bottom me-1"></i>ویرایش کنید
                </a>
            </div>
        </div>
        <div class="progress animated-progress custom-progress progress-label">
            <div
                class="progress-bar {{ $progress < 30 ? 'bg-danger' : ($progress < 70 ? 'bg-warning' : 'bg-success') }}"
                role="progressbar"
                style="width: {{ $progress }}%"
                aria-valuenow="{{ $progress }}"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                <div class="label">{{ $progress }}%</div>
            </div>
        </div>

        @if($progress < 100)
            <div class="mt-3">
                <small class="text-muted">فیلدهای تکمیل نشده:</small>
                <ul class="list-unstyled mb-0">
                    @if(empty(Auth::user()->name))
                        <li><small class="text-danger">- نام</small></li>
                    @endif
                    @if(empty(Auth::user()->family))
                        <li><small class="text-danger">- نام خانوادگی</small></li>
                    @endif
                    @if(Auth::user()->profile)
                        @if(empty(Auth::user()->profile->avatar))
                            <li><small class="text-danger">- آواتار</small></li>
                        @endif
                        @if(empty(Auth::user()->profile->address))
                            <li><small class="text-danger">- آدرس</small></li>
                        @endif
                        @if(empty(Auth::user()->profile->province))
                            <li><small class="text-danger">- استان</small></li>
                        @endif
                        @if(empty(Auth::user()->profile->birth))
                            <li><small class="text-danger">- تاریخ تولد</small></li>
                        @endif
                        @if(empty(Auth::user()->profile->national_code))
                            <li><small class="text-danger">- کد ملی</small></li>
                        @endif
                        @if(empty(Auth::user()->profile->postal_code))
                            <li><small class="text-danger">- کدپستی</small></li>
                        @endif
                    @endif
                </ul>
            </div>
        @endif
    </div>
</div>
