<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

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
         'email_verified_at' => 'datetime',
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

    public function isAdmin()
    {
        $adminIds = ['bda6e82b-60f0-4c51-9020-0612f35aa4c7'];
        return in_array($this->id, $adminIds);
    }
}
