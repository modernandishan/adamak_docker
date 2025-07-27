<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'description',
        'status',
        'transaction_id',
        'tracking_code',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
