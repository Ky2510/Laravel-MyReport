<?php

namespace App\Http\Controllers;

use App\Events\LeaveEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Http\Resources\LeaveResource;
use App\Models\Leave;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
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
            $query = Leave::funceLeaveSearch($search);

            $recordsTotal = $query->count();

            $data = LeaveResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function store(StoreLeaveRequest $request)
    {
        try {
            $data = Leave::create($request->validated());

            event(new LeaveEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Leave', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateLeaveRequest $request, $id)
    {
        try {
            $data = Leave::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Leave not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update($request->validated());

            event(new LeaveEvent($data, 'updated'));

            return ResponseHelper::success('Successfully update Leave', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $data = Leave::where(['id' =>  $id, 'active' => true])->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Leave not found',
                ], 400);
            }

            $data->update([
                'active' => false
            ]);

            event(new LeaveEvent($data, 'deleted'));

            return response()->json([
                'error' => false,
                'message' => 'Succesfully delete Leave',
                'data'  => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'is_main'           => 'sometimes|boolean',
            'is_cut_main'       => 'sometimes|boolean',
            'is_pay'            => 'sometimes|boolean',
            'required_document' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first()
            ], 400);
        }
        try {
            $data = Leave::where(['id' =>  $id, 'active' => true])->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Leave not found',
                ], 400);
            }

            $data->update($request->only([
                'is_main',
                'is_cut_main',
                'is_pay',
                'required_document'
            ]));

            return response()->json([
                'error' => false,
                'message' => 'Succesfully update status leave',
                'data'  => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
