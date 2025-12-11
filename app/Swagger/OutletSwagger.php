<?php

namespace App\Swagger;

trait OutletSwagger
{
    /**
     * @OA\Get(
     *     path="/api/outlets",
     *     summary="Get list of outlets",
     *     tags={"Outlet"},
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
     * @OA\Post(
     *     path="/api/outlets",
     *     summary="Create new Outlet",
     *     tags={"Outlet"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code","name","type","address","city","province"},
     *
     *             @OA\Property(property="code", type="string", example="OUT-001"),
     *             @OA\Property(property="name", type="string", example="Outlet 1305"),
     *             @OA\Property(property="type", type="string", example="Klinik"),
     *             @OA\Property(property="address", type="string", example="Jl. Pangeran Antasari No. 12"),
     *             @OA\Property(property="city", type="string", example="1305"),
     *             @OA\Property(property="province", type="string", example="13"),
     *             @OA\Property(property="phone", type="string", example="081234567890"),
     *             @OA\Property(property="email", type="string", example="outlet.jaksel@example.com"),
     *             @OA\Property(property="area", type="string", example="Kebayoran Baru")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created Outlet",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Successfully create Outlet"),
     *             @OA\Property(property="data", type="object")
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
    public function swaggerCreateAnnotation() {}
}
