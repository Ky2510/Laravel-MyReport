<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePlanningActivityRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'budget'             => 'nullable|numeric|min:0',
            'estimated_duration' => 'nullable|integer|min:1',
            'required_resources' => 'nullable|string',
            'risk_level'         => 'nullable|string|in:low,medium,high',
            'dependencies'       => 'nullable|string',
            'stakeholders'       => 'nullable|string',
            'teamMembers'        => 'nullable|array'
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'budget.numeric'             => 'Budget must be a valid number.',
            'budget.min'                 => 'Budget cannot be negative.',

            'estimated_duration.integer' => 'Estimated duration must be a number in days.',
            'estimated_duration.min'     => 'Estimated duration must be at least 1 day.',

            'required_resources.string'  => 'Required resources must be text.',

            'risk_level.in'              => 'Risk level must be one of the following: low, medium, or high.',

            'dependencies.string'        => 'Dependencies must be text.',
            'stakeholders.string'        => 'Stakeholders must be text.',

            'teamMembers.array'          => 'Team members must be a list.',
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
