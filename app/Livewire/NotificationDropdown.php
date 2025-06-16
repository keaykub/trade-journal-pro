<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationDropdown extends Component
{
    public $notifications = [];

    public function fetchNotifications()
    {
        $this->notifications = [
            [
                'title' => 'Version Demo 1.0 Launch Now!',
                'message' => 'สามารถทดลองใช้งานระบบใหม่ได้แล้ววันนี้',
                'time' => now()->diffForHumans(),
                'new' => true,
                'action' => 'ดูรายละเอียด',
                'type' => 'update',
            ],
            [
                'title' => 'ระบบ export จะเปิดใช้งานเร็วๆ นี้',
                'time' => now()->subHours(2)->diffForHumans()
            ],
        ];
    }

    public function render()
    {
        return view('livewire.notification-dropdown');
    }
}
