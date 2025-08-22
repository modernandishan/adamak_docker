<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Test;
use App\Models\Family;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function startTest($slug)
    {
        $test = Test::with('orderedQuestions')
            ->where('slug', $slug)
            ->where('status', 'Published')
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();

        // بررسی نیاز به اطلاعات خانواده
        $families = [];
        if ($test->is_need_family) {
            $families = $user->families()->get();

            if ($families->count() === 0) {
                return redirect()->route('user.family.show')
                    ->with('error', 'برای شرکت در این آزمون باید اطلاعات خانواده را ثبت کنید.');
            }
        }

        // ایجاد Attempt جدید
        $attempt = Attempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'started_at' => now(),
        ]);

        return view('test-start', compact('test', 'families', 'attempt'));
    }

    public function submitTest(Request $request, $slug)
    {
        $test = Test::where('slug', $slug)
            ->where('status', 'Published')
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();
        $finalPrice = $test->final_price;
        $attempt = Attempt::findOrFail($request->attempt_id);

        // اعتبارسنجی انتخاب خانواده برای آزمون‌های نیازمند
        if ($test->is_need_family) {
            $request->validate([
                'family_id' => 'required|exists:families,id,user_id,' . $user->id
            ]);

            $attempt->family_id = $request->family_id;
        }

        // اعتبارسنجی پاسخ‌ها
        $questions = $test->orderedQuestions()->active()->get();
        $rules = [];
        $messages = [];

        foreach ($questions as $question) {
            $key = "answers.{$question->id}";

            if ($question->is_required) {
                if ($question->type === 'text') {
                    $rules[$key] = 'required|string|max:5000';
                } elseif ($question->type === 'upload') {
                    $rules[$key] = 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120';
                }
            } else {
                if ($question->type === 'text') {
                    $rules[$key] = 'nullable|string|max:5000';
                } elseif ($question->type === 'upload') {
                    $rules[$key] = 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120';
                }
            }

            $messages["$key.required"] = "پاسخ سوال «{$question->title}» الزامی است.";
        }

        $validated = $request->validate($rules, $messages);

        // تراکنش دیتابیس برای اتمیک بودن عملیات
        return DB::transaction(function () use ($user, $test, $finalPrice, $questions, $validated, $attempt) {
            // کسر هزینه از کیف پول برای آزمون‌های پولی
            if ($finalPrice > 0) {
                $wallet = $user->wallet()->lockForUpdate()->first();

                if (!$wallet || $wallet->balance < $finalPrice) {
                    return back()->with('error', 'موجودی کیف پول شما برای این آزمون کافی نیست!')
                        ->withInput();
                }

                // کسر از کیف پول
                $transaction = $wallet->purchase(
                    $finalPrice,
                    "هزینه آزمون: {$test->title}"
                );

                if (!$transaction) {
                    throw new \Exception('کسر از کیف پول با خطا مواجه شد');
                }

                $attempt->wallet_transaction_id = $transaction->id;
            }

            // ذخیره پاسخ‌ها
            foreach ($questions as $question) {
                $answerValue = $validated['answers'][$question->id] ?? null;

                if ($answerValue) {
                    $answerData = [
                        'attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                    ];

                    if ($question->type === 'text') {
                        $answerData['text_answer'] = $answerValue;
                    } elseif ($question->type === 'upload') {
                        $path = $answerValue->store("answers/{$user->id}/{$test->id}/{$attempt->id}", 'public');
                        $answerData['file_path'] = $path;
                    }

                    Answer::create($answerData);
                }
            }

            // تکمیل Attempt
            $attempt->completed_at = now();
            $attempt->save();

            return redirect()->route('tests')
                ->with('success', 'پاسخ‌های شما با موفقیت ثبت شد و آزمون تکمیل گردید');
        });
    }
}
