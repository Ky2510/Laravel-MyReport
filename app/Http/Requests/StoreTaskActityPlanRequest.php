<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskActityPlanRequest extends FormRequest
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
            // 'userId'              => 'nullable',
            // 'department_id'       => 'nullable|string|max:255',

            // 'title'               => 'required|string|max:255',
            // 'description'         => 'nullable|string',

            // 'startDate'           => 'nullable|date',
            // 'endDate'             => 'nullable|date|after_or_equal:startDate',

            'priority'            => 'nullable|in:low,medium,high',
            'progress'            => 'nullable|integer|min:0|max:100',

            'tasks' => 'nullable|array',
            'tasks.*.name' => 'required|string',
            'tasks.*.description' => 'nullable|string',

            'category'            => 'nullable|string|max:255',

            // 'budget'              => 'nullable|numeric|min:0',
            // 'estimated_duration'  => 'nullable|integer|min:0',

            // 'attachment'          => 'nullable|string|max:255',
            // 'notes'               => 'nullable|string',

            // 'required_resources'  => 'nullable|string',
            // 'risk_level'          => 'nullable|in:low,medium,high',

            // 'outcome_expected'    => 'nullable|string',
            // 'success_criteria'    => 'nullable|string',

            // 'dependencies'        => 'nullable|string',
            // 'stakeholders'        => 'nullable|string',

            // 'createBy'            => 'nullable|string|max:255',
            // 'updateBy'            => 'nullable|string|max:255',

            // 'schedule'            => 'nullable|date',

            // 'targetOutlet'        => 'nullable|string|max:191',
            // 'reason'              => 'nullable|string|max:191',
            // 'teamMembers'         => 'nullable|string|max:191',
            // 'targetPerson'        => 'nullable|string|max:191',

            // 'latitude'            => 'nullable|string|max:255',
            // 'longitude'           => 'nullable|string|max:255',

            // 'target_location'     => 'nullable|string',

            // 'status'              => 'nullable|in:planning,in_progress,completed,on_hold,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            // 'title.required'          => 'Please enter a title for the activity plan.',

            // 'endDate.after_or_equal'  => 'End date cannot be earlier than start date.',

            'priority.in'             => 'Priority must be low, medium, or high.',

            // 'risk_level.in'           => 'Risk level must be low, medium, or high.',
            // 'status.in'               => 'Status must be a valid value.',

            // 'userId.exists'           => 'The selected user does not exist.',
            'progress.max'            => 'Progress cannot exceed 100%.',
            'progress.min'            => 'Progress cannot be negative.',

            // 'budget.numeric'          => 'Budget must be a valid number.',
            // 'estimated_duration.min'  => 'Estimated duration must be a positive number.',

            'endDate.date'            => 'Please enter a valid end date.',
            'startDate.date'          => 'Please enter a valid start date.',
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
