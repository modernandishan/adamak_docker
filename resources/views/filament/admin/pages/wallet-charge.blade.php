<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">مدیریت کیف پول</h1>
                <p class="text-gray-600 mt-1">شارژ کیف پول و مشاهده تراکنش‌ها</p>
            </div>
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="text-right">
                    <p class="text-sm text-gray-500">موجودی فعلی</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($this->wallet->balance) }} تومان</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <x-heroicon-o-credit-card class="w-6 h-6 text-green-600" />
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">شارژ کیف پول</h2>
                
                <form wire:submit="chargeWallet" class="space-y-6">
                    {{ $this->form }}

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 space-x-reverse pt-6 border-t border-gray-200">
                        <button
                            type="button"
                            wire:click="resetForm"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            انصراف
                        </button>
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <x-heroicon-o-credit-card class="w-4 h-4 ml-2" />
                            شارژ کیف پول
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">تاریخچه تراکنش‌ها</h2>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <span class="text-sm text-gray-500">آخرین تراکنش‌ها</span>
                        <x-heroicon-o-list-bullet class="w-5 h-5 text-gray-400" />
                    </div>
                </div>
                
                {{ $this->table }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
