<?php

namespace App\Classes\Transformers;

class CompanyTransformer extends Transformer
{
    protected $resourceName = 'company';

    public function transform($data)
    {
        return [
            'id' => $data['id'],
            'parent_company_id' => $data['parent_company_id'],
            'name' => $data['name'],
            'created_at' => $data['created_at']->format('Y-m-d H:i:s'),
            'updated_at' => $data['updated_at']->format('Y-m-d H:i:s'),
            'parent' => $data['parent'],
        ];
    }
}
