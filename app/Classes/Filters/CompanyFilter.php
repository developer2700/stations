<?php

namespace App\Classes\Filters;

use App\Models\Station;

class CompanyFilter extends Filter
{
    /**
     * Filter by name
     * Get all the companies by the given name.
     *
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($name)
    {
        return $this->builder->where('name','like',$name.'%');
    }

    /**
     * Filter by id
     * Get the company by the given id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function id($id)
    {
        return $this->builder->whereId($id);
    }

    /**
     * Filter by parent_company_id
     * Get the companies by the given parent_company_id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function parent_company_id($id)
    {
        return $this->builder->where('parent_company_id',$id);
    }

}
