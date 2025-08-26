<div class="fi-modal-content p-6">
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @php
                $totalAssignments = collect($stats)->sum('assigned_count');
                $avgAssignments = $totalAssignments > 0 ? round($totalAssignments / count($stats), 2) : 0;
                $maxAssignments = collect($stats)->max('assigned_count') ?? 0;
            @endphp
            
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ count($stats) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">تعداد مشاوران فعال</div>
            </div>
            
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalAssignments }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">کل آزمون‌های تخصیص یافته</div>
            </div>
            
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $avgAssignments }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">میانگین تخصیص به هر مشاور</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">جزئیات تخصیص آزمون‌ها</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                نام مشاور
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                عنوان شغلی
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                اولویت
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                تعداد آزمون
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                درصد از کل
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                نسبت به حداکثر
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($stats as $stat)
                            @php
                                $percentage = $totalAssignments > 0 ? round(($stat->assigned_count / $totalAssignments) * 100, 1) : 0;
                                $relativePercentage = $maxAssignments > 0 ? round(($stat->assigned_count / $maxAssignments) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $stat->consultant_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $stat->professional_title ?? 'نامشخص' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($stat->priority >= 10) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                        @elseif($stat->priority >= 5) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                        @endif
                                    ">
                                        {{ $stat->priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $stat->assigned_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 dark:text-gray-400">
                                    {{ $percentage }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 dark:bg-blue-400 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ $relativePercentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $relativePercentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="text-xs text-gray-500 dark:text-gray-400 text-center">
            آمار بر اساس آزمون‌های تکمیل شده و تخصیص یافته محاسبه شده است.
        </div>
    </div>
</div>