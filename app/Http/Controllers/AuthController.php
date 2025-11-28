<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        return response()->json([
            'message' => 'User registered successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        try {
            $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $user = User::with('roles')->where($loginField, $request->login)->first();

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $role = Role::where('state', 1)->pluck('id');
            $userRoles = $user->roles->pluck('id');

            $canLogin = $userRoles->intersect($role)->isNotEmpty();
            if (!$canLogin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Your role is not allowed to login.'
                ], 403);
            }

            $token = bin2hex(random_bytes(40));
            $user->update(['token' => $token]);

            return response()->json([
                'error' => false,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user->load('roles'),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Validation error',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->update(['token' => null]);

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
