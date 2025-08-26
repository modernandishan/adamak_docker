<?php

namespace App\Http\Controllers;

use App\Models\MarketerCommission;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketerController extends Controller
{
    /**
     * Display marketer dashboard with referrals and commissions
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        $referrals = Referral::with(['referredUser'])
            ->where('marketer_id', $user->id)
            ->whereNotNull('referred_user_id')
            ->orderBy('registered_at', 'desc')
            ->paginate(10);

        $commissions = MarketerCommission::with(['referredUser'])
            ->where('marketer_id', $user->id)
            ->orderBy('earned_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_referrals' => $user->referrals()->whereNotNull('referred_user_id')->count(),
            'total_commissions' => $user->commissions()->sum('commission_amount'),
            'pending_commissions' => $user->commissions()->where('status', 'pending')->sum('commission_amount'),
            'paid_commissions' => $user->commissions()->where('status', 'paid')->sum('commission_amount'),
        ];

        return view('marketer.dashboard', compact('referrals', 'commissions', 'stats'));
    }

    /**
     * Show marketer's referrals list
     */
    public function referrals(): View
    {
        $user = Auth::user();

        $referrals = Referral::with(['referredUser'])
            ->where('marketer_id', $user->id)
            ->whereNotNull('referred_user_id')
            ->orderBy('registered_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_referrals' => $user->referrals()->whereNotNull('referred_user_id')->count(),
            'total_clicks' => $user->referrals()->count(),
            'conversion_rate' => $user->referrals()->count() > 0
                ? round(($user->referrals()->whereNotNull('referred_user_id')->count() / $user->referrals()->count()) * 100, 2)
                : 0,
        ];

        return view('marketer.referrals', compact('referrals', 'stats'));
    }

    /**
     * Show marketer's commissions list
     */
    public function commissions(): View
    {
        $user = Auth::user();

        $commissions = MarketerCommission::with(['referredUser'])
            ->where('marketer_id', $user->id)
            ->orderBy('earned_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_commissions' => $user->commissions()->sum('commission_amount'),
            'pending_commissions' => $user->commissions()->where('status', 'pending')->sum('commission_amount'),
            'paid_commissions' => $user->commissions()->where('status', 'paid')->sum('commission_amount'),
            'total_transactions' => $user->commissions()->count(),
        ];

        return view('marketer.commissions', compact('commissions', 'stats'));
    }
}
