<?php

namespace App\Http\Requests\Api\Company;

use App\Http\Requests\Api\ApiRequest;

class CreateCompany extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->get('company') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'parent_company_id' => 'sometimes|numeric',
        ];
    }
}
