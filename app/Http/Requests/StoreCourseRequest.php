<?php

namespace App\Http\Requests;

use App\Enums\CourseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [

        'title'=>[
            'required',
            'string',
            'max:255',
        ],

        'description'=>[
            'required',
            'string',
        ],

        'price'=>[
            'required',
            'numeric',
            'min:0',
        ],

        'module_id'=>[
            'required',
            'exists:modules,id'
        ],

        'category_id'=>[
            'nullable',
            'exists:categories,id'
        ],

        'type'=>[
            'required',
            new Enum(CourseType::class)
        ],
    ];
}
}
