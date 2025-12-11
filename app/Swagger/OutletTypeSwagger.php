<?php

namespace App\Swagger;

trait OutletTypeSwagger
{
    /**
     * @OA\Get(
     *     path="/api/outlet-types",
     *     summary="Get Outlet Types (Datatable)",
     *     description="Mengambil daftar outlet type menggunakan format datatable (draw, start, length, search).",
     *     tags={"Outlet Type"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="draw",
     *         in="query",
     *         required=true,
     *         description="Draw counter for DataTables",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         required=false,
     *         description="Starting index for pagination",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *
     *     @OA\Parameter(
     *         name="length",
     *         in="query",
     *         required=false,
     *         description="Number of items per page",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *
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
     *             @OA\Property(property="draw", type="integer", example=1),
     *             @OA\Property(property="recordsTotal", type="integer", example=100),
     *             @OA\Property(property="recordsFiltered", type="integer", example=100),
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function swaggerOutletTypeAnnotation() {}


    /**
     * Create new Outlet type
     *
     * @OA\Post(
     * path="/api/outlet-types",
     * summary="Create new Outlet Type",
     * tags={"Outlet Type"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name"},
     * @OA\Property(property="name", type="string", example="", description="")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successfully create Outlet Type",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Successfully create Outlet Type"),
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
     *     path="/api/outlet-types/{id}",
     *     summary="Update outlet type",
     *     tags={"Outlet Type"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID of the outlet type",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example=""),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully updated outlet type",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully updated outlet type"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Outlet type not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Outlet type not found")
     *         )
     *     )
     * )
     */

    public function swaggerUpdateAnnotation() {}

    /**
     * @OA\Delete(
     *     path="/api/outlet-types/{id}",
     *     summary="Delete a Outlet Type",
     *     tags={"Outlet Type"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the outlet type to delete",
     *         @OA\Schema(type="string", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Outlet type deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Successfully delete Outlet Type")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Outlet Type not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=""),
     *             @OA\Property(property="message", type="string", example="")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=""),
     *             @OA\Property(property="message", type="string", example="")
     *         )
     *     )
     * )
     */
    public function swaggerDeleteAnnotation() {}
}
