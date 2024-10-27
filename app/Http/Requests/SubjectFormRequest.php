<?php

namespace App\Http\Requests;

use App\Actions\HandleRulesValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SubjectFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->type == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $arr = [
            'user_id' => 'required|exists:users,id',
            'year_id' => 'required|exists:colleges_years,id',
        ];
        $arr_lang = ['name:required', 'info:nullable'];
        $this->validateUserType();
        return HandleRulesValidation::handle($arr, $arr_lang);
    }

    public function attributes()
    {
        return [
            'user_id' => __('keywords.user_id'),
            'year_id' => __('keywords.year_id'),
            'ar_name' => __('keywords.ar_name'),
            'en_name' => __('keywords.en_name'),
            'ar_info' => __('keywords.ar_info'),
            'en_info' => __('keywords.en_info'),
        ];

    }

    public function validateUserType()
    {
        if(request()->filled('user_id')){
            $user = User::query()->findOrFail(request('user_id'));
            if($user->type == 'admin'){
                abort(500, 'User Type Is Not Correct');
            }
        }
        else
        {
            abort(500, 'User Id Is Not Passed');

        }
    }
}
