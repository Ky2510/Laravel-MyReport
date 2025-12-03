<?php

namespace App\Http\Controllers;

use App\Events\RuleScheduleEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreRuleScheduleRequest;
use App\Http\Requests\UpdateRuleScheduleRequest;
use App\Http\Resources\RuleScheduleResource;
use App\Models\RuleSchedule;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleScheduleController extends Controller
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
            $query = RuleSchedule::funcRuleScheduleSearch($search);
            $recordsTotal = $query->count();

            $data = RuleScheduleResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function store(StoreRuleScheduleRequest $request)
    {
        try {
            $data = RuleSchedule::create($request->validated());

            event(new RuleScheduleEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Rule Schedule', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateRuleScheduleRequest $request, $id)
    {
        try {
            $data = RuleSchedule::findBy('id', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Rule Schedule not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update($request->validated());

            event(new RuleScheduleEvent($data, 'updated'));

            return ResponseHelper::success('Successfully updated Rule Schedule', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = RuleSchedule::where('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Rule Schedule not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            event(new RuleScheduleEvent($data, 'deleted'));

            $data->delete();

            return ResponseHelper::success('Successfully deleted Rule Schedule');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
