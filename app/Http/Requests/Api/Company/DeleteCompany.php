<?php

namespace App\Http\Requests\Api\Company;

use App\Http\Requests\Api\ApiRequest;

class DeleteCompany extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $company = $this->route('company');

        return !count($company->children);
    }
}
