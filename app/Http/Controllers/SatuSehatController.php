<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SatuSehatController extends Controller
{
    public function generateToken()
    {
        try {
            $url = config('services.satusehat.base_url') . '/oauth2/v1/accesstoken?grant_type=client_credentials';

            $response = Http::asForm()
                ->withOptions(["verify" => false])
                ->post($url, [
                    config('services.satusehat.client_id'),
                    config('services.satusehat.client_secret')
                ]);



            if (!$response->successful()) {
                return response()->json([
                    'message' => 'Failed to get token',
                    'error' => $response->json()
                ], $response->status());
            }


            $data = $response->json();
            $accessToken = $data['access_token'];

            Cache::put('satusehat_access_token', $accessToken, now()->addSeconds(14399));

            return response()->json(['access_token' => $accessToken], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function hospital(Request $request)
    {
        try {
            $accessToken = Cache::get('satusehat_access_token');
            if (!$accessToken) {
                return response()->json([
                    'message' => 'Unauthorized: Access token is missing or expired, please regenerate the token'
                ], 401);
            }

            // Ambil limit & page dari request, default jika tidak ada
            $limit = $request->get('limit', 10);
            $page  = $request->get('page', 1);
            $kode_sarana  = $request->get('kode_sarana');
            $kode_satu_sehat  = $request->get('kode_satu_sehat');
            $nama  = $request->get('nama');
            $kode_provinsi  = $request->get('kode_provinsi');
            $kode_kabkota  = $request->get('kode_kabkota');
            $kode_kecamatan  = $request->get('kode_kecamatan');
            $status_aktif  = $request->get('status_aktif');
            $status_sarana  = $request->get('status_sarana');

            $url = config('services.satusehat.base_url') . '/masterdata/v1/mastersaranaindex/mastersarana';

            $response = Http::withOptions([
                'verify' => false
            ])->withToken($accessToken)
                ->get($url, [
                    'limit' => $limit,
                    'page'  => $page,
                    'jenis_sarana' => 104,
                    'kode_sarana' => $kode_sarana,
                    'kode_satu_sehat' => $kode_satu_sehat,
                    'nama' => $nama,
                    'kode_provinsi' => $kode_provinsi,
                    'kode_kabkota' => $kode_kabkota,
                    'kode_kecamatan' => $kode_kecamatan,
                    'status_aktif' => $status_aktif,
                    'status_sarana' => $status_sarana,
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'message' => 'Failed to get hospital data',
                    'error'   => $response->json()
                ], $response->status());
            }

            return response()->json($response->json(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
