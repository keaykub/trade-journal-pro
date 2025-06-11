<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserSettings extends Component
{
    public $activeTab = 'profile';

    // Editable fields
    public $first_name;
    public $last_name;

    // Read-only display fields
    public $user;
    public $isLoading = false;

    protected $rules = [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'first_name.max' => 'ชื่อจริงต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        'last_name.max' => 'นามสกุลต้องมีความยาวไม่เกิน 255 ตัวอักษร',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
    }

    public function save()
    {
        $this->isLoading = true;

        try {
            $this->validate();

            $this->user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
            ]);

            // Refresh user data
            $this->user->refresh();

            session()->flash('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
        } finally {
            $this->isLoading = false;
        }
    }

    public function cancel()
    {
        // Reset to original values
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;

        // Clear validation errors
        $this->resetErrorBag();
    }

    public function render()
    {
        view()->share([
            'title' => 'การตั้งค่าผู้ใช้',
            'description' => 'ปรับแต่งการตั้งค่าบัญชีของคุณ',
        ]);

        return view('livewire.user-settings')
            ->layout('layouts.main');
    }
}
