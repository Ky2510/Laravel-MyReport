<?php

namespace App\Http\Controllers;

use App\Models\RuleSchedule;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleScheduleController extends Controller
{
    public function index(Request $request)
    {

        $draw   = $request->input('draw');
        $start  = (!$request->input('start')) ? 0 : (int) $request->input('start');
        $length = (!$request->input('length')) ? 10 : (int) $request->input('length');
        $search = $request->input('search');

        try {
            $data =  RuleSchedule::with('department')->when($search != null, function ($query) use ($search) {
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
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255|unique:rule_schedules,name',
            'check_in'       => 'required|date_format:H:i:s',
            'check_out'      => 'required|date_format:H:i:s',
            'overtime_after' => 'required|integer|min:0',
            'max_after'      => 'required|integer|min:0',
            'max_att'        => 'required|date_format:H:i:s',
            'is_shift'       => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = RuleSchedule::create([
                'department_id' => $request->department_id,
                'name' => $request->name,
                'check_in'  => $request->check_in,
                'check_out' => $request->check_out,
                'overtime_after' => $request->overtime_after,
                'max_after' => $request->max_after,
                'max_att' => $request->max_att,
                'is_shift' => $request->is_shift
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully create Rule Schedule',
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
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255|exists:rule_schedules,name',
            'check_in'       => 'required|date_format:H:i:s',
            'check_out'      => 'required|date_format:H:i:s',
            'overtime_after' => 'required|integer|min:0',
            'max_after'      => 'required|integer|min:0',
            'max_att'        => 'required|date_format:H:i:s',
            'is_shift'       => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0]
            ], 400);
        }

        try {
            $data = RuleSchedule::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Rule Schedulle not found',
                ], 400);
            }

            $data->update([
                'department_id' => $request->department_id,
                'name' => $request->name,
                'check_in'  => $request->check_in,
                'check_out' => $request->check_out,
                'overtime_after' => $request->overtime_after,
                'max_after' => $request->max_after,
                'max_att' => $request->max_att,
                'is_shift' => $request->is_shift
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Succesfully create Rule Schedule',
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
            $data = RuleSchedule::where('id', $id)->first();

            if (!$data) {
                return response()->json([
                    'error' => true,
                    'message' => 'Rule schedule not found',
                ], 400);
            }

            $data->delete();

            return response()->json([
                'error' => false,
                'message' => 'Succesfully delete Rule Schedule',
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
