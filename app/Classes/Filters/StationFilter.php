<?php

namespace App\Classes\Filters;

use App\Models\Station;

class StationFilter extends Filter
{
    /**
     * Filter by name
     * Get all the stations by the given name.
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
     * Get the station by the given id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function id($id)
    {
        return $this->builder->whereId($id);
    }

    /**
     * Filter by company_id
     * Get the stations by the given company_id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function company_id($id)
    {
        return $this->builder->where('company_id',$id);
    }

}
