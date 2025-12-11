<?php

namespace App\Swagger;

trait ActivityPlanSwagger
{
    /**
     * @OA\Get(
     *     path="/api/activity-plans",
     *     summary="Get Activity Plan Datatable",
     *     tags={"Activity Plan"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="draw",
     *         in="query",
     *         required=true,
     *         description="Draw counter for DataTables",
     *         @OA\Schema(type="string", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         required=false,
     *         description="Starting index for pagination",
     *         @OA\Schema(type="string", example=0)
     *     ),
     *     @OA\Parameter(
     *         name="length",
     *         in="query",
     *         required=false,
     *         description="Number of items to fetch",
     *         @OA\Schema(type="string", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search keyword",
     *         @OA\Schema(type="string", example="")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="draw", type="integer"),
     *             @OA\Property(property="recordsTotal", type="integer"),
     *             @OA\Property(property="recordsFiltered", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function swaggerIndexAnnotation() {}


    /**
     * @OA\Get(
     *     path="/api/activity-plans/detail/{id}",
     *     summary="Get Activity Plan Detail",
     *     tags={"Activity Plan"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Activity Plan ID",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="draw", type="integer", nullable=true),
     *             @OA\Property(property="recordsTotal", type="integer", nullable=true),
     *             @OA\Property(property="recordsFiltered", type="integer", nullable=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="activityPlanId", type="string"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="startDate", type="string", format="date"),
     *                 @OA\Property(property="endDate", type="string", format="date"),
     *                 @OA\Property(property="priority", type="string", nullable=true),
     *                 @OA\Property(property="progress", type="integer", nullable=true),
     *                 @OA\Property(property="status", type="string", nullable=true),
     *
     *                 @OA\Property(
     *                     property="tasks",
     *                     type="array",
     *                     @OA\Items(type="object")
     *                 ),
     *
     *                 @OA\Property(
     *                     property="user",
     *                     type="object"
     *                 ),
     *
     *                 @OA\Property(
     *                     property="team_members",
     *                     type="array",
     *                     @OA\Items(type="object")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Activity Plan Not Found"
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function swaggerDetailAnnotation() {}

    /**
     * @OA\Get(
     *     path="/api/activity-plans/target-location/{id}",
     *     summary="Get activity plan target detail",
     *     tags={"Activity Plan"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Activity Plan ID",
     *         @OA\Schema(type="string", example="")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="error", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example=null),
     *             @OA\Property(property="data", type="object",
     *                description="Activity plan target data",
     *                example={}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Activity plan not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Activity plan not found")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function swaggerTargetAnnotation() {}


    /**
     * @OA\Get(
     *     path="/api/activity-plans/estimate-time/{id}",
     *     summary="Get Activity Plan Estimate Time",
     *     tags={"Activity Plan"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Activity Plan ID",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="draw", type="integer", nullable=true),
     *             @OA\Property(property="recordsTotal", type="integer", nullable=true),
     *             @OA\Property(property="recordsFiltered", type="integer", nullable=true),
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="startDate", type="string", format="date", example="2025-02-10"),
     *                 @OA\Property(property="endDate", type="string", format="date", example="2025-02-20"),
     *                 @OA\Property(property="priority", type="string", example="High"),
     *                 @OA\Property(property="progress", type="integer", example=70),
     *                 @OA\Property(property="schedule", type="string", example="On Schedule"),
     *                 @OA\Property(property="status", type="string", example="Active")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Activity Plan Not Found"
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function swaggerEstimateAnnotation() {}
}
