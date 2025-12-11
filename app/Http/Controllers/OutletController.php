<?php

namespace App\Http\Controllers;

use App\Events\OutletEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreOutletRequest;
use App\Http\Resources\OutletResource;
use App\Models\Outlet;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class OutletController extends Controller
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
            $query = Outlet::funcOutletSearch($search);
            $recordsTotal = $query->count();

            $data = OutletResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreOutletRequest $request)
    {
        try {
            $data = Outlet::create($request->validated());

            event(new OutletEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Outlet', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    // public function update(UpdateBranchRequest $request, $id)
    // {
    //     try {
    //         $data = Branch::findBy('id', $id)->first();


    //         if (!$data) {
    //             return ResponseHelper::error('Branch not found', HttpStatusCodes::HTTP_NOT_FOUND);
    //         }


    //         $data->update($request->validated());

    //         event(new BranchEvent($data, 'updated'));

    //         return ResponseHelper::success('Successfully update Branch', $data);
    //     } catch (\Throwable $th) {
    //         return ResponseHelper::error($th->getMessage());
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $data = Branch::findBy('id', $id)->first();
    //         if (!$data) {
    //             return ResponseHelper::error('Branch not found', HttpStatusCodes::HTTP_NOT_FOUND);
    //         }
    //         event(new BranchEvent($data, 'deleted'));
    //         $data->delete();
    //         return ResponseHelper::success('Successfully delete Branch');
    //     } catch (\Throwable $th) {
    //         return ResponseHelper::error($th->getMessage());
    //     }
    // }

    // public function assignUser(AssignBranchRequest $request, $id)
    // {

    //     try {
    //         $data = User::findBy('id', $id)->where('status', true)->first();

    //         if (!$data) {
    //             return ResponseHelper::error('User not found', HttpStatusCodes::HTTP_NOT_FOUND);
    //         }

    //         $data->update([
    //             'department_id' => $request->department_id
    //         ]);

    //         event(new BranchEvent($data, 'assign_user'));

    //         return ResponseHelper::success('Successfully assign user department');
    //     } catch (\Throwable $th) {
    //         return ResponseHelper::error($th->getMessage());
    //     }
    // }
}
