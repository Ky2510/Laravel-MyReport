<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreTaskActityPlanRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\ActivtyPlan;
use App\Models\Task;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class TaskController extends Controller
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
            $query = Task::funcTaskSearch($search);

            $recordsTotal = $query->count();

            $data = TaskResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            $data = Task::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Task not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }
            $data->update($request->validated());

            $data = ActivtyPlan::findBy('activityPlanId', $data->id_activity_plan)->first();
            if ($data) {
                $totalTasks = $data->tasks()->count();
                $doneTasks  = $data->tasks()->where('status', 'done')->count();

                $progress = $totalTasks > 0 ? ($doneTasks / $totalTasks) * 100 : 0;
                $data->progress = round($progress, 2);
                $data->save();
            }


            event(new TaskEvent($data, 'updated'));

            return ResponseHelper::success('Successfully updated Task', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
