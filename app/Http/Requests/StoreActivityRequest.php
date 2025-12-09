<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreActivityRequest extends FormRequest
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
            'id_user'       => 'required|string|exists:users,id',
            'hospital_name' => 'required|string|max:255',
            'person_name'   => 'required|string|max:255',
            'occupation'    => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
            'date'          => 'required|date',
            'latitude'      => 'required|string|max:100',
            'longitude'     => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'Please select a user first.',
            'id_user.exists'   => 'The selected user doesn’t exist. Please check again.',

            'hospital_name.required' => 'Please enter the hospital name.',
            'hospital_name.string'   => 'Hospital name must be valid text.',

            'person_name.required'   => 'Please enter the person’s name.',
            'person_name.string'     => 'Person name must be valid text.',

            'occupation.string'      => 'Occupation must be valid text.',

            'notes.string'           => 'Notes must be valid text.',

            'date.required'          => 'Please select a date for the activity.',
            'date.date'              => 'Invalid date format.',

            'latitude.required'      => 'Location latitude is required.',
            'latitude.string'        => 'Invalid latitude format.',

            'longitude.required'     => 'Location longitude is required.',
            'longitude.string'       => 'Invalid longitude format.',
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
