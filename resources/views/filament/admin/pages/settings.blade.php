<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">تنظیمات سیستم</h1>
                    <p class="text-gray-600 mt-1">مدیریت تنظیمات کلی سیستم و درگاه پرداخت</p>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    @foreach($this->getHeaderActions() as $action)
                        {{ $action }}
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                {{ $this->form }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
