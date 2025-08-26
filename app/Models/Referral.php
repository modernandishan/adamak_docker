<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_id',
        'referred_user_id',
        'referral_token',
        'visitor_ip',
        'user_agent',
        'clicked_at',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'clicked_at' => 'datetime',
            'registered_at' => 'datetime',
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

    public function commissions(): HasMany
    {
        return $this->hasMany(MarketerCommission::class);
    }
}
