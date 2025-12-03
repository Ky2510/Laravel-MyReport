<?php

namespace App\MyHelper;

use App\MyHelper\Constants\HttpStatusCodes;

class ResponseHelper
{
    public static function datatable($draw, $recordsTotal, $data, $error = false, $status = HttpStatusCodes::HTTP_OK)
    {
        return response()->json([
            'error' => $error,
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data,
        ], $status);
    }


    public static function success(string $message, $data = null, int $status = HttpStatusCodes::HTTP_OK)
    {
        return response()->json([
            'error'   => false,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error(string $message, int $status = HttpStatusCodes::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
        ], $status);
    }
}
