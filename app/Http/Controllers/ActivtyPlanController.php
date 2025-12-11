<?php

namespace App\Http\Controllers;

use App\Events\ActivityPlanEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreActivityPlanDetailRequest;
use App\Http\Requests\StoreActivityPlanRequest;
use App\Http\Requests\StoreEstimateTimeRequest;
use App\Http\Requests\StorePlanningActivityRequest;
use App\Http\Requests\StoreTargetLocationRequest;
use App\Http\Requests\StoreTaskActityPlanRequest;
use App\Http\Resources\ActivityPlanDetailResource;
use App\Http\Resources\ActivityPlanEstimateTimeResource;
use App\Http\Resources\ActivityPlanResource;
use App\Http\Resources\ActivityPlanTargetLocationResource;
use App\Models\ActivtyPlan;
use App\Models\Task;
use App\Models\TeamMember;
use App\MyHelper\ActivityPlanHelper;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use App\Swagger\ActivityPlanSwagger;
use Illuminate\Http\Request;

class ActivtyPlanController extends Controller
{

    use DatatableValidation, ActivityPlanSwagger;


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
            $query = ActivtyPlan::funcActivityPlanSearch($search);
            $recordsTotal = $query->count();

            $data = ActivityPlanResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function showDetail(Request $request, $id)
    {
        try {
            $data = ActivtyPlan::with('tasks', 'user', 'team_members')->findBy('activityPlanId', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Activity plan not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $dataResource = new ActivityPlanDetailResource($data);

            return ResponseHelper::datatable(null, null, $dataResource);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function showTarget(Request $request, $id)
    {
        try {
            $data = ActivtyPlan::with('tasks', 'user', 'outlet.area', 'team_members.user_core.areas')->findBy('activityPlanId', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Activity plan not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $dataResource = new ActivityPlanTargetLocationResource($data);

            return ResponseHelper::datatable(null, null, $dataResource);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function showEstimate(Request $request, $id)
    {
        try {
            $data = ActivtyPlan::with('tasks', 'user', 'team_members')->findBy('activityPlanId', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Activity plan not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $dataResource = new ActivityPlanEstimateTimeResource($data);

            return ResponseHelper::datatable(null, null, $dataResource);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function store(StoreActivityPlanRequest $request)
    {
        try {
            $data = ActivtyPlan::create([
                ...$request->validated(),
                'userId' => auth()->user()->id,
                'createBy' => auth()->user()->id
            ]);


            event(new ActivityPlanEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Activity', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function task(StoreTaskActityPlanRequest $request, $id)
    {
        try {
            $activityPlan = ActivtyPlan::findBy('userId', $id)->first();

            if (!$activityPlan) {
                return ResponseHelper::error('You need to create the activity plan first.', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $activityPlan->update($request->validated());


            if ($request->tasks) {
                foreach ($request->tasks as $task) {
                    Task::create([
                        'id_activity_plan' => $activityPlan->activityPlanId,
                        'id_user'          => auth()->user()->id,
                        'name'             => $task['name'],
                        'description'      => $task['description'] ?? null,
                        'status'           => 'pending',
                    ]);
                }
            }

            $activityPlan->progress = $activityPlan->calculateProgress();
            $activityPlan->save();

            event(new ActivityPlanEvent($activityPlan, 'task created'));

            return ResponseHelper::success('Successfully create task', $activityPlan);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function detail(StoreActivityPlanDetailRequest $request, $id)
    {
        try {
            $activityPlan = ActivtyPlan::findBy('userId', $id)->first();

            if (!$activityPlan) {
                return ResponseHelper::error('You need to create the activity plan first.', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $activityPlan->update($request->validated());
            event(new ActivityPlanEvent($activityPlan, 'Activity plan detail created'));

            return ResponseHelper::success('Successfully create activity plan detail', $activityPlan);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function estimate(StoreEstimateTimeRequest $request, $id)
    {
        try {
            $activityPlan = ActivtyPlan::findBy('userId', $id)->first();

            if (!$activityPlan) {
                return ResponseHelper::error('You need to create the activity plan first.', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $activityPlan->update($request->validated());

            $estimatedDuration = ActivityPlanHelper::estimatedDuration($activityPlan->startDate, $activityPlan->endDate);
            $activityPlan->estimated_duration = $estimatedDuration;
            $activityPlan->save();

            event(new ActivityPlanEvent($activityPlan, 'Activity plan estimate created'));

            return ResponseHelper::success('Successfully create activity plan estimate', $activityPlan);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function target(StoreTargetLocationRequest $request, $id)
    {
        try {
            $activityPlan = ActivtyPlan::findBy('userId', $id)->first();

            if (!$activityPlan) {
                return ResponseHelper::error('You need to create the activity plan first.', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $activityPlan->update($request->validated());


            if ($request->teamMembers) {
                foreach ($request->teamMembers as $tm) {
                    TeamMember::create([
                        'id_activity_plan' => $activityPlan->activityPlanId,
                        'id_user'      => $tm['id_user'] ?? null,
                    ]);
                }
            }

            event(new ActivityPlanEvent($activityPlan, 'Activity plan target created'));

            return ResponseHelper::success('Successfully create activity plan target', $activityPlan);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function planning(StorePlanningActivityRequest $request, $id)
    {
        try {
            $activityPlan = ActivtyPlan::findBy('userId', $id)->first();

            if (!$activityPlan) {
                return ResponseHelper::error('You need to create the activity plan first.', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $activityPlan->update($request->validated());

            if ($request->teamMembers) {
                foreach ($request->teamMembers as $tm) {
                    TeamMember::create([
                        'id_activity_plan' => $activityPlan->activityPlanId,
                        'id_user'      => $tm['id_user'] ?? null,
                    ]);
                }
            }

            event(new ActivityPlanEvent($activityPlan, 'planning created'));

            return ResponseHelper::success('Successfully create planning', $activityPlan);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
