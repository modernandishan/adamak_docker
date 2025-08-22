<div class="card mt-n5">
    <div class="card-body p-4">
        <div class="text-center">
            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                <!-- نمایش تصویر موقت یا تصویر اصلی -->
                @if ($tempImage)
                    <img src="{{ $tempImage }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="تصویر موقت">
                @elseif($user->profile && $user->profile->avatar)
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="تصویر پروفایل">
                @else
                    <img src="{{asset('images/default-avatar.png')}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="تصویر پیش‌فرض">
                @endif

                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model="avatar">
                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body">
                            <i class="ri-camera-fill"></i>
                        </span>
                    </label>
                </div>
            </div>
            <h5 class="mb-1">
                {{ $user->name . ' ' . $user->family }}
            </h5>
            <p class="text-muted mb-0">
                {{ $user->getRoleNames()->first() }}
            </p>

            <!-- دکمه ذخیره و نمایش خطاها -->
            @if ($avatar)
                <div class="mt-3">
                    <button class="btn btn-primary" wire:click="saveAvatar" wire:loading.attr="disabled">
                        <span wire:loading.remove>ذخیره تصویر</span>
                        <span wire:loading>در حال آپلود...</span>
                    </button>
                    <button class="btn btn-secondary" wire:click="$set('avatar', null)">لغو</button>
                </div>
            @endif

            <!-- نمایش خطاها -->
            @error('avatar')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if (session('avatar_success'))
                <div class="text-success mt-2">{{ session('avatar_success') }}</div>
            @endif
        </div>
    </div>
</div>
