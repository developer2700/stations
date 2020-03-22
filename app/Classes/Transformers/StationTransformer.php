<?php

namespace App\Classes\Transformers;

class StationTransformer extends Transformer
{
    protected $resourceName = 'station';

    public function transform($data)
    {
        return [
            'id' => $data['id'],
            'company_id' => $data['company_id'],
            'name' => $data['name'],
            'created_at' => $data['created_at']->format('Y-m-d H:i:s'),
            'updated_at' => $data['updated_at']->format('Y-m-d H:i:s'),
            'company' => $data['company'],
            'location' => $data['location'],
        ];
    }
}
