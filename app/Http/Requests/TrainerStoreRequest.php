<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerStoreRequest extends FormRequest
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
            'transaction_type_id'   => 'required|exists:trainer_transaction_types,id',
            'member_id'             => 'required|exists:members,id',
            'trainer_name'          => 'required',
            'trainer_package_id'    => 'required|exists:trainer_packages,id',
            'method_payment_id'     => 'required|exists:method_payments,id',
            'fc_id'                 => 'required|exists:fitness_consultants,id',
            'description'           => '',
            'photos'                => 'mimes:png,jpg,jpeg'
        ];
    }
}
