<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCurrentTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('setCurrent', $this->team); //this team is picked from the one passed in the bracket of the method in the controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
