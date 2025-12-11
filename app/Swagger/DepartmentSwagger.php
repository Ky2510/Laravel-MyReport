<?php

namespace App\Swagger;

trait DepartmentSwagger
{
    /**
     * @OA\Get(
     *     path="/api/departments",
     *     summary="Get list of departments",
     *     tags={"Department"},
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
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function swaggerIndexAnnotation() {}

    /**
     * Create new Department
     *
     * @OA\Post(
     * path="/api/departments",
     * summary="Create new Department",
     * tags={"Department"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name"},
     * @OA\Property(property="name", type="string", example="", description="")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successfully create Department",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Successfully create Department"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="id", type="string", example=1),
     * @OA\Property(property="name", type="string", example=""),
     * @OA\Property(property="created_at", type="string", example=""),
     * @OA\Property(property="updated_at", type="string", example="")
     * )
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Please enter the branch name."),
     * @OA\Property(property="errors", type="object")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal server error",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Something went wrong")
     * )
     * )
     * )
     */
    public function swaggerCreateAnnotation() {}


    /**
     * @OA\Put(
     *     path="/api/departments/{id}",
     *     summary="Update existing Department",
     *     tags={"Department"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the department to update",
     *         @OA\Schema(type="string", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="New Department Name"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Department updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Successfully updated Department"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="string", example=1),
     *                 @OA\Property(property="name", type="string", example="New Department Name"),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="activate_notif", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", example="2025-12-09T15:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-12-09T16:00:00Z")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Please enter a department name."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function swaggerUpdateAnnotation() {}


    /**
     * @OA\Delete(
     *     path="/api/departments/{id}",
     *     summary="Delete a Department (soft delete)",
     *     tags={"Department"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the department to delete",
     *         @OA\Schema(type="string", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Department deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Successfully delete Report")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Department not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function swaggerDeleteAnnotation() {}
}
