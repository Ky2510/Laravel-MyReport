<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRuleScheduleRequest extends FormRequest
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
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255|unique:rule_schedules,name',
            'check_in'       => 'required|date_format:H:i:s',
            'check_out'      => 'required|date_format:H:i:s',
            'overtime_after' => 'required|integer|min:0',
            'max_after'      => 'required|integer|min:0',
            'max_att'        => 'required|date_format:H:i:s',
            'is_shift'       => 'nullable|boolean'
        ];
    }

    /**
     * Custom messages (lebih ramah user)
     */
    public function messages(): array
    {
        return [
            'department_id.required' => 'Department is required.',
            'department_id.exists'   => 'Selected department does not exist.',

            'name.required' => 'Rule schedule name is required.',
            'name.unique'   => 'Rule schedule name is already taken.',

            'check_in.required'     => 'Check-in time is required.',
            'check_in.date_format'  => 'Check-in time must be in the format HH:MM:SS.',

            'check_out.required'     => 'Check-out time is required.',
            'check_out.date_format'  => 'Check-out time must be in the format HH:MM:SS.',

            'overtime_after.required' => 'Overtime after is required.',
            'overtime_after.integer'  => 'Overtime after must be a number.',
            'overtime_after.min'      => 'Overtime after must be at least 0.',

            'max_after.required' => 'Max after is required.',
            'max_after.integer'  => 'Max after must be a number.',
            'max_after.min'      => 'Max after must be at least 0.',

            'max_att.required'    => 'Max attendance time is required.',
            'max_att.date_format' => 'Max attendance time must be in the format HH:MM:SS.',
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
