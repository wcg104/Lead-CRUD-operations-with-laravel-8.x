<?php

namespace  Wcg104\Lead\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFormRequest extends FormRequest
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
            'name' => 'required|max:50',
            'password' => 'required|max:50',
            'cellphone' => 'required',
            'phone_ext' => 'required',
            'phone' => 'required',
            'address1' => 'required|max:250',
            'address2' => 'required|max:250',
            'city' => 'required',
            'state' => 'required',
            'country' =>'required',
            'status' => 'required|in:active,pending,cancelled,blocked,archived',
            'email' => [
                'required','email','max:200',
                Rule::unique('leads')->where(function ($query){
                    return $query->whereNot('email', $this->input('email'))->where('is_deleted',0);
                }),
            ],
        ];
    }
}
