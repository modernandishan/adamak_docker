<?php

namespace App\Models;

use App\Services\ConsultantCommissionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attempt extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'family_id',
        'assigned_consultant_id',
        'assigned_at',
        'started_at',
        'completed_at',
        'wallet_transaction_id',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'assigned_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // When an attempt is completed, create consultant commission
        static::updated(function ($attempt) {
            if ($attempt->wasChanged('completed_at') && $attempt->completed_at && $attempt->assigned_consultant_id) {
                $commissionService = app(ConsultantCommissionService::class);
                $commissionService->calculateAndCreateCommission($attempt);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(WalletTransaction::class, 'wallet_transaction_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function assignedConsultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_consultant_id');
    }

    public function consultantCommission(): HasOne
    {
        return $this->hasOne(ConsultantCommission::class);
    }

    public function consultantResponse(): HasOne
    {
        return $this->hasOne(ConsultantResponse::class);
    }
}
