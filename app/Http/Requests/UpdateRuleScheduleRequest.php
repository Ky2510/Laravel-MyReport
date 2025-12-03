<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRuleScheduleRequest extends FormRequest
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
            'name'           => 'required|string|max:255|unique:rule_schedules,name,' . $this->route('id'),
            'check_in'       => 'required|date_format:H:i:s',
            'check_out'      => 'required|date_format:H:i:s',
            'overtime_after' => 'required|integer|min:0',
            'max_after'      => 'required|integer|min:0',
            'max_att'        => 'required|date_format:H:i:s',
            'is_shift'       => 'nullable|boolean',
        ];
    }


    public function messages()
    {
        return [
            // NAME
            'name.required' => 'Please enter the rule schedule name.',
            'name.string'   => 'The rule schedule name must be text.',
            'name.max'      => 'The rule schedule name is too long.',
            'name.unique'   => 'This rule schedule name already exists.',

            // DEPARTMENT
            'department_id.required' => 'Please choose a department.',
            'department_id.exists'   => 'The selected department does not exist.',

            // TIME VALIDATION
            'check_in.required'   => 'Check-in time is required.',
            'check_in.date_format' => 'Check-in must be in HH:MM:SS format.',

            'check_out.required'   => 'Check-out time is required.',
            'check_out.date_format' => 'Check-out must be in HH:MM:SS format.',

            'max_att.required'     => 'Maximum attendance time is required.',
            'max_att.date_format'  => 'Maximum attendance must be in HH:MM:SS format.',

            // NUMBERS
            'overtime_after.required' => 'Please enter overtime threshold.',
            'overtime_after.integer'  => 'Overtime value must be a number.',
            'overtime_after.min'      => 'Overtime value cannot be negative.',

            'max_after.required' => 'Please enter maximum late time.',
            'max_after.integer'  => 'Maximum late value must be a number.',
            'max_after.min'      => 'Maximum late value cannot be negative.',

            // SHIFT
            'is_shift.boolean' => 'Shift value must be true or false.',
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
