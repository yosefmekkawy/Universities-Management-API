<?php

namespace App\Http\Requests;

use App\Actions\HandleRulesValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->type != 'student';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'price' => 'required|numeric',
            'discount' => 'filled|numeric',
            'is_locked' => 'filled|numeric',
            'note' => 'nullable'
            ];
    }

    public function attributes()
    {
        return [
            'user_id' => __('keywords.user_id'),
            'subject_id' => __('keywords.year_id'),
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
