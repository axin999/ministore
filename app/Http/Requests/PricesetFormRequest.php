<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class PricesetFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     protected function failedValidation(Validator $validator)
     { 
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ], 200)
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
            //
            'priceset_type.*'=>'required|min:1|max:30',
             'category_id'=>'required|min:1|max:30',
        ];
    }

    public function messages(){

        return[
            'priceset_type.required' => 'Please fill up this field.',
            'priceset_type.min' => 'Sorry minimum of five characeters only!',
            'priceset_type.max' => 'Sorry maximum of 30 characeters only!',
        ];
    }

  
}
