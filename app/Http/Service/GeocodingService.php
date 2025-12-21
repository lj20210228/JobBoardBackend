<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\Http;

class GeocodingService
{
    public function geocode(string $address): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'JobBoardApp/1.0 (kontakt@email.com)'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
            'limit' => 1
        ]);

        if (!$response->successful() || empty($response->json())) {
            return null;
        }

        $data = $response->json()[0];

        return [
            'lat' => (float)$data['lat'],
            'lon' => (float)$data['lon'],
        ];
    }
}
