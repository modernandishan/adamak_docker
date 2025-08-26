<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Test and User Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    اطلاعات کاربر
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">نام و نام خانوادگی:</span>
                        <span class="font-medium">{{ $attempt->user->name }} {{ $attempt->user->family }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">شماره موبایل:</span>
                        <span class="font-medium">{{ $attempt->user->mobile }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ایمیل:</span>
                        <span class="font-medium">{{ $attempt->user->email ?? 'ثبت نشده' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">تاریخ ثبت نام:</span>
                        <span class="font-medium">{{ $attempt->user->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Test Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 ml-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    اطلاعات آزمون
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">عنوان آزمون:</span>
                        <span class="font-medium">{{ $attempt->test->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">تاریخ تخصیص:</span>
                        <span class="font-medium">{{ $attempt->assigned_at->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">تاریخ شروع:</span>
                        <span class="font-medium">{{ $attempt->started_at ? $attempt->started_at->format('Y/m/d H:i') : 'شروع نشده' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">تاریخ تکمیل:</span>
                        <span class="font-medium">{{ $attempt->completed_at ? $attempt->completed_at->format('Y/m/d H:i') : 'تکمیل نشده' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">تعداد پاسخ‌ها:</span>
                        <span class="font-medium">{{ $attempt->answers->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family Information (if exists) -->
        @if($attempt->family)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 ml-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                اطلاعات خانواده
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">عنوان خانواده:</span>
                        <span class="font-medium">{{ $attempt->family->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">نام پدر:</span>
                        <span class="font-medium">
                            {{ $attempt->family->father_name }}
                            @if($attempt->family->is_father_gone)
                                <span class="text-red-600">(فوت شده)</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">نام مادر:</span>
                        <span class="font-medium">
                            {{ $attempt->family->mother_name }}
                            @if($attempt->family->is_mother_gone)
                                <span class="text-red-600">(فوت شده)</span>
                            @endif
                        </span>
                    </div>
                </div>
                @if($attempt->family->members)
                <div>
                    <span class="text-gray-600 block mb-2">اعضای خانواده:</span>
                    <div class="space-y-1">
                        @foreach($attempt->family->members as $member)
                            <div class="text-sm bg-gray-50 p-2 rounded">
                                <span class="font-medium">{{ $member['name'] ?? 'نامشخص' }}</span>
                                @if(isset($member['relation']))
                                    - <span class="text-gray-600">{{ $member['relation'] }}</span>
                                @endif
                                @if(isset($member['age']))
                                    - <span class="text-gray-600">{{ $member['age'] }} سال</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- User Answers -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 ml-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                پاسخ‌های کاربر
            </h3>
            
            @if($attempt->answers->count() > 0)
                <div class="space-y-6">
                    @foreach($attempt->test->questions->sortBy('sort_order') as $question)
                        @php
                            $answer = $attempt->answers->where('question_id', $question->id)->first();
                        @endphp
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="mb-3">
                                <h4 class="font-medium text-gray-900">{{ $question->title }}</h4>
                                @if($question->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $question->description }}</p>
                                @endif
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full
                                    {{ $question->type === 'text' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $question->type_name }}
                                </span>
                            </div>
                            
                            @if($answer)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">پاسخ کاربر:</h5>
                                    
                                    @if($question->type === 'text' && $answer->text_answer)
                                        <div class="prose prose-sm max-w-none">
                                            {!! nl2br(e($answer->text_answer)) !!}
                                        </div>
                                    @elseif($question->type === 'upload' && $answer->file_path)
                                        <div class="flex items-center space-x-2 space-x-reverse">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $answer->file_path) }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:text-blue-800 underline">
                                                مشاهده فایل
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-gray-500 italic">پاسخ ارائه نشده</p>
                                    @endif
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <p class="text-yellow-800 text-sm">کاربر به این سوال پاسخ نداده است</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 mt-2">هنوز پاسخی ثبت نشده است</p>
                </div>
            @endif
        </div>

        <!-- Consultant Response Form -->
        @if($attempt->completed_at)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 ml-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                ارسال پاسخ مشاوره
                @if($attempt->consultantResponse)
                    <span class="mr-2 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                        ارسال شده در {{ $attempt->consultantResponse->sent_at->format('Y/m/d H:i') }}
                    </span>
                @endif
            </h3>
            
            <form wire:submit="save">
                {{ $this->form }}
                
                <div class="mt-6 flex justify-end space-x-3 space-x-reverse">
                    <x-filament::button type="submit">
                        {{ $attempt->consultantResponse ? 'بروزرسانی پاسخ' : 'ارسال پاسخ' }}
                    </x-filament::button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="mr-3">
                    <h3 class="text-sm font-medium text-yellow-800">آزمون هنوز تکمیل نشده</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        تا زمانی که کاربر آزمون را تکمیل نکند، نمی‌توانید پاسخ مشاوره ارسال کنید.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>
