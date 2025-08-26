<?php

namespace App\Console\Commands;

use App\Models\Attempt;
use App\Models\AutomaticCommission;
use App\Models\ConsultantCommission;
use App\Models\MarketerCommission;
use Illuminate\Console\Command;

class DebugCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:commissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug commission creation and view issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Commission Debug Report ===');

        // Check latest attempts
        $latestAttempts = Attempt::with(['user', 'test', 'assignedConsultant'])
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(5)
            ->get();

        $this->info("\nLatest 5 completed attempts:");
        foreach ($latestAttempts as $attempt) {
            $this->line("Attempt ID: {$attempt->id}");
            $this->line("  User: {$attempt->user->name} {$attempt->user->family}");
            $this->line("  Test: {$attempt->test->title}");
            $this->line("  Completed: {$attempt->completed_at}");
            $this->line('  Assigned Consultant: '.($attempt->assigned_consultant_id ? "{$attempt->assignedConsultant->name} {$attempt->assignedConsultant->family}" : 'None'));
            $this->line('  ---');
        }

        // Check marketer commissions
        $marketerCommissions = MarketerCommission::with(['marketer', 'referredUser'])
            ->latest('earned_at')
            ->take(5)
            ->get();

        $this->info("\nLatest 5 marketer commissions:");
        foreach ($marketerCommissions as $commission) {
            $this->line("Marketer Commission ID: {$commission->id}");
            $this->line("  Marketer: {$commission->marketer->name} {$commission->marketer->family}");
            $this->line("  Commission Source: {$commission->commission_source}");
            $this->line("  Source ID: {$commission->source_id}");
            $this->line("  Amount: {$commission->commission_amount}");
            $this->line("  Status: {$commission->status}");
            $this->line("  Earned: {$commission->earned_at}");
            $this->line('  ---');
        }

        // Check consultant commissions
        $consultantCommissions = ConsultantCommission::with(['consultant', 'test'])
            ->latest('earned_at')
            ->take(5)
            ->get();

        $this->info("\nLatest 5 consultant commissions:");
        foreach ($consultantCommissions as $commission) {
            $this->line("Consultant Commission ID: {$commission->id}");
            $this->line("  Consultant: {$commission->consultant->name} {$commission->consultant->family}");
            $this->line("  Test: {$commission->test->title}");
            $this->line("  Amount: {$commission->commission_amount}");
            $this->line("  Status: {$commission->status}");
            $this->line("  Earned: {$commission->earned_at}");
            $this->line('  ---');
        }

        // Check consultant biographies
        $this->info("\nConsultant biographies for assigned consultants:");
        $assignedConsultants = Attempt::whereNotNull('completed_at')
            ->whereNotNull('assigned_consultant_id')
            ->with('assignedConsultant.consultantBiography')
            ->get()
            ->pluck('assignedConsultant')
            ->unique('id');

        foreach ($assignedConsultants as $consultant) {
            $this->line("Consultant: {$consultant->name} {$consultant->family}");
            if ($consultant->consultantBiography) {
                $this->line('  Has biography: Yes');
                $this->line("  Commission percentage: {$consultant->consultantBiography->test_commission_percentage}%");
                $this->line('  Is public: '.($consultant->consultantBiography->is_public ? 'Yes' : 'No'));
            } else {
                $this->line('  Has biography: No');
            }
            $this->line('  ---');
        }

        // Check unified view
        $automaticCommissions = AutomaticCommission::latest('earned_at')->take(10)->get();

        $this->info("\nLatest 10 automatic commissions (unified view):");
        foreach ($automaticCommissions as $commission) {
            $this->line("Type: {$commission->type}");
            $this->line("  Recipient: {$commission->recipient_name}");
            $this->line("  Test: {$commission->test_title}");
            $this->line("  Amount: {$commission->commission_amount}");
            $this->line("  Status: {$commission->status}");
            $this->line('  ---');
        }

        // Summary
        $this->info("\n=== Summary ===");
        $this->line('Total marketer commissions: '.MarketerCommission::count());
        $this->line('Total consultant commissions: '.ConsultantCommission::count());
        $this->line('Total in unified view: '.AutomaticCommission::count());
        $this->line('Completed attempts with assigned consultants: '.Attempt::whereNotNull('completed_at')->whereNotNull('assigned_consultant_id')->count());

        // Check test purchases
        $this->info("\n=== Test Purchases ===");
        $testPurchases = \App\Models\TestUserPurchase::with(['user', 'test'])->latest()->take(5)->get();
        $this->line('Total test purchases: '.\App\Models\TestUserPurchase::count());
        foreach ($testPurchases as $purchase) {
            $this->line("Purchase ID: {$purchase->id}");
            $this->line("  User: {$purchase->user->name} {$purchase->user->family}");
            $this->line("  Test: {$purchase->test->title}");
            $this->line("  Amount: {$purchase->amount}");
            $this->line("  Purchased: {$purchase->purchased_at}");
            $this->line('  ---');
        }

        return Command::SUCCESS;
    }
}
