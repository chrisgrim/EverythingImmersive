<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateLocationRequest extends FormRequest
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
            'eventCity' => 'required',
            'eventState' => 'required',
            'eventStreetAddress' => 'required',
            'specificLocation' => 'required',
            'eventCountry' => 'required',
            'eventZipcode' => 'required',
            'eventLat' => '',
            'eventLong' => '',
        ];
    }
}
