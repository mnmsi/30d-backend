<?php

namespace App\Http\Requests\LifeStyle;

use Illuminate\Foundation\Http\FormRequest;

class LifeStyleCreateRequest extends FormRequest
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
            'category'=>'required|integer',
            'short_description'=>'nullable|string',
            'content'=>'required|string',
            'type'=>'required|string|in:text,image,video,podcast',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:5000'
        ];
    }

    public function messages()
    {
        return [
          'title.required'=>'Title name is required',
          'title.string'=>'Title format is not correct',
          'short_description'=>'Short Description format is not correct',
          'content.required'=>'Content field is required',
          'content.string'=>'Content format is not correct',
          'type.string'=>'Type is not valid',
          'type.required'=>'Type is required',
          'type.in'=>'Type is not supported',
          'image.required'=>'Featured image field is required',
          'image.mimes'=>'Image type is not allowed please enter JPEG,JPG,PNG,GIF format',
          'image.max'=>'Image not more than 5MB'
        ];
    }
}
