<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateActivityPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'activityPlanId'      => 'sometimes|string|max:191',
            'userId'              => 'sometimes|exists:users,id',
            'department_id'       => 'sometimes|string|max:255',

            'title'               => 'sometimes|string|max:255',
            'description'         => 'sometimes|string|nullable',

            'startDate'           => 'sometimes|date|nullable',
            'endDate'             => 'sometimes|date|after_or_equal:startDate|nullable',

            'priority'            => 'sometimes|in:low,medium,high|nullable',
            'progress'            => 'sometimes|integer|min:0|max:100|nullable',

            'tasks'               => 'sometimes|string|nullable',
            'category'            => 'sometimes|string|max:255|nullable',

            'budget'              => 'sometimes|numeric|min:0|nullable',
            'estimated_duration'  => 'sometimes|integer|min:0|nullable',

            'attachment'          => 'sometimes|string|max:255|nullable',
            'notes'               => 'sometimes|string|nullable',

            'required_resources'  => 'sometimes|string|nullable',
            'risk_level'          => 'sometimes|in:low,medium,high|nullable',

            'outcome_expected'    => 'sometimes|string|nullable',
            'success_criteria'    => 'sometimes|string|nullable',

            'dependencies'        => 'sometimes|string|nullable',
            'stakeholders'        => 'sometimes|string|nullable',

            'createBy'            => 'sometimes|string|max:255|nullable',
            'updateBy'            => 'sometimes|string|max:255|nullable',

            'schedule'            => 'sometimes|date|nullable',

            'targetOutlet'        => 'sometimes|string|max:191|nullable',
            'reason'              => 'sometimes|string|max:191|nullable',
            'teamMembers'         => 'sometimes|string|max:191|nullable',
            'targetPerson'        => 'sometimes|string|max:191|nullable',

            'latitude'            => 'sometimes|string|max:255|nullable',
            'longitude'           => 'sometimes|string|max:255|nullable',

            'target_location'     => 'sometimes|string|nullable',

            'status'              => 'sometimes|in:planning,in_progress,completed,on_hold,cancelled|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'activityPlanId.string'   => 'Activity Plan ID must be a valid text.',
            'title.string'            => 'Title must be text.',
            'title.max'               => 'Title cannot exceed 255 characters.',

            'userId.exists'           => 'The selected user does not exist.',

            'endDate.after_or_equal'  => 'End date cannot be earlier than start date.',

            'priority.in'             => 'Priority must be low, medium, or high.',
            'risk_level.in'           => 'Risk level must be low, medium, or high.',

            'progress.min'            => 'Progress cannot be negative.',
            'progress.max'            => 'Progress cannot be more than 100%.',

            'budget.numeric'          => 'Budget must be a valid number.',
            'budget.min'              => 'Budget cannot be negative.',

            'estimated_duration.min'  => 'Estimated duration must be a positive number.',

            'startDate.date'          => 'Please enter a valid start date.',
            'endDate.date'            => 'Please enter a valid end date.',

            'status.in'               => 'Status must be one of: planning, in progress, completed, on hold, or cancelled.',
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
