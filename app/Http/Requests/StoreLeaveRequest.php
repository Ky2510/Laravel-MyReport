<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLeaveRequest extends FormRequest
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
            'name'              => 'required|string',
            'days'              => 'required|integer',
            'description'       => 'required',
            'is_main'           => 'required',
            'is_cut_main'       => 'required',
            'is_pay'            => 'required',
            'required_document' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.required' => 'Please enter a name.',
            'name.string'   => 'The name must be text.',

            // days
            'days.required' => 'Please enter the number of days.',
            'days.integer'  => 'The days field must be a valid number.',

            // description
            'description.required' => 'Please provide a description.',

            // is_main
            'is_main.required' => 'Please specify whether this is the main type.',

            // is_cut_main
            'is_cut_main.required' => 'Please specify whether this cuts the main balance.',

            // is_pay
            'is_pay.required' => 'Please specify the payment requirement.',

            // required_document
            'required_document.required' => 'Please specify the required document.',
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
