<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerSessionStoreRequest extends FormRequest
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
            'member_id'             => 'required|exists:members,id',
            'trainer_id'            => 'required|exists:trainers,id',
            'trainer_package_id'    => 'required|exists:trainer_packages,id',
            'session_total'         => 'required',
            'remaining_session'     => 'required',
            'status'                => 'required'
        ];
    }
}
