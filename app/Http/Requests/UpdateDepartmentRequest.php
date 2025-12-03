<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDepartmentRequest extends FormRequest
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
            'name'           => 'required|string|unique:departments,name,' . $this->route('id'),
            'status'         => 'nullable|boolean',
            'activate_notif' => 'nullable|boolean',
        ];
    }


    public function messages()
    {
        return [
            // NAME
            'name.required' => 'Please enter a department name.',
            'name.string'   => 'The department name must be valid text.',
            'name.unique'   => 'This department name is already used by another department.',

            // STATUS
            'status.boolean' => 'Invalid status format.',

            // NOTIFICATION
            'activate_notif.boolean' => 'Invalid notification setting.',
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
