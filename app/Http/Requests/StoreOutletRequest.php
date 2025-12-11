<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOutletRequest extends FormRequest
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
            'code'     => 'required|string|unique:outlets,code',
            'name'     => 'required|string|unique:outlets,name',
            'type'     => 'required|string',
            'address'  => 'required|string',
            'city'     => 'required|string',
            'province' => 'required|string',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email',
            'area'     => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            // CODE
            'code.required' => 'Please enter an outlet code.',
            'code.string'   => 'Outlet code must be valid text.',
            'code.unique'   => 'This outlet code is already used.',

            // NAME
            'name.required' => 'Please enter an outlet name.',
            'name.string'   => 'Outlet name must be valid text.',
            'name.unique'   => 'This outlet name is already used.',

            // TYPE
            'type.required' => 'Please enter an outlet type.',
            'type.string'   => 'Outlet type must be valid text.',

            // ADDRESS
            'address.required' => 'Please enter an address.',
            'address.string'   => 'Address must be valid text.',

            // CITY
            'city.required' => 'Please enter a city.',
            'city.string'   => 'City must be valid text.',

            // PROVINCE
            'province.required' => 'Please enter a province.',
            'province.string'   => 'Province must be valid text.',

            // PHONE
            'phone.string' => 'Phone must be valid text.',
            'phone.max'    => 'Phone number is too long.',

            // EMAIL
            'email.email' => 'Please enter a valid email address.',

            // AREA
            'area.string' => 'Area must be valid text.',
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
