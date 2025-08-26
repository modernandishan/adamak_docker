<?php

namespace App\Console\Commands;

use App\Models\Attempt;
use App\Services\ConsultantCommissionService;
use Illuminate\Console\Command;

class CreateMissingConsultantCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commissions:create-missing-consultant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing consultant commissions for completed attempts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating missing consultant commissions...');

        // Find completed attempts with assigned consultants that don't have consultant commissions
        $attempts = Attempt::whereNotNull('completed_at')
            ->whereNotNull('assigned_consultant_id')
            ->whereDoesntHave('consultantCommission')
            ->with(['user', 'test', 'assignedConsultant.consultantBiography'])
            ->get();

        $this->info("Found {$attempts->count()} attempts without consultant commissions");

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($attempts as $attempt) {
            $this->line("Processing attempt ID: {$attempt->id}");
            $this->line("  User: {$attempt->user->name} {$attempt->user->family}");
            $this->line("  Test: {$attempt->test->title}");
            $this->line("  Consultant: {$attempt->assignedConsultant->name} {$attempt->assignedConsultant->family}");

            // Check if consultant has biography
            if (! $attempt->assignedConsultant->consultantBiography) {
                $this->warn('  Skipped: Consultant has no biography');
                $skippedCount++;

                continue;
            }

            // Check if test exists
            if (! $attempt->test) {
                $this->warn('  Skipped: Test not found');
                $skippedCount++;

                continue;
            }

            // Create commission
            $commissionService = app(ConsultantCommissionService::class);
            $commission = $commissionService->calculateAndCreateCommission($attempt);

            if ($commission) {
                $this->info("  Created commission: {$commission->commission_amount} تومان");
                $createdCount++;
            } else {
                $this->warn('  Failed to create commission');
                $skippedCount++;
            }
        }

        $this->info("\n=== Summary ===");
        $this->line("Created: {$createdCount}");
        $this->line("Skipped: {$skippedCount}");
        $this->line('Total processed: '.($createdCount + $skippedCount));

        return Command::SUCCESS;
    }
}
