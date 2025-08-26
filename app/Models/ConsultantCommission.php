<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultant_id',
        'attempt_id',
        'test_id',
        'test_amount',
        'commission_percentage',
        'commission_amount',
        'status',
        'earned_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'test_amount' => 'decimal:2',
            'commission_percentage' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'earned_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
