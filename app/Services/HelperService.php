<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class HelperService
{
    /**
     * แปลงภาพเป็น base64 ได้ทั้งจาก UploadedFile และจาก path
     *
     * @param UploadedFile|string $file
     * @return string|null
     */
    public function imageToBase64(UploadedFile|string $file): ?string
    {
        try {
            // กรณีเป็น UploadedFile
            if ($file instanceof UploadedFile) {
                $path = $file->getRealPath();
            }
            // กรณีเป็น path แบบ string
            elseif (is_string($file) && File::exists($file)) {
                $path = $file;
            } else {
                return null;
            }

            $content = file_get_contents($path);
            return base64_encode($content);

        } catch (\Throwable $e) {
            logger()->error('Base64 conversion error', [
                'input' => is_string($file) ? $file : $file->getClientOriginalName(),
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    public function calculateEndDateFixed(?Carbon $startDate = null): Carbon
    {
        $start = $startDate ?? now();
        return $start->copy()->addDays(30);
    }
}
