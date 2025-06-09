<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid();
            }
        });
    }

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'default_lot_size' => 'float',
        'risk_percentage' => 'float',
        'auto_calculate_rr' => 'boolean',
        'show_pips' => 'boolean',
        'email_notifications' => 'boolean',
        'daily_reminder' => 'boolean',
        'weekly_report' => 'boolean',
        'trade_alerts' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $guarded = [];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function stats()
    {
        return $this->hasMany(UserStat::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'verified')
            ->exists();
    }

    public function currentPlanName()
    {
        return $this->subscriptions()
            ->where('status', 'verified')
            ->orderByDesc('start_date')
            ->first()?->plan?->name;
    }
}
