<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Resources\TeamMemberResource;
use App\Models\TeamMember;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
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
            $query = TeamMember::funcTeamMemberSearch($search);

            $recordsTotal = $query->count();

            $data = TeamMemberResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
