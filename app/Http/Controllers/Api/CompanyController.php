<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Classes\Filters\CompanyFilter;
use App\Http\Requests\Api\Company\CreateCompany;
use App\Http\Requests\Api\Company\UpdateCompany;
use App\Http\Requests\Api\Company\DeleteCompany;
use App\Classes\Transformers\CompanyTransformer;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyController extends ApiController
{

    protected $repository;

    /**
     * CompanyController constructor.
     *
     * @param CompanyRepositoryInterface $companyRepository
     * @param CompanyTransformer $transformer
     */
    public function __construct(CompanyRepositoryInterface $companyRepository, CompanyTransformer $transformer)
    {
        $this->repository = $companyRepository;
        $this->transformer = $transformer;

        // this is for jwt auth and we won't use it in this project
//        $this->middleware('auth.api')->except(['index', 'show']);
//        $this->middleware('auth.api:optional')->only(['index', 'show']);
    }

    /**
     * Get all the companies.
     *
     * @param CompanyFilter $filter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(CompanyFilter $filter)
    {
        $companies = $this->repository->paginate($filter);

        return $this->respondWithPagination($companies);
    }

    /**
     * Create a new company and return the company if successful.
     *
     * @param CreateCompany $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCompany $request)
    {
        $company = $this->repository->create($request->get('company'));

        return $this->respondWithTransformer($company);
    }

    /**
     * Get the company given by its id.
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return $this->respondWithTransformer($company);
    }

    /**
     * Update the company given by its slug and return the company if successful.
     *
     * @param UpdateCompany $request
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateCompany $request, Company $company)
    {
        $company = $this->repository->update($company->id, $request->get('company'));
        return $this->respondWithTransformer($company);
    }

    /**
     * Delete the company .
     *
     * @param DeleteCompany $request
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteCompany $request, Company $company)
    {
        if ($this->repository->delete($company)) {
            return $this->respondSuccess();
        } else {
            return $this->respondForbidden();
        }
    }
}
