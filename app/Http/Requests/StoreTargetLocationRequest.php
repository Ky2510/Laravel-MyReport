<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTargetLocationRequest extends FormRequest
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
            'targetOutlet' => 'nullable|string|max:191',
            'reason' => 'nullable|string|max:191',
            'teamMembers' => 'nullable|array',
            'targetPerson' => 'nullable|string|max:191',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'target_location' => 'nullable|string',
            'priority'        => 'nullable|in:low,medium,high'
        ];
    }

    public function messages(): array
    {
        return [
            'teamMembers.array'          => 'Team members must be a list.',
            'priority.in'                => 'Priority must be one of: low, medium, high.',
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
