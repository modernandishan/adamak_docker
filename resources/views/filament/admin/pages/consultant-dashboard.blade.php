<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $totalAttempts = $this->getTableQuery()->count();
                $completedAttempts = $this->getTableQuery()->whereNotNull('completed_at')->count();
                $pendingAttempts = $totalAttempts - $completedAttempts;
                $inProgressAttempts = $this->getTableQuery()->whereNotNull('started_at')->whereNull('completed_at')->count();
            @endphp
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-medium text-gray-900">کل آزمون‌ها</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalAttempts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-medium text-gray-900">در انتظار بررسی</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingAttempts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-medium text-gray-900">تکمیل شده</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $completedAttempts }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
