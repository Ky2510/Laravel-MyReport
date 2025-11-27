<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {

        $draw   = $request->input('draw');
        $start  = (!$request->input('start')) ? 0 : (int) $request->input('start');
        $length = (!$request->input('length')) ? 10 : (int) $request->input('length');
        $search = $request->input('search');

        try {
            $data =  Employee::with('department', 'branch')->when($search != null, function ($query) use ($search) {
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
}
