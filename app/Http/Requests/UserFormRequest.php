<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        app()->setLocale('ar');
//        the default language in the app.php file in config folder ->locale
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(Str::contains(request()->getRequestUri(),'login')){
            return [
                'phone' => 'required',
                'password' => 'required',
                ];
        }
        return [
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'filled', // pass if not sent
            'type' => 'required',
            ];
    }

    public function attributes(){
        return [
//            'type'=>'نوع المستخدم'

//            'username' => __('keywords.username'),
            'email' => __('keywords.email'),
            'phone' => __('keywords.phone'),
            'password' => __('keywords.password'),
            'type' => __('keywords.type'),

        ];

    }

    public function messages(){
        return [
            'username.required' => 'هذا حقل اجباري',
            'type.required' => __('keywords.error_msg'),
        ];
    }
}
