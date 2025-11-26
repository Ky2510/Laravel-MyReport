<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboardSuperAdmin()
    {
        return response()->json([
            'message' => 'Welcome Super Admin',
            'status' => 'success'
        ]);
    }

    public function dashboardAdmin()
    {
        return response()->json([
            'message' => 'Welcome Admin',
            'status' => 'success'
        ]);
    }
}
