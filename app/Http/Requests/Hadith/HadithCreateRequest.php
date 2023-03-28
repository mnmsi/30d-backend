<?php

namespace App\Http\Requests\Hadith;

use Illuminate\Foundation\Http\FormRequest;

class HadithCreateRequest extends FormRequest
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
            'short_description'=>'required|string',
            'medium_description'=>'required|string',
            'visible_time'=>'required|unique:hadith_contents,visible_time|date_format:Y-m-d',
            'content'=>'required|string',
            'image'=>'required|mimes:jpeg,jpg,png,gif,svg|max:5000'
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'Title name is required',
            'title.string'=>'Title format is not correct',
            'short_description.required'=>'Short Description format is not correct',
            'medium_description.required'=>'Medium Description format is not correct',
            'content.required'=>'Description field is required',
            'content.string'=>'Description format is not correct',
            'image.required'=>'Featured image field is required',
            'image.mimes'=>'Image type is not allowed please enter JPEG,JPG,PNG,GIF format',
            'image.max'=>'Image not more than 5MB',
            'visible_time.required'=>'Date is required for showing this Hadith',
            'visible_time.unique'=>'Given date already taken by some other Hadith'
        ];
    }
}
