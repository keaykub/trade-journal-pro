<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanupController extends Controller
{
    /**
     * ลบไฟล์รูปภาพที่เก่ากว่า 3 ชั่วโมงใน storage/livewire-tmp/
     * เพื่อป้องกันการลบไฟล์ที่ลูกค้ากำลัง upload อยู่
     */
    public function clearAllTempImages()
    {
        try {
            $path = storage_path('app/livewire-tmp');

            if (!File::exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบโฟลเดอร์ livewire-tmp'
                ], 404);
            }

            $files = File::files($path);
            $deletedCount = 0;
            $skippedCount = 0;
            $cutoffTime = Carbon::now()->subHours(3); // เก่ากว่า 3 ชั่วโมง

            foreach ($files as $file) {
                $fileTime = Carbon::createFromTimestamp($file->getMTime());

                // ลบเฉพาะไฟล์ที่เก่ากว่า 3 ชั่วโมง
                if ($fileTime->lt($cutoffTime)) {
                    File::delete($file->getPathname());
                    $deletedCount++;
                } else {
                    $skippedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "ลบไฟล์เก่าสำเร็จ {$deletedCount} ไฟล์, ข้าม {$skippedCount} ไฟล์ที่ใหม่",
                'deleted_count' => $deletedCount,
                'skipped_count' => $skippedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }
}
