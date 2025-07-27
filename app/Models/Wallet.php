<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function charge(int $amount, string $description = null): WalletTransaction
    {
        $this->increment('balance', $amount);

        return $this->transactions()->create([
            'amount' => $amount,
            'type' => 'charge',
            'description' => $description,
            'status' => 'completed',
        ]);
    }

    public function purchase(int $amount, string $description = null): ?WalletTransaction
    {
        if ($this->balance < $amount) {
            return null;
        }

        $this->decrement('balance', $amount);

        return $this->transactions()->create([
            'amount' => $amount,
            'type' => 'purchase',
            'description' => $description,
            'status' => 'completed',
        ]);
    }
}
