<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('ยืนยันอีเมลของคุณ - WickFill')
                ->greeting('สวัสดี!')
                ->line('ขอบคุณที่เข้าร่วมกับ **WickFill** - แพลตฟอร์มบันทึกการเทรด!')
                ->line('เพื่อเริ่มใช้งานระบบ กรุณายืนยันที่อยู่อีเมลของคุณโดยคลิกปุ่มด้านล่าง')
                ->action('✅ ยืนยันอีเมลของฉัน', $url)
                ->line('การยืนยันอีเมลจะช่วยให้:')
                ->line('• บัญชีของคุณปลอดภัยมากขึ้น')
                ->line('• ได้รับการแจ้งเตือนเกี่ยวกับการบันทึกเทรด')
                ->line('• สามารถกู้คืนรหัสผ่านได้ในอนาคต')
                ->line('หากคุณไม่ได้สมัครบัญชีนี้ ไม่ต้องดำเนินการใดๆ เพิ่มเติม')
                ->salutation("ขอแสดงความนับถือ,\n**ทีมงาน WickFill**\n\n© " . date('Y') . " WickFill. สงวนลิขสิทธิ์\nอีเมลนี้ส่งโดยอัตโนมัติ กรุณาอย่าตอบกลับ");
        });
    }
}
