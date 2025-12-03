<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Resources\LeaveResource;
use App\Models\LeaveDays;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class LeaveDaysController extends Controller
{
    use DatatableValidation;

    public function index(Request $request)
    {

        $validated = $this->validateDatatable($request, [
            // 'exampleExtraRule' => 'required|string',
        ]);

        $draw   = $validated['draw'];
        $start  = $validated['start'] ?? 0;
        $length = $validated['length'] ?? 10;
        $search = $validated['search'] ?? null;
        // $exampleExtraRule = $validated['exampleExtraRule'];

        try {
            $query = LeaveDays::funcLeaveDaysSearch($search);

            $recordsTotal = $query->count();

            $data = LeaveResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
