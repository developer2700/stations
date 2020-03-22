<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Classes\Paginate\Paginate;
use App\Classes\Filters\CompanyFilter;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    /**
     * CompanyRepository constructor.
     *
     * @param Company $company
     * @throws \Exception
     */
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }

    /**
     * @param int $company_id
     * @return array
     */
    public function getChildrenIds(int $company_id): array
    {
        $company = $this->model->find($company_id);
        $ids = [$company->id];

        if ($company->children()->count()) {
            foreach ($company->children()->get() as $child) {
                $ids = array_merge($ids, $this->getChildrenIds($child->id));
            }
            return array_unique($ids);
        } else {
            return array_unique($ids);
        }
    }
}
