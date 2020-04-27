<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantCreateRequest extends FormRequest
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
            'company_id' => 'required|integer',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            /*'self_reflection' => 'required|numeric',
            'peer_reflection' => 'required|numeric',*/
        ];
        /*return [
            'company_id' => 'required|integer',
            'user_name' => 'required|string|exists:participants,name',
            'user_email' => 'required|email|exists:participants,email',
            'self_reflection' => 'required|numeric',
            'peer_reflection' => 'required|numeric',
        ];*/
    }
}
