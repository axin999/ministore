<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     protected function failedValidation(Validator $validator)
     { 
        throw new HttpResponseException(
            response()->json(
                $validator->errors()
            , 422)
        );
        //throw new ValidationException($validator);
     }  

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
            'name'=>'required|string|min:5|max:191',
            'email'=>'required|string|email|max:191|unique:users',
            'password'=>'required|string|min:6'
        ];
    }

    public function messages(){

        return[
            'name.required' => 'The name field is required.',
            'name.min' => 'Sorry minimum of five characeters only!',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
        ];
    }
}
