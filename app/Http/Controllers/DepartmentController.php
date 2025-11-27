<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {

        $draw   = $request->input('draw');
        $start  = (!$request->input('start')) ? 0 : (int) $request->input('start');
        $length = (!$request->input('length')) ? 10 : (int) $request->input('length');
        $search = $request->input('search');

        try {
            $data =  Department::when($search != null, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

            $data->status = true;

            return response()->json([
                'error' => false,
                'draw' => $draw,
                'recordsTotal' => $data->count(),
                'recordsFiltered' => $data->count(),
                'data' => $data->offset($start)->limit($length)->orderBy('name')->get()
            ], HttpStatusCodes::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255|unique:departments,name',
            'status'         => 'nullable|boolean',
            'activate_notif'     => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = Department::create([
                'name' => $request->name,
                'status' => $request->status ?? true,
                'activate_notif' => $request->activate_notif ?? false
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully create Department',
                'data'  => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'status'         => 'nullable|boolean',
            'activate_notif'     => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = Department::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Department not found',
                ], 400);
            }

            $data->update([
                'name' => $request->name,
                'status' => $request->status ?? true,
                'activate_notif' => $request->activate_notif ?? false,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully update Department',
                'data'  => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function destroy($id)
    {
        try {
            $data = Department::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Department not found',
                ], 400);
            }

            $data->update([
                'status' => false
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully delete Department',
                'data'  => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function assignUser(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = User::where(['id' => $id, 'status' => 1])->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found'
                ], 404);
            }

            $data->update([
                'department_id' => $request->department_id
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully assign department user',
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
