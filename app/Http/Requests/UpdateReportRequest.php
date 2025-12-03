<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateReportRequest extends FormRequest
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
            'employee_id'       => 'nullable|exists:employees,id',
            'date_check'        => 'nullable|date|date_format:Y-m-d',
            'time_check'        => 'nullable|date_format:H:i:s',
            'temperature'       => 'nullable|string|max:255',
            'max_att'           => 'nullable|date_format:H:i:s',
            'late_minutes'      => 'nullable|integer|min:0',
            'overtime_minutes'  => 'nullable|integer|min:0',
            'check_type'        => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:255',
        ];
    }


    public function messages()
    {
        return [
            // EMPLOYEE ID
            'employee_id.exists' => 'The selected employee does not exist.',

            // DATE CHECK
            'date_check.date'        => 'The date must be a valid date.',
            'date_check.date_format' => 'The date must be in the format YYYY-MM-DD.',

            // TIME CHECK
            'time_check.date_format' => 'Time must be in the format HH:MM:SS.',

            // TEMPERATURE
            'temperature.string' => 'Temperature must be text.',
            'temperature.max'    => 'Temperature cannot exceed 255 characters.',

            // MAX ATT
            'max_att.date_format' => 'Maximum attendance time must be in the format HH:MM:SS.',

            // LATE MINUTES
            'late_minutes.integer' => 'Late minutes must be a number.',
            'late_minutes.min'     => 'Late minutes cannot be negative.',

            // OVERTIME MINUTES
            'overtime_minutes.integer' => 'Overtime minutes must be a number.',
            'overtime_minutes.min'     => 'Overtime minutes cannot be negative.',

            // CHECK TYPE
            'check_type.string' => 'Check type must be text.',
            'check_type.max'    => 'Check type cannot exceed 255 characters.',

            // STATUS
            'status.string' => 'Status must be text.',
            'status.max'    => 'Status cannot exceed 255 characters.',
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
