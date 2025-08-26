<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the view if it exists first
        DB::statement('DROP VIEW IF EXISTS automatic_commissions_view');

        // Create a view that combines marketer and consultant commissions
        DB::statement("
            CREATE VIEW automatic_commissions_view AS
            SELECT 
                CONCAT('marketer_', mc.id) as id,
                'marketer' as type,
                mc.marketer_id as recipient_id,
                CONCAT(u1.name, ' ', u1.family) as recipient_name,
                u1.mobile as recipient_mobile,
                a1.test_id,
                t1.title as test_title,
                mc.source_id as attempt_id,
                mc.original_amount,
                mc.commission_percentage,
                mc.commission_amount,
                mc.status,
                mc.earned_at,
                mc.paid_at,
                'marketer_commission' as source_type,
                mc.id as source_id
            FROM marketer_commissions mc
            JOIN users u1 ON mc.marketer_id = u1.id
            LEFT JOIN attempts a1 ON mc.source_id = a1.id
            LEFT JOIN tests t1 ON a1.test_id = t1.id
            WHERE mc.commission_source = 'test_purchase'
            
            UNION ALL
            
            SELECT 
                CONCAT('consultant_', cc.id) as id,
                'consultant' as type,
                cc.consultant_id as recipient_id,
                CONCAT(u2.name, ' ', u2.family) as recipient_name,
                u2.mobile as recipient_mobile,
                cc.test_id,
                t2.title as test_title,
                cc.attempt_id,
                cc.test_amount as original_amount,
                cc.commission_percentage,
                cc.commission_amount,
                cc.status,
                cc.earned_at,
                cc.paid_at,
                'consultant_commission' as source_type,
                cc.id as source_id
            FROM consultant_commissions cc
            JOIN users u2 ON cc.consultant_id = u2.id
            JOIN tests t2 ON cc.test_id = t2.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS automatic_commissions_view');
    }
};
