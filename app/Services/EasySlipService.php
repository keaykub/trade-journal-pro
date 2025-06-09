<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EasySlipService
{
    protected string $apiUrl = 'https://developer.easyslip.com/api/v1/verify';
    protected string $token;

    public function __construct()
    {
        // ควรเก็บ token ไว้ใน .env
        $this->token = config('services.easyslip.token');
    }

    /**
     * ตรวจสอบสลิปผ่าน EasySlip API
     *
     * @param string $base64Image รูปในรูปแบบ base64
     * @return array|null ผลลัพธ์จาก EasySlip หรือ null ถ้า error
     */
    public function verifySlip(string $base64Image): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'image' => $base64Image,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // log error สำหรับ debug
            logger()->error('EasySlip verify error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            logger()->error('EasySlip exception', [
                'message' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * กรองผลลัพธ์จาก EasySlip
     *
     * @param array $result ผลลัพธ์จาก EasySlip
     * @return bool
     */
    public function isValidSlip(array $result): array
    {
        $data = $result['data'] ?? [];

        if (empty($data)) {
            return [
                'status' => false,
                'message' => 'No data found in the response.',
            ];
        }

        return [
            'status'                    => true,
            'transRef'                  => $data['transRef'] ?? null,
            'amount'                    => $data['amount']['amount'] ?? null,
            'receiver_bank_id'          => $data['receiver']['bank']['id'] ?? null,
            'receiver_bank_name'        => $data['receiver']['bank']['name'] ?? null,
            'receiver_bank_short'       => $data['receiver']['bank']['short'] ?? null,
            'receiver_account_name_th'  => $data['receiver']['account']['name']['th'] ?? null,
            'receiver_account_name_en'  => $data['receiver']['account']['name']['en'] ?? null,
            'receiver_account_number'   => $data['receiver']['account']['bank']['account'] ?? null,
            'sender_bank_name'          => $data['sender']['bank']['name'] ?? null,
            'sender_account'            => $data['sender']['account']['bank']['account'] ?? null,
            'date'                      => $data['date'] ?? null,
        ];
    }

}
