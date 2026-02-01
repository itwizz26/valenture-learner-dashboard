<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => 'nullable|integer|exists:courses,id',
            'sort_by' => 'nullable|string|in:progress_asc,progress_desc',
        ];
    }
}
