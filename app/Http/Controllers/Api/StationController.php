<?php

namespace App\Http\Controllers\Api;

use App\Models\Station;
use App\Classes\Filters\StationFilter;
use App\Http\Requests\Api\Station\CreateStation;
use App\Http\Requests\Api\Station\UpdateStation;
use App\Http\Requests\Api\Station\DeleteStation;
use App\Classes\Transformers\StationTransformer;
use App\Repositories\Interfaces\StationRepositoryInterface;

class StationController extends ApiController
{

    protected $repository;

    /**
     * StationController constructor.
     *
     * @param StationRepositoryInterface $stationRepository
     * @param StationTransformer $transformer
     */
    public function __construct(StationRepositoryInterface $stationRepository, StationTransformer $transformer)
    {
        $this->repository = $stationRepository;
        $this->transformer = $transformer;

    }

    /**
     * Get all the stationions.
     *
     * @param StationFilter $filter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(StationFilter $filter)
    {
        $stations = $this->repository->paginate($filter);
        return $this->respondWithPagination($stations);
    }

    /**
     * Create a new station and return the station if successful.
     *
     * @param CreateStation $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(CreateStation $request)
    {
        $station = $this->repository->create($request->get('station'));

        return $this->respondWithTransformer($station);
    }

    /**
     * Get the station given by its id.
     *
     * @param Station $station
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show(Station $station)
    {
        return $this->respondWithTransformer($station);
    }

    /**
     * Update the station given by its slug and return the station if successful.
     *
     * @param UpdateStation $request
     * @param Station $station
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateStation $request, Station $station)
    {
        $station = $this->repository->update($station->id, $request->get('station'));
        return $this->respondWithTransformer($station);
    }

    /**
     * Delete the station .
     *
     * @param DeleteStation $request
     * @param Station $station
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteStation $request, Station $station)
    {
        if ($this->repository->delete($station)) {
            return $this->respondSuccess();
        } else {
            return $this->respondForbidden();
        }
    }
}
