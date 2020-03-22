<?php

namespace App\Classes\Filters;

use App\Classes\Transformers\StationTransformer;
use App\Models\Station;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\StationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class StationFilter extends Filter
{

    protected $companyRepository;

    /**
     * Filter constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(Request $request, CompanyRepositoryInterface $companyRepository)
    {
        parent::__construct($request);
        $this->companyRepository = $companyRepository;
    }

    /**
     * Filter by name
     * Get all the stations by the given name.
     *
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($name)
    {
        return $this->builder->where('name', 'like', $name . '%');
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
        return $this->builder->where('company_id', $id);
    }

    /**
     * Filter by nested_company_id_stations
     * Get all stations by the given company_id and it's children.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function nested_company_id_stations($id)
    {
        $ids = $this->companyRepository->getChildrenIds($id);
        return $this->builder->whereIn('company_id', $ids);
    }

    /**
     * Filter by locations
     * Get all stations which are close to given location by distance given radius.
     *
     * @param $latitude
     * @param $longitude
     * @param $radius
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function close_radius($latitude, $longitude, $radius = 25)
    {
        $location = new Point($latitude, $longitude);
        return $this->builder->distanceSphere('location',$location,$radius);
    }

}
