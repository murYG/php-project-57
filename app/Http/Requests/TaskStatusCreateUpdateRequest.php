<?php

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStatusCreateUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:task_statuses'
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('models.task_status.validation.name.unique')
        ];
    }
}
