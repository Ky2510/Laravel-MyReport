<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        return DB::table('permissions')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            // Generate a unique ID for the permission
            $permissionId = 'perm_' . uniqid();

            // Insert the permission into database
            DB::table('permissions')->insert([
                'id' => $permissionId,
                'name' => $request->name,
                'state' => 1,
                'guard_name' => 'web',
                'createBy' => null,
                'updateBy' => null,
                'createdAt' => now(),
                'updatedAt' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get the created permission
            $permission = DB::table('permissions')->where('id', $permissionId)->first();

            return response()->json([
                'status' => 200,
                'message' => 'Permission created successfully',
                'data' => $permission
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            DB::table('permissions')->where('id', $id)->update([
                'name' => $request->name,
                'updatedAt' => now(),
                'updated_at' => now()
            ]);

            $permission = DB::table('permissions')->where('id', $id)->first();

            return response()->json([
                'status' => 200,
                'message' => 'Permission updated successfully',
                'data' => $permission
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('permissions')->where('id', $id)->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Permission deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
