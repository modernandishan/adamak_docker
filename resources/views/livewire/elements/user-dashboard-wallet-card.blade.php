<div class="col-xl-3 col-md-6">
    <!-- card -->
    <div class="card card-animate bg-info">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                    <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">موجودی من</p>
                </div>
                <div class="flex-shrink-0">
                    <h5 class="text-white fs-14 mb-0">
                        {{$transactions}}
                        تراکنش
                    </h5>
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
                <div>
                    <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span class="counter-value"
                                                                                 data-target="{{$user_balance}}">0</span>
                        تومان</h4>
                    <a href="{{route('user.wallet.charge.form')}}" class="text-decoration-underline text-white-50">شارژ کیف پول</a>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-white bg-opacity-10 rounded fs-3">
                        <i class="bx bx-wallet text-white"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
