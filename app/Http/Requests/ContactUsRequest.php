<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'body' => 'required|min:3',
            'email' => 'required',
            'recaptcha-response' => ['required', new Recaptcha()],
        ];

            // Step by step recaptcha:
            // 1. get two keys from google 
            // 2. create a new rule called Recaptcha.php
            // 3. need to install zttp and copy rule info from the recaptcha rule I have here.
            // 4. in .env file add RECAPTCHA_SECRET=
            // 5. In html add .js and the public key
            // 6. It should work as long as the rule is setup correctly
    }
}
