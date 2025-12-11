<?php

namespace App\Swagger;

trait AuthSwagger
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login user dan generate token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"login","password"},
     *             @OA\Property(property="login", type="string", example="superadmin@mail.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful"
     *     )
     * )
     */
    public function swaggerLoginAnnotation() {}
}
