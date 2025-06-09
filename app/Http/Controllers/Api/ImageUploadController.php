<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * อัปโหลดรูปภาพหลายไฟล์ (สูงสุด 10) ไปยัง S3
     * รับ array ชื่อ 'images[]'
     * ตอบกลับ: success, รายการไฟล์ (name, path, url, size)
     */
    public function uploadTradeImages(Request $request)
    {
        try {
            $request->validate([
                'images' => 'required|array|max:10',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            $uploadedFiles = [];

            foreach ($request->file('images') as $file) {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = 'trade-images/' . date('Y/m/') . $filename;
                \Log::info("📤 Uploading file: " . $file->getClientOriginalName() . " to path: " . $path);
                // อัปโหลดไป S3
                $status = Storage::disk('s3')->put($path, file_get_contents($file));

                if (!$status) {
                    \Log::error("❌ Upload failed for file: " . $file->getClientOriginalName());
                    continue;
                }

                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'url' => Storage::disk('s3')->url($path),
                    'size' => $file->getSize(),
                ];

                \Log::info("✅ File uploaded successfully: " . Storage::disk('s3')->url($path));
            }

            if (empty($uploadedFiles)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'อัปโหลดสำเร็จ',
                'files' => $uploadedFiles,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'ไฟล์ไม่ถูกต้อง: ' . implode(', ', $e->validator->errors()->all()),
            ], 422);

        } catch (\Exception $e) {
            \Log::error('❗ Upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการอัปโหลด: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ลบรูปภาพจาก S3 ตาม path ที่ส่งมา
     * รับ ['path' => 'trade-images/xxxx/xxxx.jpg']
     */
    public function deleteTradeImage(Request $request)
    {
        try {
            $request->validate([
                'path' => 'required|string'
            ]);

            // เปลี่ยนจาก public เป็น s3
            if (Storage::disk('s3')->exists($request->path)) {
                Storage::disk('s3')->delete($request->path);

                return response()->json([
                    'success' => true,
                    'message' => 'ลบรูปภาพสำเร็จ'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'ไม่พบไฟล์ที่ต้องการลบ'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบไฟล์: ' . $e->getMessage()
            ], 500);
        }
    }
}
