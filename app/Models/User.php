<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'family',
        'mobile',
        'password',
        'referral_token',
        'commission_percentage',
        'referred_by',
        'referral_cookie_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
            'commission_percentage' => 'decimal:2',
            'referral_cookie_expires_at' => 'datetime',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    // در مدل User
    public function purchasedTests()
    {
        return $this->belongsToMany(Test::class, 'test_user_purchases')
            ->using(TestUserPurchase::class)
            ->withPivot('amount', 'wallet_transaction_id', 'purchased_at');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function consultantBiography(): HasOne
    {
        return $this->hasOne(ConsultantBiography::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return false;
        // return redirect()->back();
    }

    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class, 'mobile', 'mobile');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'marketer_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(MarketerCommission::class, 'marketer_id');
    }

    public function referredBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referred_by');
    }

    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function assignedAttempts(): HasMany
    {
        return $this->hasMany(Attempt::class, 'assigned_consultant_id');
    }
}
