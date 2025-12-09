<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => [
                'sometimes',
                'required',
                Rule::in(['pending', 'in_progress', 'done'])
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Task name is required.',
            'name.string'   => 'Task name must be a valid text.',
            'name.max'      => 'Task name cannot exceed 255 characters.',

            'description.string' => 'Description must be a valid text.',

            'status.required' => 'Status is required when updating the task.',
            'status.in'       => 'Invalid status value. Allowed values: pending, on_progress, done.',
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
