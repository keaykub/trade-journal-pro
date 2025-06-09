<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'id' => 'pro-monthly',
            'name' => 'โปร (รายเดือน)',
            'description' => 'สำหรับเทรดเดอร์จริงจัง',
            'price' => 249.00,
            'duration_days' => 30,
            'features' => json_encode([
                'บันทึกเทรดไม่จำกัด',
                'สถิติและกราฟครบครัน',
                'AI โค้ช (50 คำถาม/วัน)',
                'Export CSV/PDF',
                'แจ้งเตือน Email รายวัน',
                'อัปโหลดรูป 5 รูป/เทรด'
            ]),
            'is_active' => true
        ]);

        Plan::create([
            'id' => 'pro-yearly',
            'name' => 'โปร (รายปี)',
            'description' => 'สำหรับเทรดเดอร์จริงจัง - ประหยัด 20%',
            'price' => 2390.00,
            'duration_days' => 365,
            'features' => json_encode([
                'บันทึกเทรดไม่จำกัด',
                'สถิติและกราฟครบครัน',
                'AI โค้ช (50 คำถาม/วัน)',
                'Export CSV/PDF',
                'แจ้งเตือน Email รายวัน',
                'อัปโหลดรูป 5 รูป/เทรด',
                'ประหยัด ฿1,198 ต่อปี'
            ]),
            'is_active' => true
        ]);

        Plan::create([
            'id' => 'premium-monthly',
            'name' => 'พรีเมียม (รายเดือน)',
            'description' => 'สำหรับเทรดเดอร์มืออาชีพ',
            'price' => 359.00,
            'duration_days' => 30,
            'features' => json_encode([
                'ทุกอย่างในแผนโปร',
                'AI โค้ช ไม่จำกัด',
                'วิเคราะห์ขั้นสูง',
                'แชร์บันทึกเทรดได้',
                'API Access',
                'Priority Support'
            ]),
            'is_active' => true
        ]);

        Plan::create([
            'id' => 'premium-yearly',
            'name' => 'พรีเมียม (รายปี)',
            'description' => 'สำหรับเทรดเดอร์มืออาชีพ - ประหยัด 20%',
            'price' => 4790.00,
            'duration_days' => 365,
            'features' => json_encode([
                'ทุกอย่างในแผนโปร',
                'AI โค้ช ไม่จำกัด',
                'วิเคราะห์ขั้นสูง',
                'แชร์บันทึกเทรดได้',
                'API Access',
                'Priority Support',
                'ประหยัด ฿2,398 ต่อปี'
            ]),
            'is_active' => true
        ]);
    }
}
