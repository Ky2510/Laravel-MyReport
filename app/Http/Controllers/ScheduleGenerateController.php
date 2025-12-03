<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Resources\ScheduleGenerateResource;
use App\Models\ScheduleGenerate;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class ScheduleGenerateController extends Controller
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
            $query = ScheduleGenerate::funcScheduleGenerateSearch($search);
            $recordsTotal = $query->count();

            $data = ScheduleGenerateResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
