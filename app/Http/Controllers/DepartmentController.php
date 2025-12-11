<?php

namespace App\Http\Controllers;

use App\Events\DepartmentEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\AssignDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use App\Swagger\DepartmentSwagger;
use Illuminate\Http\Request;


/**
 * @OA\Tag(name="Department", description="API untuk Department")
 */

class DepartmentController extends Controller
{
    use DatatableValidation, DepartmentSwagger;



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
            $query = Department::funcDepartmentByStatus($search);
            $recordsTotal = $query->count();

            $data = DepartmentResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function store(StoreDepartmentRequest $request)
    {
        try {
            $data = Department::create($request->validated());

            event(new DepartmentEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Department', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {
        try {
            $data = Department::findBy('id', $id)->where('status', true)->first();

            if (!$data) {
                return ResponseHelper::error('Department not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update($request->validated());

            event(new DepartmentEvent($data, 'updated'));

            return ResponseHelper::success('Successfully create Department', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Department::findBy('id', $id)->where('status', true)->first();

            if (!$data) {
                return ResponseHelper::error('User not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            event(new DepartmentEvent($data, 'deleted'));

            $data->update([
                'status' => false
            ]);


            return ResponseHelper::success('Successfully delete Department');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function assignUser(AssignDepartmentRequest $request, $id)
    {

        try {
            $data = User::findBy('id', $id)->where('status', true)->first();

            if (!$data) {
                return ResponseHelper::error('User not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update([
                'department_id' => $request->department_id
            ]);

            event(new DepartmentEvent($data, 'assign_user'));

            return ResponseHelper::success('Successfully assign user department');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
