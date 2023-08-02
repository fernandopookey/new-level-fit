<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerPackageUpdateRequest extends FormRequest
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
            'package_name'          => 'required|string',
            'package_type_id'       => 'required|exists:trainer_package_types,id',
            'number_of_session'     => 'required',
            'expired_session'       => 'required',
            'package_price'         => 'required|numeric',
            'admin_price'           => 'required|numeric',
            'description'           => 'nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'package_price' => str_replace(',', '', $this->package_price),
            'admin_price' => str_replace(',', '', $this->admin_price),
        ]);
    }
}
