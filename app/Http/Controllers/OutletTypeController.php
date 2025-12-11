<?php

namespace App\Http\Controllers;

use App\Events\OutletTypeEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreOutletTypeRequest;
use App\Http\Requests\UpdateOutletTypeRequest;
use App\Http\Resources\OutletTypeResource;
use App\Models\OutletType;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use App\Swagger\OutletTypeSwagger;
use Illuminate\Http\Request;

class OutletTypeController extends Controller
{
    use DatatableValidation, OutletTypeSwagger;

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
            $query = OutletType::funcOutletTypeSearch($search);
            $recordsTotal = $query->count();

            $data = OutletTypeResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreOutletTypeRequest $request)
    {
        try {
            $data = OutletType::create($request->validated());

            event(new OutletTypeEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Outlet Type', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateOutletTypeRequest $request, $id)
    {
        try {
            $data = OutletType::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Outlet type not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update($request->validated());

            event(new OutletTypeEvent($data, 'updated'));

            return ResponseHelper::success('Successfully create Outlet Type', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = OutletType::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Outlet type not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            event(new OutletTypeEvent($data, 'deleted'));

            $data->delete();

            return ResponseHelper::success('Successfully delete Outlet Type');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
