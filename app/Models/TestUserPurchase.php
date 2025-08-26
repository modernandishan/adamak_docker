<?php

namespace App\Models;

use App\Services\ReferralService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TestUserPurchase extends Pivot
{
    protected $table = 'test_user_purchases';

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'test_id',
        'amount',
        'wallet_transaction_id',
        'purchased_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'purchased_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function walletTransaction(): BelongsTo
    {
        return $this->belongsTo(WalletTransaction::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($testPurchase) {
            // Make sure the model has an ID (should be available after creation)
            if ($testPurchase->id) {
                $referralService = app(ReferralService::class);

                $referralService->calculateAndCreateCommission(
                    $testPurchase->user,
                    'test_purchase',
                    $testPurchase->id,
                    (float) $testPurchase->amount
                );
            }
        });
    }
}
