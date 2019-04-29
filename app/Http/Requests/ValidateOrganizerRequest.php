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
            'organizationName'        => ['required', Rule::unique('organizers')->ignore($this->id)],
            'organizationDescription' => 'required',
            'organizationWebsite'     => 'required',
            'instagramHandle'         => 'min:1',
            'twitterHandle'           => 'min:1',
            'facebookHandle'          => 'min:1',
        ];

        if (is_file($this->organizationImagePath)) {
            $rules['organizationImagePath'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:1048';
        }

        return $rules;
    }
}
