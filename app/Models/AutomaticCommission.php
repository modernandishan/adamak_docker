<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomaticCommission extends Model
{
    protected $table = 'automatic_commissions_view'; // This will be a database view

    protected $fillable = [
        'id',
        'type', // 'marketer' or 'consultant'
        'recipient_id',
        'recipient_name',
        'recipient_mobile',
        'test_id',
        'test_title',
        'attempt_id',
        'original_amount',
        'commission_percentage',
        'commission_amount',
        'status',
        'earned_at',
        'paid_at',
        'source_type',
        'source_id',
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'earned_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    public function marketerCommission(): BelongsTo
    {
        return $this->belongsTo(MarketerCommission::class, 'source_id')
            ->where('type', 'marketer');
    }

    public function consultantCommission(): BelongsTo
    {
        return $this->belongsTo(ConsultantCommission::class, 'source_id')
            ->where('type', 'consultant');
    }

    public function getRecipientFullNameAttribute(): string
    {
        return $this->recipient_name;
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'marketer' => 'بازاریاب',
            'consultant' => 'مشاور',
            default => $this->type
        };
    }
}
