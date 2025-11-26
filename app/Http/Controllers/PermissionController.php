<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);

        Permission::create(['name' => $request->name]);

        return response()->json(['message' => 'Permission created']);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate(['name' => 'required']);

        $permission->update(['name' => $request->name]);

        return response()->json(['message' => 'Permission updated']);
    }

    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return response()->json(['message' => 'Permission deleted']);
    }
}
