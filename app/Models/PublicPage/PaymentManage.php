<?php

namespace App\Models\PublicPage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentManage extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ถ้ายังไม่ได้กำหนด table
    protected $table = 'payments';

    // ถ้าใช้ UUID เป็น primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'note',
        'status',
        'verified_by',
        'verified_at',
        'created_at',
        'updated_at',
        'ref_id',
        'slip_url',
    ];

    /**
     * บันทึกข้อมูลการอัปโหลดสลิปทั้งหมด
     *
     * @param array $data
     * @return static
     */
    public static function storeSlipData(array $data): static
    {
        return self::create([
            'user_id'        => $data['user_id'],
            'plan_id'        => $data['plan_id'],
            'amount'         => $data['amount'] ?? 0.0,
            'status'         => $data['status'] ?? 'pending',
            'created_at'    => now(),
            'updated_at'    => now(),
            'slip_url'      => $data['slip_path'],
        ]);
    }

    /**
     * อัปเดตสถานะการชำระเงิน
     *
     * @param string $id
     * @param string $status
     * @return bool
     */
    public static function updateSlipData(array $data): static
    {
        $payment = self::find($data['id']);
        if (!$payment) {
            throw new \Exception('Payment not found');
        }

        $payment->amount        = $data['amount'] ?? $payment->amount;
        $payment->note          = $data['note'] ?? '';
        $payment->status        = $data['status'];
        $payment->verified_by   = null;
        $payment->verified_at   = $data['verified_at'] ?? null;
        $payment->updated_at    = now();
        $payment->ref_id        = $data['ref_id'] ?? null;

        $payment->save();
        return $payment;
    }
}
