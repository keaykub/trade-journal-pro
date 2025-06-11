<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\User;
use App\Models\Subscription;

class ManageMembers extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    public function approvePayment($paymentId)
    {
        $this->checkAdminAccess();

        $payment = Payment::findOrFail($paymentId);
        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        // สร้าง subscription เมื่ออนุมัติ
        $this->createSubscription($payment);

        session()->flash('success', 'อนุมัติการชำระเงินเรียบร้อยแล้ว');
    }

    public function rejectPayment($paymentId)
    {
        $this->checkAdminAccess();

        $payment = Payment::findOrFail($paymentId);
        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        session()->flash('success', 'ปฏิเสธการชำระเงินเรียบร้อยแล้ว');
    }

    public function updateStatus($paymentId, $newStatus)
    {
        $this->checkAdminAccess();

        $validStatuses = ['pending', 'verified', 'rejected'];
        if (!in_array($newStatus, $validStatuses)) {
            session()->flash('error', 'สถานะไม่ถูกต้อง');
            return;
        }

        $payment = Payment::findOrFail($paymentId);
        $oldStatus = $payment->status;

        $payment->update([
            'status' => $newStatus,
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        // สร้าง subscription เมื่อเปลี่ยนเป็น verified
        if ($newStatus === 'verified' && $oldStatus !== 'verified') {
            $this->createSubscription($payment);
        }

        $statusText = [
            'pending' => 'เปลี่ยนเป็นรอดำเนินการ',
            'verified' => 'อนุมัติ',
            'rejected' => 'ปฏิเสธ'
        ];

        session()->flash('success', $statusText[$newStatus] . 'การชำระเงินเรียบร้อยแล้ว');
    }

    protected function createSubscription($payment)
    {
        // เช็คว่ามี subscription สำหรับ payment นี้แล้วหรือยัง
        $existingSubscription = Subscription::where('payment_id', $payment->id)->first();

        if ($existingSubscription) {
            return; // มี subscription แล้ว ไม่ต้องสร้างใหม่
        }

        // คำนวณวันที่เริ่มต้นและสิ้นสุด
        $startDate = now();
        $endDate = $this->calculateEndDate($startDate, $payment->plan);

        try {
            Subscription::create([
                'user_id' => $payment->user_id,
                'plan_id' => $payment->plan_id,
                'payment_id' => $payment->id,
                'status' => 'active',
                'starts_at' => $startDate,
                'ends_at' => $endDate,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create subscription', [
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function calculateEndDate($startDate, $plan)
    {
        if (!$plan) {
            return $startDate->addMonth(); // default 1 เดือน
        }

        // ปรับตามแผนที่เลือก (สมมติว่ามี duration_months ใน plan)
        $months = $plan->duration_months ?? 1;
        return $startDate->copy()->addMonths($months);
    }

    protected function checkAdminAccess()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    public function render()
    {
        $query = Payment::with(['user', 'plan', 'verifier']);

        // Filter by search
        if (!empty($this->search)) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // สถิติ
        $totalPayments = Payment::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $verifiedPayments = Payment::where('status', 'verified')->count();
        $rejectedPayments = Payment::where('status', 'rejected')->count();

        view()->share([
            'title' => 'จัดการสมาชิก',
            'description' => 'จัดการการชำระเงินและสมาชิก',
        ]);

        return view('livewire.admin.manage-members', [
            'payments' => $payments,
            'totalPayments' => $totalPayments,
            'pendingPayments' => $pendingPayments,
            'verifiedPayments' => $verifiedPayments,
            'rejectedPayments' => $rejectedPayments,
        ])->layout('layouts.main');
    }
}
