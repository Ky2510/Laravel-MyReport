<?php

namespace App\Http\Controllers;

use App\Events\BranchEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\AssignBranchRequest;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class BranchController extends Controller
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
            $query = Branch::funcBranchSearch($search);
            $recordsTotal = $query->count();

            $data = BranchResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreBranchRequest $request)
    {
        try {
            $data = Branch::create($request->validated());

            event(new BranchEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Branch', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateBranchRequest $request, $id)
    {
        try {
            $data = Branch::findBy('id', $id)->first();


            if (!$data) {
                return ResponseHelper::error('Branch not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }


            $data->update($request->validated());

            event(new BranchEvent($data, 'updated'));

            return ResponseHelper::success('Successfully update Branch', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Branch::findBy('id', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Branch not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }
            event(new BranchEvent($data, 'deleted'));
            $data->delete();
            return ResponseHelper::success('Successfully delete Branch');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function assignUser(AssignBranchRequest $request, $id)
    {

        try {
            $data = User::findBy('id', $id)->where('status', true)->first();

            if (!$data) {
                return ResponseHelper::error('User not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update([
                'department_id' => $request->department_id
            ]);

            event(new BranchEvent($data, 'assign_user'));

            return ResponseHelper::success('Successfully assign user department');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
