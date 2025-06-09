<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    use HasFactory;

    protected $table = 'user_stats';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'total_trades' => 'integer',
        'win_trades' => 'integer',
        'loss_trades' => 'integer',
        'breakeven_trades' => 'integer',
        'total_pnl' => 'float',
        'gross_profit' => 'float',
        'gross_loss' => 'float',
        'largest_win' => 'float',
        'largest_loss' => 'float',
        'win_rate' => 'float',
        'profit_factor' => 'float',
        'avg_risk_reward' => 'float',
        'avg_hold_time_minutes' => 'integer',
        'max_consecutive_wins' => 'integer',
        'max_consecutive_losses' => 'integer',
        'max_drawdown' => 'float',
        'period_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
