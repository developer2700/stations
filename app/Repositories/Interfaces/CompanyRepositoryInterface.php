<?php

namespace App\Repositories\Interfaces;

use App\Classes\Filters\FilterInterface;
use App\Classes\Filters\CompanyFilter;
use App\Models\Company;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int $company_id
     * @return array
     */
    public function getChildrenIds(int $company_id): array;

}
