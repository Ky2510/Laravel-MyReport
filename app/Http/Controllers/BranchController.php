<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index(Request $request)
    {

        $draw   = $request->input('draw');
        $start  = (!$request->input('start')) ? 0 : (int) $request->input('start');
        $length = (!$request->input('length')) ? 10 : (int) $request->input('length');
        $search = $request->input('search');

        try {
            $data =  Branch::when($search != null, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

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
            'name'           => 'required|string|max:255|unique:branches,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {

            $data = Branch::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully create Branches',
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
            'name' => 'required|string|max:255|unique:branches,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = Branch::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Branch not found',
                ], 400);
            }

            $data->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully update Branch',
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
            $data = Branch::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Branch not found',
                ], 400);
            }

            $data->delete();

            return response()->json([
                'error' => false,
                'message' => 'Succesfully delete Branch',
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
            'branch_id' => 'required|exists:branches,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = User::where(['id' => $id])->first();
            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found'
                ], 404);
            }

            $data->update([
                'branch_id' => $request->branch_id
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully assign branch user',
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
