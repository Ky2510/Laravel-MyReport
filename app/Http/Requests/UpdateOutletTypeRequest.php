<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutletTypeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:100',
        ];
    }

    /**
     * Custom messages (optional)
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The outlet type name must be a valid text.',
            'name.max'    => 'The outlet type name cannot be longer than 100 characters.',
        ];
    }
}
