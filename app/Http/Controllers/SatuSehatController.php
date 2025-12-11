<?php

namespace App\Http\Controllers;

use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\SatsetHelper;
use Illuminate\Http\Request;

class SatuSehatController extends Controller
{

    public function generateToken(SatsetHelper $svc)
    {
        try {
            $token = $svc->generateToken();

            return response()->json([
                "success" => true,
                "access_token" => $token
            ], HttpStatusCodes::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Failed to generate token",
                "error" => $e->getMessage()
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function provinces(Request $request, SatsetHelper $svc)
    {
        $data = $svc->request("/masterdata/v1/provinces", [
            "codes" => $request->codes
        ]);

        return response()->json($data);
    }

    public function cities(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            "province_code" => "required"
        ]);

        $data = $svc->request("/masterdata/v1/cities", [
            "province_codes" => $request->province_code
        ]);

        return response()->json($data);
    }

    public function districts(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            'city_code' => 'required',
        ]);

        $data = $svc->request("/masterdata/v1/districts", [
            "city_codes" => $request->city_code
        ]);

        return response()->json($data);
    }

    public function villages(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            'district_code' => 'required',
        ]);

        $data = $svc->request("/masterdata/v1/sub-districts", [
            "district_codes" => $request->district_code
        ]);

        return response()->json($data);
    }

    public function hospitals(Request $request, SatsetHelper $svc)
    {
        $params = [
            "limit"          => $request->get('limit', 10),
            "page"           => $request->get('page', 1),
            "jenis_sarana"   => 104,
            "kode_sarana"    => $request->kode_sarana,
            "kode_satu_sehat" => $request->kode_satu_sehat,
            "nama"           => $request->nama,
            "kode_provinsi"  => $request->kode_provinsi,
            "kode_kabkota"   => $request->kode_kabkota,
            "kode_kecamatan" => $request->kode_kecamatan,
            "status_aktif"   => $request->status_aktif,
            "status_sarana"  => $request->status_sarana,
        ];

        $data = $svc->request("/masterdata/v1/mastersaranaindex/mastersarana", $params);

        return response()->json($data);
    }

    public function hospitalsByProvince(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            "province_code" => "required"
        ]);

        $data = $svc->request("/masterdata/v1/mastersaranaindex/mastersarana", [
            "limit" => $request->limit ?? 10,
            "page"  => $request->page ?? 1,
            "jenis_sarana" => 104,
            "kode_provinsi" => $request->province_code
        ]);

        return response()->json($data);
    }

    public function hospitalsByCity(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            "city_code" => "required"
        ]);

        $data = $svc->request("/masterdata/v1/mastersaranaindex/mastersarana", [
            "limit" => $request->limit ?? 10,
            "page"  => $request->page ?? 1,
            "jenis_sarana" => 104,
            "kode_kabkota" => $request->city_code
        ]);

        return response()->json($data);
    }

    public function hospitalsByDistrict(Request $request, SatsetHelper $svc)
    {
        $request->validate([
            "district_code" => "required"
        ]);

        $data = $svc->request("/masterdata/v1/mastersaranaindex/mastersarana", [
            "limit" => $request->limit ?? 10,
            "page"  => $request->page ?? 1,
            "jenis_sarana" => 104,
            "kode_kecamatan" => $request->district_code
        ]);

        return response()->json($data);
    }
}
