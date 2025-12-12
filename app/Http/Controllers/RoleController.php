<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        $draw   = $request->input('draw');
        $start  = (!$request->input('start')) ? 0 : (int) $request->input('start');
        $length = (!$request->input('length')) ? 10 : (int) $request->input('length');
        $search = $request->input('search');

        try {
            $data =  Role::when($search != null, function ($query) use ($search) {
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

    // CREATE ROLE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        try {
            // Generate a unique ID for the role
            $roleId = 'role_' . uniqid();

            // Insert the role into database
            DB::table('roles')->insert([
                'id' => $roleId,
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

            // Get the created role
            $role = DB::table('roles')->where('id', $roleId)->first();

            return response()->json([
                'status' => HttpStatusCodes::HTTP_OK,
                'message' => 'Role created successfully',
                'data' => $role
            ], HttpStatusCodes::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    // SHOW DETAIL ROLE
    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:tbl_bank,role_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        try {

            $data = Role::where('role_id', $request->role_id)->first();
            return response()->json([
                'error' => false,
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 400);
        }
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    // UPDATE ROLE
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $role
        ]);
    }

    // DELETE ROLE
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }

    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        if (!auth()->user()->hasRole('super_admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $user = User::findOrFail($userId);

        $role = Role::where('id', $request->role)->first();

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $user->syncRoles([$role->id]);

        // cek user_roles
        $existing = DB::table('user_roles')->where('userId', $userId)->first();

        if ($existing) {

            DB::table('user_roles')
                ->where('userId', $userId)
                ->update([
                    'roleId' => $role->id,
                    'createBy' => auth()->user()->id,
                    'updateBy' => auth()->user()->id,
                    'updatedAt' => now(),
                ]);
        } else {

            DB::table('user_roles')->insert([
                'id' => Str::uuid(),
                'userId' => $userId,
                'roleId' => $role->id,
                'createBy' => auth()->user()->id,
                'updateBy' => auth()->user()->id,
                'updatedAt' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Role assigned successfully',
            'user' => $user
        ]);
    }
}
