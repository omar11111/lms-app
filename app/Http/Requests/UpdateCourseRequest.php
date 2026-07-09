<?php

namespace App\Http\Requests;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCourseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [

        'title'=>[
            'sometimes',
            'string',
            'max:255',
        ],

        'description'=>[
            'sometimes',
            'string',
        ],

        'price'=>[
            'sometimes',
            'numeric',
            'min:0',
        ],

        'module_id'=>[
            'sometimes',
            'exists:modules,id',
        ],

        'category_id'=>[
            'nullable',
            'exists:categories,id',
        ],

        'status'=>[
            'sometimes',
            new Enum(CourseStatus::class),
        ],

        'type'=>[
            'sometimes',
            new Enum(CourseType::class),
        ],

    ];
}
}
