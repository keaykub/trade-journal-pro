<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;

class PublicTradeController extends Controller
{
    /**
     * แสดงหน้า Trade ที่แชร์
     */
    public function show($id)
    {
        // ดึงข้อมูล Trade ที่มีการแชร์เท่านั้น
        $trade = Trade::where('id', $id)
                      ->where('is_shared', true)
                      ->with('user:id,name') // ดึงชื่อคนแชร์
                      ->firstOrFail();

        // Force แปลง images เป็น array
        if (is_string($trade->images)) {
            $trade->images = json_decode($trade->images, true) ?? [];
        } elseif (is_null($trade->images)) {
            $trade->images = [];
        }

        // ส่ง AWS URL ไปด้วย
        $awsUrl = env('AWS_URL', 'https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev');

        return view('trades.public', compact('trade', 'awsUrl'));
    }
}
