<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerSessionUpdateRequest extends FormRequest
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
            'active_period'         => 'required|string',
            'member_id'             => 'exists:members,id',
            'trainer_id'            => 'required|exists:trainers,id',
            'trainer_package_id'    => 'exists:trainer_packages,id',
            'remaining_session'     => '',
            'status'                => '',
            'user_id'               => ''
        ];
    }
}
