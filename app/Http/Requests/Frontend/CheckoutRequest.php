<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        $email_rules = auth()->user() ? 'required|string|email|max:255': 'required|email|unique:users|string|email|max:255';

        return [
            'email' => $email_rules,
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalcode' => 'required|max:255',
            'phone' => 'required|max:255',
            'name_on_card' => 'sometimes|nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => __('frontend.you_have_account_with_this_email_please_try_login'),
        ];
    }
}
