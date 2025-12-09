<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Resources\UserCoreResource;
use App\Models\UserCore;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class UserCoreController extends Controller
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
            $query = UserCore::funcUserCoreSearch($search);

            $recordsTotal = $query->count();

            $data = UserCoreResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
