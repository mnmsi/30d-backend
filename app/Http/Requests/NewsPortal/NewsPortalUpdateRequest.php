<?php

namespace App\Http\Requests\NewsPortal;

use Illuminate\Foundation\Http\FormRequest;

class NewsPortalUpdateRequest extends FormRequest
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
            'content'=>'nullable|string',
            'video_url'=>'nullable|active_url',
            'image'=>'nullable|mimes:jpeg,jpg,png,gif|max:5000',
            'id'=>'required|integer'
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
            'video_url.active_url'=>'Video url is not valid',
            'image.nullable'=>'Featured image field is required',
            'image.mimes'=>'Image type is not allowed please enter JPEG,JPG,PNG,GIF format',
            'image.max'=>'Image not more than 5MB'
        ];
    }
}
