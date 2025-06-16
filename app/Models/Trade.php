<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'entry_date' => 'date',
        'exit_date' => 'date',
        'entry_time' => 'string',
        'exit_time' => 'string',
        'entry_price' => 'float',
        'exit_price' => 'float',
        'stop_loss' => 'float',
        'take_profit' => 'float',
        'lot_size' => 'float',
        'pnl' => 'float',
        'pips' => 'float',
        'risk_reward' => 'float',
        'commission' => 'float',
        'swap' => 'float',
        'images' => 'array',
        'tags' => 'array',
        'is_demo' => 'boolean',
        'is_shared' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedEntryDateAttribute()
    {
        return $this->entry_date ? \Carbon\Carbon::parse($this->entry_date)->format('Y-m-d') : null;
    }

    public function getFormattedExitDateAttribute()
    {
        return $this->exit_date ? \Carbon\Carbon::parse($this->exit_date)->format('Y-m-d') : null;
    }
}

