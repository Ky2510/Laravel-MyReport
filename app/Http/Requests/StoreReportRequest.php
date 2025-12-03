<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'employee_id'       => 'required|exists:employees,id',
            'date_check'        => 'required|date|date_format:Y-m-d',
            'time_check'        => 'nullable|date_format:H:i:s',
            'temperature'       => 'nullable|string|max:255',
            'max_att'           => 'nullable|date_format:H:i:s',
            'late_minutes'      => 'nullable|integer|min:0',
            'overtime_minutes'  => 'required|integer|min:0',
            'check_type'        => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:255',
        ];
    }
}
