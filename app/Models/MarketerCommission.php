<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketerCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_id',
        'referred_user_id',
        'referral_id',
        'commission_source',
        'source_id',
        'original_amount',
        'commission_percentage',
        'commission_amount',
        'status',
        'earned_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'original_amount' => 'decimal:2',
            'commission_percentage' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'earned_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }

    public function referredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class, 'source_id');
    }
}
