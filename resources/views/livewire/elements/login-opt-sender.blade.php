
<div class="mb-3">
    <label for="mobile" class="form-label">شماره تماس</label>
    <div class="input-group">
        <input wire:model="mobile" name="mobile" id="mobile" type="tel" class="form-control" placeholder="شماره تماس را به فرمت 09123456789 وارد کنید">
        <button class="btn btn-outline-primary" type="button" id="button-addon1" wire:click="SendLoginOpt">دریافت کد یکبار مصرف</button>
    </div>
    @if (session('error'))
        <div class="text-danger-emphasis">
            <p>
                {{ session('error') }}
            </p>
        </div>
    @endif
    @if (session('send-opt-success'))
        <div class="text-success-emphasis">
            <p>
                {{ session('send-opt-success') }}
            </p>
        </div>
    @endif
    @if (session('send-opt-error'))
        <div class="text-danger-emphasis">
            <p>
                {{ session('send-opt-error') }}
            </p>
        </div>
    @endif
    @if (session('send-opt-waiting'))
        <div class="text-info-emphasis">
            <p>
                {{ session('send-opt-waiting') }}
            </p>
        </div>
    @endif
</div>
