<?php

namespace App\Models\PublicPage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\HelperService;

class SubscriptionManage extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $table = 'subscriptions';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_id',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * บันทึกข้อมูลการสมัครสมาชิก
     *
     * @param array $data
     * @return static
     */
    public static function storeSubscriptionData(array $data): ?static
    {
        $helperService = new HelperService();
        $existing = self::where('user_id', $data['user_id'])
                        ->orWhere('ref_id', $data['ref_id'] ?? null)
                        ->exists();

        if ($existing) {
            return null;
        }

        return self::create([
            'id'         => (string) Str::uuid(),
            'user_id'    => $data['user_id'],
            'plan_id'    => $data['plan_id'],
            'payment_id' => $data['id'],
            'ref_id'     => $data['ref_id'],
            'start_date' => now(),
            'end_date'   => $helperService->calculateEndDateFixed(),
            'status'     => $data['status'] ?? 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
