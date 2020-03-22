<?php

namespace App\Http\Requests\Api\Station;

use App\Http\Requests\Api\ApiRequest;

class DeleteStation extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $station = $this->route('station');

        return true;
//        return !count($station->company);
    }
}
