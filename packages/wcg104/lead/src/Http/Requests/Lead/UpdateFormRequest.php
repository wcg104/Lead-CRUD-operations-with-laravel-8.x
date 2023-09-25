<?php

namespace  Wcg104\Lead\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
    public function rules($id)
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|max:200|unique:leads,email,'.$id.',id',
            'address1' => 'required|max:250',
            'address2' => 'required|max:250',
            'city' => 'required',
            'state' => 'required',
            'country' =>'required',
            'cellphone' => 'required',
            'phone_ext' => 'required',
            'phone' => 'required'
            
        ];
    }

}
