<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $draw   = $request->input('draw');
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search');

        try {

            $query = User::where('status', 1)->with(['department', 'branch', 'roles:id,name,created_at,updated_at']);

            $query->when($search != null, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

            $recordsTotal = User::count();
            $recordsFiltered = $query->count();

            $data = $query
                ->orderBy('name', 'asc')
                ->offset($start)
                ->limit($length)
                ->get();

            return response()->json([
                'error'            => false,
                'draw'             => intval($draw),
                'recordsTotal'     => $recordsTotal,
                'recordsFiltered'  => $recordsFiltered,
                'data'             => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'department_id' => $request->department_id,
            ]);

            $role = Role::where('name', $request->role)->first();

            if (!$role) {
                return response()->json([
                    'error' => true,
                    'message' => 'Role not found',
                ], 400);
            }

            if (!$data->roles->contains('id', $role->id)) {
                $data->assignRole($role->id);
            }


            return response()->json([
                'error' => false,
                'message' => 'Succesfully create User',
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
            'username'       => 'sometimes|required',
            'name'           => 'sometimes|required',
            'email'          => 'sometimes|email|unique:users,email,' . $id,
            'password'       => 'sometimes|min:6',
            'role'           => 'sometimes|required|exists:roles,name',
            'department_id'  => 'sometimes|required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {

            $user = User::where(['id' => $id, 'status' => 1])->first();

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found'
                ], 404);
            }

            $user->update([
                'name'          => $request->name ?? $user->name,
                'username'      => $request->username ?? $user->username,
                'email'         => $request->email ?? $user->email,
                'department_id' => $request->department_id ?? $user->department_id,
                'password'      => $request->password ? Hash::make($request->password) : $user->password,
            ]);



            $role = Role::where('name', $request->role)->first();

            if (!$role) {
                return response()->json([
                    'error' => true,
                    'message' => 'Role not found',
                ], 400);
            }

            $user->roles()->detach();
            $user->assignRole($role->id);


            return response()->json([
                'error' => false,
                'message' => 'Successfully updated user',
                'data' => $user->load('roles')
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
            $user = User::where(['id' => $id, 'status' => 1])->first();

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found',
                ], 404);
            }

            $user->update([
                'status' => 0
            ]);

            $user->roles()->detach();


            return response()->json([
                'error' => false,
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
