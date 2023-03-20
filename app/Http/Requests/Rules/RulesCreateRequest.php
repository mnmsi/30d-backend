<?php

namespace App\Http\Requests\Rules;

use Illuminate\Foundation\Http\FormRequest;

class RulesCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|string',
            'content'=>'required|string'
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'Title name is required',
            'title.string'=>'Title format is not correct',
            'content.required'=>'Content field is required',
            'content.string'=>'Content format is not correct'
        ];
    }
}
