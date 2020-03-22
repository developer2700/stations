<?php

namespace App\Repositories\Eloquent;

use App\Models\Station;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\StationRepositoryInterface;
use App\Classes\Paginate\Paginate;
use App\Classes\Filters\StationFilter;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class StationRepository extends BaseRepository implements StationRepositoryInterface
{
    /**
     * StationRepository constructor.
     *
     * @param Station $station
     * @throws \Exception
     */
    public function __construct(Station $station)
    {
        parent::__construct($station);
    }

}
