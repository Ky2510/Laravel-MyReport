<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateActivityRequest extends FormRequest
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
            'id_user'       => 'sometimes|required|exists:users,id',
            'hospital_name' => 'sometimes|required|string|max:255',
            'person_name'   => 'sometimes|required|string|max:255',
            'occupation'    => 'sometimes|nullable|string|max:255',
            'notes'         => 'sometimes|nullable|string',
            'date'          => 'sometimes|required|date',
            'latitude'      => 'sometimes|required|string|max:100',
            'longitude'     => 'sometimes|required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'Please select a user before updating this data.',
            'id_user.exists'   => 'The selected user is not available. Please choose another user.',
            'hospital_name.required' => 'Hospital name cannot be empty.',
            'person_name.required'   => 'Person name cannot be empty.',
            'date.required'          => 'Please enter a valid date.',
            'latitude.required'      => 'Latitude is required.',
            'longitude.required'     => 'Longitude is required.',
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
