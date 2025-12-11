<?php

namespace App\MyHelper;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SatsetHelper
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.satusehat.base_url');
    }

    public function getAccessToken()
    {
        if (Cache::has('satusehat_access_token')) {
            return Cache::get('satusehat_access_token');
        }

        return $this->generateToken();
    }

    public function generateToken()
    {
        $response = Http::asForm()
            ->withOptions(["verify" => false])
            ->post('https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/accesstoken?grant_type=client_credentials', [
                'client_id' => env('SATUSEHAT_CLIENT_ID'),
                'client_secret' => env('SATUSEHAT_CLIENT_SECRET')
            ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to generate token: " . json_encode($response->json()));
        }

        $accessToken = $response->json()['access_token'];

        // simpan token 14399 detik
        Cache::put('satusehat_access_token', $accessToken, now()->addSeconds(14399));

        return $accessToken;
    }

    public function get($endpoint)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withOptions(["verify" => false])
            ->withHeaders([
                "Authorization" => "Bearer {$accessToken}",
                "Content-Type" => "application/json"
            ])
            ->get($this->baseUrl . $endpoint);

        if (!$response->successful()) {
            return [
                'success' => false,
                'status' => $response->status(),
                'error'  => $response->json()
            ];
        }

        return [
            'success' => true,
            'data' => $response->json()
        ];
    }

    public function getToken()
    {
        $token = Cache::get('satusehat_access_token');
        if (!$token) {
            return null;
        }
        return $token;
    }

    public function request($endpoint, $params = [])
    {
        $token = $this->getToken();

        if (!$token) {
            return [
                'error' => true,
                'message' => 'Unauthorized: token expired or missing'
            ];
        }

        $url = "{$this->baseUrl}{$endpoint}";

        $response = Http::withOptions(['verify' => false])
            ->withToken($token)
            ->get($url, $params);

        return $response->json();
    }
}
