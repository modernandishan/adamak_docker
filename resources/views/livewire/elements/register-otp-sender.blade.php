<div class="mb-3">
    <label for="mobile" class="form-label">شماره تماس<span class="text-danger">*</span></label>
    <div class="input-group">
        <input wire:model="mobile" name="mobile" id="mobile" type="tel" 
               class="form-control @error('mobile') is-invalid @enderror" 
               placeholder="شماره تماس را به فرمت 09123456789 وارد کنید" required>
        <button class="btn btn-outline-primary" type="button" wire:click="sendRegisterOpt">دریافت کد یکبار مصرف</button>
    </div>
    
    @error('mobile')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (session('error'))
        <div class="text-danger-emphasis mt-2">
            <small>{{ session('error') }}</small>
        </div>
    @endif
    
    @if (session('send-opt-success'))
        <div class="text-success-emphasis mt-2">
            <small>{{ session('send-opt-success') }}</small>
        </div>
    @endif
    
    @if (session('send-opt-error'))
        <div class="text-danger-emphasis mt-2">
            <small>{{ session('send-opt-error') }}</small>
        </div>
    @endif
    
    @if (session('send-opt-waiting'))
        <div class="text-info-emphasis mt-2">
            <small>{{ session('send-opt-waiting') }}</small>
        </div>
    @endif
</div>