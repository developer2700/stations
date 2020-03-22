<?php

namespace App\Http\Requests\Api\Station;

use App\Http\Requests\Api\ApiRequest;

class CreateStation extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->get('station') ?: [];
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
            'company_id' => 'sometimes|numeric|exists:companies,id',
        ];
    }
}
