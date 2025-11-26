<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with(['roles' => function ($q) {
            $q->select('id', 'name', 'created_at', 'updated_at');
        }])->get();


        $users->each(function ($user) {
            $user->roles->each(function ($role) {
                $role->makeHidden(['pivot']);
            });
        });


        return $users;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User created with role successfully',
            'data' => $user->load('roles'),
        ]);
    }


}
