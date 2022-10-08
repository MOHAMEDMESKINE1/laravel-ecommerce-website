<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "title" => "required | min:3",
            "description" => "required | min:5",
            "image" => "required|image | mimes:png,jpg,jpeg|max:2048",
            "price"=>"required | numeric",
            "inStock"=>"required | numeric",
            "category_id"=>"required | numeric",
        ];
    }
    // public function filters()
    // {
    //     return [
    //         'title' => 'trim',
    //         'description' => 'trim',
       
    //     ];
    // }
}
