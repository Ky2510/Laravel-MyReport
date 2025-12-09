<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreAreaMemberRequest;
use App\Http\Resources\AreaResource;
use App\Models\Area;
use App\Models\AreaMember;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use DatatableValidation;


    public function index(Request $request)
    {

        $validated = $this->validateDatatable($request, [
            // 'exampleExtraRule' => 'required|string',
        ]);

        $draw   = $validated['draw'];
        $start  = $validated['start'] ?? 0;
        $length = $validated['length'] ?? 10;
        $search = $validated['search'] ?? null;
        // $exampleExtraRule = $validated['exampleExtraRule'];

        try {
            $query = Area::funcAreaSearch($search);

            $recordsTotal = $query->count();

            $data = AreaResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function member(StoreAreaMemberRequest $request)
    {
        try {
            $area = $request->validated()['area'];

            $data = AreaMember::membersByArea($area)->get();
            return ResponseHelper::success('Successfully fetch Member', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
