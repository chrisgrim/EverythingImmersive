<?php

namespace App\Http\Requests;

use App\Organizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateOrganizerRequest extends FormRequest
{
    public function __construct(Organizer $organizer)
    {
        $this->organizer = $organizer;
    }
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
        $rules = [
            'organizationName' => ['required', Rule::unique('organizers')->ignore($this->id)],
            'organizationDescription' => 'required',
            'instagramHandle' => 'min:3',
            'twitterHandle' => 'min:3',
            'facebookHandle' => 'min:3',
            'organizationWebsite' => ['required', Rule::unique('organizers')->ignore($this->id)],
        ];
        if (is_file($this->organizationImagePath)) {
            $rules['organizationImagePath'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:1048';
        }
        return $rules;
    }
}
