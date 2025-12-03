<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait DatatableValidation
{
    /**
     * Validasi input datatable dengan rules dinamis
     *
     * @param Request $request
     * @param array $extraRules tambahan atau override rules default
     * @return array validated data
     */
    public function validateDatatable(Request $request, array $extraRules = [])
    {
        $defaultRules = [
            'draw' => 'required|integer',
            'start' => 'sometimes|integer|min:0',
            'length' => 'sometimes|integer|min:1',
            'search' => 'nullable',
        ];

        $rules = array_merge($defaultRules, $extraRules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            abort(response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
            ], 400));
        }

        return $validator->validated();
    }
}
