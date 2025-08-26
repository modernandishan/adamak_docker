<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ConsultantAssignmentService
{
    /**
     * Assign a consultant to a test attempt using weighted random selection
     */
    public function assignConsultantToAttempt(): ?User
    {
        $consultants = $this->getAvailableConsultants();

        if ($consultants->isEmpty()) {
            return null;
        }

        return $this->weightedRandomSelection($consultants);
    }

    /**
     * Get available consultants with their priorities
     */
    protected function getAvailableConsultants(): Collection
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'consultant');
        })
            ->whereHas('consultantBiography', function ($query) {
                $query->where('is_public', true);
            })
            ->with(['consultantBiography' => function ($query) {
                $query->select('user_id', 'priority', 'professional_title');
            }])
            ->get();
    }

    /**
     * Perform weighted random selection based on consultant priorities
     */
    protected function weightedRandomSelection(Collection $consultants): ?User
    {
        // Create weighted array
        $weightedConsultants = [];
        $totalWeight = 0;

        foreach ($consultants as $consultant) {
            $priority = $consultant->consultantBiography->priority ?? 1;
            $totalWeight += $priority;

            $weightedConsultants[] = [
                'consultant' => $consultant,
                'weight' => $priority,
                'cumulative_weight' => $totalWeight,
            ];
        }

        if ($totalWeight <= 0) {
            return null;
        }

        // Generate random number between 1 and total weight
        $random = rand(1, $totalWeight);

        // Find the selected consultant
        foreach ($weightedConsultants as $weightedConsultant) {
            if ($random <= $weightedConsultant['cumulative_weight']) {
                return $weightedConsultant['consultant'];
            }
        }

        // Fallback to first consultant if something goes wrong
        return $consultants->first();
    }

    /**
     * Get consultant assignment statistics
     */
    public function getAssignmentStatistics(): array
    {
        $stats = DB::table('attempts')
            ->join('users', 'attempts.assigned_consultant_id', '=', 'users.id')
            ->join('consultant_biographies', 'users.id', '=', 'consultant_biographies.user_id')
            ->select(
                'users.name as consultant_name',
                'consultant_biographies.professional_title',
                'consultant_biographies.priority',
                DB::raw('COUNT(*) as assigned_count')
            )
            ->whereNotNull('attempts.assigned_consultant_id')
            ->groupBy('users.id', 'users.name', 'consultant_biographies.professional_title', 'consultant_biographies.priority')
            ->orderBy('assigned_count', 'desc')
            ->get()
            ->toArray();

        return $stats;
    }

    /**
     * Reassign consultant for a specific attempt
     */
    public function reassignConsultant(int $attemptId): ?User
    {
        $newConsultant = $this->assignConsultantToAttempt();

        if (! $newConsultant) {
            return null;
        }

        DB::table('attempts')
            ->where('id', $attemptId)
            ->update([
                'assigned_consultant_id' => $newConsultant->id,
                'assigned_at' => now(),
            ]);

        return $newConsultant;
    }
}
