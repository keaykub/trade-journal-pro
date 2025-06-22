<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trade;

class TradeDetail extends Component
{
    public $tradeId;
    public $trade;

    public function mount($id)
    {
        if (!auth()->user()?->hasVerifiedEmail()) {
            redirect()->route('verification.notice');
        }

        $this->tradeId = $id;

        // ดึงข้อมูล Trade ที่เป็นของ user ที่ login
        $this->trade = Trade::where('id', $this->tradeId)
                           ->where('user_id', auth()->id())
                           ->with('user:id,name')
                           ->firstOrFail();

        // Force แปลง images เป็น array
        if (is_string($this->trade->images)) {
            $this->trade->images = json_decode($this->trade->images, true) ?? [];
        } elseif (is_null($this->trade->images)) {
            $this->trade->images = [];
        }
    }

    public function toggleShare()
    {
        $this->trade->update(['is_shared' => !$this->trade->is_shared]);

        $message = $this->trade->is_shared ? 'เปิดการแชร์แล้ว' : 'ปิดการแชร์แล้ว';

        session()->flash('success', $message);

        // Dispatch event สำหรับ JavaScript
        $this->dispatch('share-toggled', [
            'is_shared' => $this->trade->is_shared,
            'share_url' => $this->trade->is_shared ? route('trades.public', $this->trade->id) : null,
            'message' => $message
        ]);
    }

    public function updateStatus($status)
    {
        $validStatuses = ['win', 'loss', 'breakeven', 'pending'];

        if (!in_array($status, $validStatuses)) {
            session()->flash('error', 'สถานะไม่ถูกต้อง');
            return;
        }

        $this->trade->update(['result' => $status]);

        session()->flash('success', 'อัพเดทสถานะเรียบร้อย');

        // Refresh trade data
        $this->trade = $this->trade->fresh();
    }

    public function deleteTrade()
    {
        // TODO: ลบรูปภาพใน storage ด้วย
        $this->trade->delete();

        session()->flash('success', 'ลบเทรดเรียบร้อยแล้ว');

        // Redirect ไปหน้า dashboard
        return $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.trade-detail')
               ->layout('layouts.main', [
                   'title' => 'รายละเอียดการเทรด - ' . $this->trade->symbol,
                   'description' => 'ดูรายละเอียดการเทรด ' . $this->trade->symbol
               ]);
    }
}
