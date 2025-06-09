<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ใช้ Livewire Dashboard แทน
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:20',
            'order_type' => 'required|in:buy,sell',
            'entry_date' => 'required|date',
            'entry_time' => 'nullable|date_format:H:i',
            'entry_price' => 'required|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
            'take_profit' => 'nullable|numeric|min:0',
            'exit_date' => 'nullable|date',
            'exit_time' => 'nullable|date_format:H:i',
            'exit_price' => 'nullable|numeric|min:0',
            'lot_size' => 'nullable|numeric|min:0',
            'pnl' => 'nullable|numeric',
            'risk_reward' => 'nullable|numeric|min:0',
            'strategy' => 'required|string|max:50',
            'custom_strategy' => 'nullable|string|max:100',
            'result' => 'required|in:win,loss,breakeven,pending',
            'emotion_before' => 'nullable|string|max:50',
            'emotion_after' => 'nullable|string|max:50',
            'analysis' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
            'chart_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('chart_image')) {
            $validated['chart_image'] = $request->file('chart_image')->store('charts', 'public');
        }

        // Add user_id
        $validated['user_id'] = Auth::id();

        $trade = Trade::create($validated);

        return redirect()->route('trade.show', $trade)
                        ->with('success', 'บันทึกการเทรดเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // ดึงข้อมูล Trade ที่เป็นของ user ที่ login
        $trade = Trade::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->with('user:id,name') // ดึงข้อมูล user (แม้จะเป็นตัวเอง)
                      ->firstOrFail();

        // Force แปลง images เป็น array
        if (is_string($trade->images)) {
            $trade->images = json_decode($trade->images, true) ?? [];
        } elseif (is_null($trade->images)) {
            $trade->images = [];
        }

        // ส่ง AWS URL ไปด้วย
        $awsUrl = env('AWS_URL', 'https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev');

        // คำนวณข้อมูลเพิ่มเติม
        $additionalData = $this->calculateTradeStats($trade);

        return view('trades.show', compact('trade', 'awsUrl', 'additionalData'));
    }

    private function calculateTradeStats($trade)
    {
        $data = [];

        // คำนวณ Duration (ถ้ามีวันที่ออก)
        if ($trade->exit_date) {
            $entryDateTime = \Carbon\Carbon::parse($trade->entry_date . ' ' . ($trade->entry_time ?? '00:00:00'));
            $exitDateTime = \Carbon\Carbon::parse($trade->exit_date . ' ' . ($trade->exit_time ?? '00:00:00'));

            $data['duration'] = $entryDateTime->diff($exitDateTime);
            $data['durationText'] = $this->formatDuration($data['duration']);
        }

        // คำนวณ Risk Amount (ถ้ามี stop loss)
        if ($trade->stop_loss && $trade->entry_price && $trade->lot_size) {
            $pipDifference = abs($trade->entry_price - $trade->stop_loss);
            $data['riskAmount'] = $pipDifference * $trade->lot_size * 100000; // สำหรับ forex standard lot
        }

        // คำนวณ % Return (ถ้ามีข้อมูลครบ)
        if ($trade->pnl && isset($data['riskAmount']) && $data['riskAmount'] > 0) {
            $data['returnPercentage'] = round(($trade->pnl / $data['riskAmount']) * 100, 2);
        }

        // สถิติเปรียบเทียบกับเทรดอื่น ๆ
        $userTrades = Trade::where('user_id', auth()->id())->get();
        if ($userTrades->count() > 1) {
            $data['userStats'] = [
                'totalTrades' => $userTrades->count(),
                'averagePnl' => $userTrades->avg('pnl'),
                'bestTrade' => $userTrades->max('pnl'),
                'worstTrade' => $userTrades->min('pnl'),
                'rankInPnl' => $this->getRankInPnl($trade, $userTrades),
            ];
        }

        return $data;
    }

    private function formatDuration($duration)
    {
        $parts = [];

        if ($duration->d > 0) {
            $parts[] = $duration->d . ' วัน';
        }
        if ($duration->h > 0) {
            $parts[] = $duration->h . ' ชั่วโมง';
        }
        if ($duration->i > 0) {
            $parts[] = $duration->i . ' นาที';
        }

        return empty($parts) ? 'น้อยกว่า 1 นาที' : implode(' ', $parts);
    }

    /**
     * หาอันดับของ Trade นี้ใน P&L
     */
    private function getRankInPnl($currentTrade, $allTrades)
    {
        $sortedTrades = $allTrades->sortByDesc('pnl')->values();
        $rank = $sortedTrades->search(function ($trade) use ($currentTrade) {
            return $trade->id === $currentTrade->id;
        });

        return $rank !== false ? $rank + 1 : 0;
    }

    /**
     * สำหรับ AJAX - Update trade status
     */
    public function updateStatus(Request $request, $id)
    {
        $trade = Trade::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        $validated = $request->validate([
            'result' => 'required|in:win,loss,breakeven,pending'
        ]);

        $trade->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทสถานะเรียบร้อย',
            'trade' => $trade->fresh()
        ]);
    }

    /**
     * Toggle การแชร์
     */
    public function toggleShare($id)
    {
        $trade = Trade::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        $trade->update(['is_shared' => !$trade->is_shared]);

        $message = $trade->is_shared ? 'เปิดการแชร์แล้ว' : 'ปิดการแชร์แล้ว';

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_shared' => $trade->is_shared,
            'share_url' => $trade->is_shared ? route('trades.public', $trade->id) : null
        ]);
    }

    /**
     * ลบเทรด
     */
    public function destroy($id)
    {
        $trade = Trade::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        // TODO: ลบรูปภาพใน storage ด้วย
        // if ($trade->images) {
        //     foreach ($trade->images as $image) {
        //         Storage::delete($image['path']);
        //     }
        // }

        $trade->delete();

        return redirect()->route('trade-list')
                        ->with('success', 'ลบเทรดเรียบร้อยแล้ว');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trade $trade)
    {
        // ตรวจสอบว่าเป็นเจ้าของ
        if ($trade->user_id !== Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์แก้ไขข้อมูลนี้');
        }

        return view('trades.edit', compact('trade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trade $trade)
    {
        // ตรวจสอบว่าเป็นเจ้าของ
        if ($trade->user_id !== Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์แก้ไขข้อมูลนี้');
        }

        $validated = $request->validate([
            'symbol' => 'required|string|max:20',
            'order_type' => 'required|in:buy,sell',
            'entry_date' => 'required|date',
            'entry_time' => 'nullable|date_format:H:i',
            'entry_price' => 'required|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
            'take_profit' => 'nullable|numeric|min:0',
            'exit_date' => 'nullable|date',
            'exit_time' => 'nullable|date_format:H:i',
            'exit_price' => 'nullable|numeric|min:0',
            'lot_size' => 'nullable|numeric|min:0',
            'pnl' => 'nullable|numeric',
            'risk_reward' => 'nullable|numeric|min:0',
            'strategy' => 'required|string|max:50',
            'custom_strategy' => 'nullable|string|max:100',
            'result' => 'required|in:win,loss,breakeven,pending',
            'emotion_before' => 'nullable|string|max:50',
            'emotion_after' => 'nullable|string|max:50',
            'analysis' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
            'chart_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('chart_image')) {
            // Delete old image if exists
            if ($trade->chart_image) {
                \Storage::disk('public')->delete($trade->chart_image);
            }
            $validated['chart_image'] = $request->file('chart_image')->store('charts', 'public');
        }

        $trade->update($validated);

        return redirect()->route('trade.show', $trade)
                        ->with('success', 'อัปเดตการเทรดเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(Trade $trade)
    {
        // ตรวจสอบว่าเป็นเจ้าของ
        if ($trade->user_id !== Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์ลบข้อมูลนี้');
        }

        // Delete image if exists
        if ($trade->chart_image) {
            \Storage::disk('public')->delete($trade->chart_image);
        }

        $trade->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'ลบการเทรดเรียบร้อยแล้ว');
    } */

    /**
     * Generate share link for trade
     */
    public function generateShareLink(Trade $trade)
    {
        // ตรวจสอบว่าเป็นเจ้าของ
        if ($trade->user_id !== Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์แชร์ข้อมูลนี้');
        }

        // สร้าง share token หากยังไม่มี
        if (!$trade->share_token) {
            $trade->update([
                'share_token' => Str::random(32),
                'is_public' => true,
                'shared_at' => now(),
                'share_settings' => [
                    'show_pnl' => true,
                    'show_analysis' => true,
                    'show_strategy' => true,
                    'show_emotions' => false,
                    'show_notes' => false,
                    'show_exact_prices' => true
                ]
            ]);
        } else {
            // อัปเดตสถานะ public
            $trade->update([
                'is_public' => true,
                'shared_at' => now()
            ]);
        }

        $shareUrl = route('trade.public', $trade->share_token);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'share_url' => $shareUrl,
                'message' => 'สร้างลิงค์แชร์เรียบร้อยแล้ว'
            ]);
        }

        return back()->with('success', 'สร้างลิงค์แชร์เรียบร้อยแล้ว')
                    ->with('share_url', $shareUrl);
    }

    /**
     * Remove share link for trade
     */
    public function removeShareLink(Trade $trade)
    {
        // ตรวจสอบว่าเป็นเจ้าของ
        if ($trade->user_id !== Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์จัดการข้อมูลนี้');
        }

        $trade->update([
            'is_public' => false,
            'shared_at' => null
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'ยกเลิกการแชร์เรียบร้อยแล้ว'
            ]);
        }

        return back()->with('success', 'ยกเลิกการแชร์เรียบร้อยแล้ว');
    }
}
