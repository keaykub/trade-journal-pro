<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string'; // ใช้ slug เช่น 'pro-monthly'

    public $timestamps = true;

    protected $casts = [
        'price' => 'float',
        'duration_days' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'id', 'name', 'description', 'price', 'duration_days', 'features', 'is_active'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Optional: scope plan ที่ยัง active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
