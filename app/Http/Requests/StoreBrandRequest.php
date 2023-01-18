<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required',
            'slug' => $this->isMethod('POST') ? 'nullable' : 'required|unique:brands,slug,' . $this->brand->id,
            'description' => 'nullable',
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png,gif,PNG,JPEG,JPG,GIF|max:10000',
            'active' => 'nullable|boolean'
        ];
    }
}
