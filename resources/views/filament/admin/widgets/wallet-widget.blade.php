<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $walletData = $this->getWalletData();
        @endphp
        
        <div class="space-y-4">
            <!-- Header with balance -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <x-heroicon-o-credit-card class="w-6 h-6 text-primary-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">کیف پول</h3>
                        <p class="text-sm text-gray-500">مدیریت مالی شما</p>
                    </div>
                </div>
                <a href="{{ route('filament.admin.pages.wallet-charge') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-primary-600 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 hover:text-primary-700 transition-colors duration-200">
                    <x-heroicon-o-plus class="w-4 h-4 ml-1" />
                    شارژ
                </a>
            </div>

            <!-- Balance display -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700">موجودی فعلی</p>
                        <p class="text-2xl font-bold text-green-800">{{ number_format($walletData['balance']) }} تومان</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <x-heroicon-o-currency-dollar class="w-6 h-6 text-green-600" />
                    </div>
                </div>
            </div>

            <!-- Quick stats -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <x-heroicon-o-arrow-up-circle class="w-4 h-4 text-blue-600" />
                        </div>
                        <div class="mr-3">
                            <p class="text-xs font-medium text-blue-700">کل تراکنش‌ها</p>
                            <p class="text-lg font-bold text-blue-800">{{ number_format($walletData['total_transactions']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <x-heroicon-o-calendar class="w-4 h-4 text-orange-600" />
                        </div>
                        <div class="mr-3">
                            <p class="text-xs font-medium text-orange-700">این ماه</p>
                            <p class="text-lg font-bold text-orange-800">{{ number_format($walletData['this_month_transactions']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending transactions alert -->
            @if($walletData['pending_transactions'] > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <x-heroicon-o-clock class="w-4 h-4 text-yellow-600" />
                        </div>
                        <div class="mr-3">
                            <p class="text-sm font-medium text-yellow-800">
                                {{ $walletData['pending_transactions'] }} تراکنش در انتظار
                            </p>
                            <p class="text-xs text-yellow-600">بررسی کنید</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Last transaction -->
            @if($walletData['last_transaction_date'])
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600">آخرین تراکنش</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $walletData['last_transaction_type'] === 'charge' ? 'شارژ' : 'خرید' }} 
                                {{ number_format($walletData['last_transaction_amount']) }} تومان
                            </p>
                            <p class="text-xs text-gray-500">{{ $walletData['last_transaction_date'] }}</p>
                        </div>
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <x-heroicon-o-clock class="w-4 h-4 text-gray-600" />
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick actions -->
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('filament.admin.pages.wallet-charge') }}" 
                   class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <x-heroicon-o-credit-card class="w-4 h-4 ml-1" />
                    شارژ کیف پول
                </a>
                <a href="{{ route('filament.admin.pages.wallet-charge') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <x-heroicon-o-list-bullet class="w-4 h-4" />
                </a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
