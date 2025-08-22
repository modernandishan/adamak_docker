@extends('layouts.main')
@section('title', $test->title . ' | آدمک')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card custom-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title text-white mb-0">{{ $test->title }}</h4>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark fs-6">
                                        <i class="ri-time-line me-1"></i>
                                        {{ $test->required_time }}
                                    </span>
                                    @if($test->final_price > 0)
                                        <span class="badge bg-warning text-dark fs-6 ms-2">
                                            <i class="ri-wallet-line me-1"></i>
                                            {{ number_format($test->final_price) }} ریال
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($test->final_price > 0)
                                <div class="alert alert-info mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-information-line fs-4 me-2"></i>
                                        <div>
                                            این آزمون پولی است و پس از ارسال پاسخ‌ها،
                                            <strong>{{ number_format($test->final_price) }} ریال</strong>
                                            از کیف پول شما کسر خواهد شد.
                                            @if($test->is_need_family)
                                                <div class="mt-1">
                                                    <i class="ri-user-settings-line me-1"></i>
                                                    این آزمون نیاز به اطلاعات خانواده دارد.
                                                    (<a href="{{ route('user.family.show') }}">مدیریت خانواده‌های تعریف شده شما</a>)
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('user.test.submit', $test->slug) }}" enctype="multipart/form-data" id="testForm">
                                @csrf
                                <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

                                @if($test->is_need_family && $families->count() > 0)
                                    <div class="family-selection mb-5 p-4 border rounded bg-light">
                                        <h5 class="mb-3"><i class="ri-group-line me-2"></i> انتخاب خانواده</h5>
                                        <div class="row">
                                            @foreach($families as $family)
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-check card p-3 h-100">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="family_id"
                                                            id="family_{{ $family->id }}"
                                                            value="{{ $family->id }}"
                                                            required
                                                        >
                                                        <label class="form-check-label w-100" for="family_{{ $family->id }}">
                                                            <div class="d-flex justify-content-between">
                                                                <strong>{{ $family->title }}</strong>
                                                                <span class="badge bg-primary">
                                                                    {{ count($family->members) }} عضو
                                                                </span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div>پدر: {{ $family->father_name }}</div>
                                                                <div>مادر: {{ $family->mother_name }}</div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @foreach($test->orderedQuestions as $index => $question)
                                    <div class="question-card mb-4 p-4 border rounded">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="question-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="question-title mb-1">
                                                    {{ $question->title }}
                                                    @if($question->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </h5>
                                                @if($question->description)
                                                    <div class="question-description text-muted mb-2">
                                                        {!! $question->description !!}
                                                    </div>
                                                @endif
                                                @if($question->hint)
                                                    <div class="question-hint alert alert-light mt-2">
                                                        <i class="ri-lightbulb-flash-line me-2"></i>
                                                        {{ $question->hint }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="answer-section ps-5">
                                            @if($question->type === 'text')
                                                <textarea
                                                    name="answers[{{ $question->id }}]"
                                                    class="form-control"
                                                    rows="4"
                                                    placeholder="پاسخ خود را وارد کنید"
                                                    {{ $question->is_required ? 'required' : '' }}
                                                ></textarea>
                                            @elseif($question->type === 'upload')
                                                <div class="file-upload-area">
                                                    <input
                                                        type="file"
                                                        name="answers[{{ $question->id }}]"
                                                        class="form-control"
                                                        {{ $question->is_required ? 'required' : '' }}
                                                    >
                                                    <div class="form-text mt-1">
                                                        <i class="ri-information-line me-1"></i>
                                                        فرمت‌های مجاز: PDF, Word, JPG, PNG (حداکثر 5 مگابایت)
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <div class="sticky-submit-bar bg-light p-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            <span id="answeredCount">0</span> از {{ count($test->orderedQuestions) }} سوال پاسخ داده شده
                                        </div>
                                        <button type="submit" class="btn btn-success btn-lg px-5">
                                            <i class="ri-send-plane-line me-2"></i>
                                            ارسال نهایی پاسخ‌ها
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .family-selection .form-check {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .family-selection .form-check-input:checked + label {
            color: #0d6efd;
        }

        .family-selection .form-check-input:checked ~ .card {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .family-selection .form-check-input {
            margin-top: 0;
        }

        .custom-card {
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            padding: 1.2rem 1.5rem;
        }

        .question-card {
            background-color: #fff;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .question-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-color: #c0e0ff;
        }

        .question-number {
            width: 40px;
            height: 40px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .question-title {
            font-weight: 600;
            color: #333;
        }

        .question-description {
            font-size: 0.95rem;
        }

        .sticky-submit-bar {
            position: sticky;
            bottom: 0;
            z-index: 10;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .answer-section {
            border-left: 3px solid #e0e0e0;
            padding-left: 1.5rem;
        }

        .file-upload-area {
            position: relative;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('testForm');
            const answeredCount = document.getElementById('answeredCount');
            const questions = form.querySelectorAll('textarea, input[type="file"]');

            // محاسبه پاسخ‌های داده شده
            function updateAnsweredCount() {
                let count = 0;
                questions.forEach(q => {
                    if (q.type === 'file' && q.files.length > 0) count++;
                    else if (q.value.trim() !== '') count++;
                });
                answeredCount.textContent = count;
            }

            // رصد تغییرات در پاسخ‌ها
            questions.forEach(q => {
                q.addEventListener('change', updateAnsweredCount);
                if (q.tagName === 'TEXTAREA') {
                    q.addEventListener('keyup', updateAnsweredCount);
                }
            });

            // شمارش اولیه
            updateAnsweredCount();

            // تایید نهایی قبل از ارسال
            form.addEventListener('submit', function(e) {
                const requiredQuestions = form.querySelectorAll('[required]');
                let allRequiredAnswered = true;

                requiredQuestions.forEach(q => {
                    if (q.type === 'file' && q.files.length === 0) allRequiredAnswered = false;
                    else if (q.value.trim() === '') allRequiredAnswered = false;
                });

                if (!allRequiredAnswered) {
                    e.preventDefault();
                    alert('لطفاً به تمام سوالات اجباری پاسخ دهید!');
                    return false;
                }

                @if($test->final_price > 0)
                const finalPrice = {{ $test->final_price }};
                const balance = {{ Auth::user()->wallet->balance ?? 0 }};

                if (finalPrice > 0 && balance < finalPrice) {
                    e.preventDefault();
                    if (confirm('موجودی کیف پول شما کافی نیست! آیا می‌خواهید به صفحه شارژ کیف پول بروید؟')) {
                        window.location.href = "{{ route('user.wallet.charge.form') }}";
                    }
                    return false;
                }
                @endif

                    return confirm('آیا از ارسال پاسخ‌های خود اطمینان دارید؟ این عمل غیرقابل بازگشت است.');
            });
        });
    </script>
@endpush
