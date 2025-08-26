<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\ConsultantResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsultantController extends Controller
{
    /**
     * Display consultant dashboard with assigned tests
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        $attempts = Attempt::with(['user', 'test', 'family', 'answers'])
            ->where('assigned_consultant_id', $user->id)
            ->whereNotNull('assigned_at')
            ->orderBy('assigned_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => $attempts->total(),
            'pending' => Attempt::where('assigned_consultant_id', $user->id)
                ->whereNotNull('assigned_at')
                ->whereNull('completed_at')
                ->count(),
            'completed' => Attempt::where('assigned_consultant_id', $user->id)
                ->whereNotNull('completed_at')
                ->count(),
        ];

        return view('consultant.dashboard', compact('attempts', 'stats'));
    }

    /**
     * Show test details and user answers
     */
    public function testDetails(int $attemptId): View
    {
        $attempt = Attempt::with([
            'user',
            'test.questions' => function ($query) {
                $query->orderBy('sort_order')->orderBy('id');
            },
            'family',
            'answers.question',
            'consultantResponse',
        ])
            ->where('assigned_consultant_id', Auth::id())
            ->whereNotNull('assigned_at')
            ->findOrFail($attemptId);

        return view('consultant.test-details', compact('attempt'));
    }

    /**
     * Store or update consultant response
     */
    public function storeResponse(Request $request, int $attemptId): RedirectResponse
    {
        $attempt = Attempt::where('assigned_consultant_id', Auth::id())
            ->whereNotNull('completed_at')
            ->findOrFail($attemptId);

        $validated = $request->validate([
            'response_text' => 'required|string|max:5000',
            'recommendations' => 'nullable|string|max:2000',
            'is_urgent' => 'boolean',
        ], [
            'response_text.required' => 'متن پاسخ الزامی است.',
            'response_text.max' => 'متن پاسخ نباید بیش از 5000 کاراکتر باشد.',
            'recommendations.max' => 'توصیه‌ها نباید بیش از 2000 کاراکتر باشد.',
        ]);

        ConsultantResponse::updateOrCreate(
            ['attempt_id' => $attempt->id],
            [
                'consultant_id' => Auth::id(),
                'response_text' => $validated['response_text'],
                'recommendations' => $validated['recommendations'] ?? null,
                'is_urgent' => $validated['is_urgent'] ?? false,
                'sent_at' => now(),
            ]
        );

        return redirect()
            ->route('consultant.test-details', $attemptId)
            ->with('success', 'پاسخ مشاوره با موفقیت ارسال شد.');
    }
}
