<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'consultant_id',
        'response_text',
        'recommendations',
        'is_urgent',
        'sent_at',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }
}
