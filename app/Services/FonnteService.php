<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    public function send(array|string $targets, string $message): array
    {
        $targets = is_array($targets) ? array_values(array_filter($targets)) : [$targets];

        if (empty($targets) || trim($message) === '') {
            return ['status' => false, 'detail' => 'Target atau pesan kosong'];
        }

        $response = Http::asForm()
            ->timeout(15)
            ->withHeaders([
                'Authorization' => config('services.fonnte.token'),
            ])
            ->post('https://api.fonnte.com/send', [
                'target' => implode(',', $targets),
                'message' => $message,
                'countryCode' => '0',
            ]);

        if ($response->failed()) {
            return [
                'status' => false,
                'detail' => 'Gagal menghubungi Fonnte',
                'http_status' => $response->status(),
                'body' => $response->json(),
            ];
        }

        return $response->json();
    }
}
