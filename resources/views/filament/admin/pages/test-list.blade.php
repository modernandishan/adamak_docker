<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-primary-600">آزمون‌های آدمک</h1>
        <p class="text-gray-500">مشاهده و مدیریت تمامی آزمون‌های موجود در سیستم</p>
    </div>

    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- جستجو -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">جستجو</label>
                <input
                    type="text"
                    id="search"
                    wire:model.live.debounce.500ms="search"
                    placeholder="جستجو در عنوان آزمون‌ها..."
                    class="w-full rounded-lg border-gray-300 px-4 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                />
            </div>

            <!-- فیلتر دسته‌بندی -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی</label>
                <select
                    id="category"
                    wire:model.live="category"
                    class="w-full rounded-lg border-gray-300 px-4 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                >
                    <option value="">همه دسته‌بندی‌ها</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- مرتب‌سازی -->
            <div>
                <label for="sortBy" class="block text-sm font-medium text-gray-700 mb-1">مرتب‌سازی</label>
                <select
                    id="sortBy"
                    wire:model.live="sortBy"
                    class="w-full rounded-lg border-gray-300 px-4 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                >
                    @foreach($this->getSortOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if($tests->isEmpty())
        <div class="bg-white rounded-xl shadow p-8 text-center">
            <div class="flex justify-center">
                <x-heroicon-o-face-frown class="w-16 h-16 text-gray-400"/>
            </div>
            <h2 class="mt-4 text-xl font-medium text-gray-700">هیچ آزمونی یافت نشد</h2>
            <p class="mt-2 text-gray-500">با تغییر فیلترها، جستجوی دیگری انجام دهید.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tests as $test)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100 relative">
                    <!-- ریبون وضعیت -->
                    @if($test->status == 'Published')
                        <div class="absolute top-0 left-0 bg-green-500 text-white px-3 py-1 text-xs font-bold z-10 rounded-br-lg">منتشر شده</div>
                    @elseif($test->status == 'Draft')
                        <div class="absolute top-0 left-0 bg-gray-500 text-white px-3 py-1 text-xs font-bold z-10 rounded-br-lg">پیش‌نویس</div>
                    @endif

                    <div class="relative h-48">
                        @if($test->image)
                            <img src="{{ $test->image_url }}" alt="{{ $test->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <x-heroicon-o-academic-cap class="w-16 h-16 text-gray-400"/>
                            </div>
                        @endif
                        @if($test->is_free)
                            <span class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">رایگان</span>
                        @else
                            <span class="absolute top-3 right-3 bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                {{ number_format($test->final_price) }} تومان
                            </span>
                        @endif
                        @if($test->sale > 0)
                            <span class="absolute bottom-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                {{ $test->discount_percentage }}% تخفیف
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-lg line-clamp-1">{{ $test->title }}</h3>
                            @if($test->category)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $test->category->title }}</span>
                            @endif
                        </div>

                        <p class="text-gray-500 text-sm mb-3 line-clamp-2">{{ Str::limit(strip_tags($test->description), 100) }}</p>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <div class="flex items-center">
                                <x-heroicon-o-clock class="w-4 h-4 ml-1"/>
                                <span>{{ $test->required_time }}</span>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-user-group class="w-4 h-4 ml-1"/>
                                <span>{{ $test->age_range }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <div class="flex items-center">
                                <x-heroicon-o-question-mark-circle class="w-4 h-4 ml-1"/>
                                <span>{{ $test->active_questions_count }} سوال</span>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="w-4 h-4 ml-1"/>
                                <span>{{ ($test->created_at)->format('Y/m/d') }}</span>
                            </div>
                        </div>
                        @role('super_admin|admin')
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ url('/admin/test-start').'/'.$test->id }}" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300 text-center text-xs">
                                شرکت در آزمون
                            </a>
                            <a href="{{ route('filament.admin.resources.tests.view', $test) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-300 text-center text-xs">
                                مشاهده جزئیات
                            </a>
                            <a href="{{ route('filament.admin.resources.tests.edit', $test) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-300 text-center text-xs">
                                ویرایش
                            </a>
                        </div>
                        @else
                            <a href="{{ url('/admin/test-start').'/'.$test->id }}" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300 text-center text-xs">
                                شرکت در آزمون
                            </a>
                        @endrole
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-filament-panels::page>
