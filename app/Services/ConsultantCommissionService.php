<?php

namespace App\Services;

use App\Models\Attempt;
use App\Models\ConsultantCommission;
use App\Models\User;

class ConsultantCommissionService
{
    /**
     * Calculate and create commission for a consultant when a test is completed
     */
    public function calculateAndCreateCommission(Attempt $attempt): ?ConsultantCommission
    {
        // Check if attempt has an assigned consultant
        if (! $attempt->assigned_consultant_id) {
            return null;
        }

        $consultant = User::find($attempt->assigned_consultant_id);
        if (! $consultant || ! $consultant->hasRole('consultant')) {
            return null;
        }

        // Get consultant's commission percentage from biography
        $consultantBio = $consultant->consultantBiography;
        if (! $consultantBio) {
            return null;
        }

        $commissionPercentage = $consultantBio->test_commission_percentage ?? 50.00;

        // Get test amount from the test price
        $test = $attempt->test;
        if (! $test) {
            return null;
        }

        $testAmount = (float) $test->price;
        $commissionAmount = ($testAmount * $commissionPercentage) / 100;

        return ConsultantCommission::create([
            'consultant_id' => $consultant->id,
            'attempt_id' => $attempt->id,
            'test_id' => $attempt->test_id,
            'test_amount' => $testAmount,
            'commission_percentage' => $commissionPercentage,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
            'earned_at' => now(),
        ]);
    }

    /**
     * Mark a consultant commission as paid
     */
    public function markAsPaid(ConsultantCommission $commission): bool
    {
        return $commission->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Get consultant commission statistics
     */
    public function getCommissionStatistics(?int $consultantId = null): array
    {
        $query = ConsultantCommission::with(['consultant', 'test'])
            ->select(
                'consultant_id',
                'test_id',
                \DB::raw('COUNT(*) as total_commissions'),
                \DB::raw('SUM(commission_amount) as total_earned'),
                \DB::raw('SUM(CASE WHEN status = "paid" THEN commission_amount ELSE 0 END) as total_paid'),
                \DB::raw('SUM(CASE WHEN status = "pending" THEN commission_amount ELSE 0 END) as total_pending')
            )
            ->groupBy('consultant_id', 'test_id');

        if ($consultantId) {
            $query->where('consultant_id', $consultantId);
        }

        return $query->get()->toArray();
    }
}
