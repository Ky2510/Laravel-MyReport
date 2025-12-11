<?php

namespace App\Http\Controllers;

use App\Events\ActivityEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActivityController extends Controller
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
            $query = Activity::funcActivitySearch($search);
            $recordsTotal = $query->count();

            $data = ActivityResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function store(StoreActivityRequest $activity)
    {
        try {
            $data = Activity::create($activity->validated());

            event(new ActivityEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Activity', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateActivityRequest $request, $id)
    {
        try {
            $data = Activity::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Activity not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }


            $data->update($request->validated());

            event(new ActivityEvent($data, 'updated'));

            return ResponseHelper::success('Successfully update Activity', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Activity::findBy('id', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Activity not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }
            event(new ActivityEvent($data, 'deleted'));
            $data->delete();
            return ResponseHelper::success('Successfully delete Activity');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
