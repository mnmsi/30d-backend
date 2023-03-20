<?php

namespace App\Http\Requests\Hadith;

use Illuminate\Foundation\Http\FormRequest;

class HadithUpdateRequest extends FormRequest
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
            'title'=>'nullable|string',
            'short_description'=>'nullable|string',
            'medium_description'=>'nullable|string',
            'visible_time'=>'nullable|date_format:Y-m-d|unique:hadith_contents,visible_time,'.$this->id,
            'content'=>'nullable|string',
            'image'=>'nullable|mimes:jpeg,jpg,png,gif|max:5000',
            'id'=>'required|integer'
        ];
    }
    public function messages()
    {
        return [

            'title.string'=>'Title format is not correct',
            'medium_description.required'=>'Medium Description format is not correct',
            'content.string'=>'Description format is not correct',
            'image.mimes'=>'Image type is not allowed please enter JPEG,JPG,PNG,GIF format',
            'image.max'=>'Image not more than 5MB',
            'visible_time.required'=>'Date is required for showing this Hadith',
            'visible_time.unique'=>'Given date already taken by some other Hadith'
        ];
    }
}
