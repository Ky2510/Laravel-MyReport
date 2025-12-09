<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreActivityPlanDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'budget' => 'nullable|numeric',
            'estimated_duration' => 'nullable|integer',
            'attachment' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'required_resources' => 'nullable|string',
            'risk_level' => 'nullable|in:low,medium,high',
            'outcome_expected' => 'nullable|string',
            'success_criteria' => 'nullable|string',
            'dependencies' => 'nullable|string',
            'stakeholders' => 'nullable|string',
            'tasks' => 'nullable|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error'   => true,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], HttpStatusCodes::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
