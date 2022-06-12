<?php

namespace App\Repository;

use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    public const ITEMS_PER_PAGE = 10;

    protected $model;

    protected $filter;

    protected $resource;

    /**
     * BaseRepository constructor
     */
    public function __construct()
    {
        $this->model = $this->setModel();
        $this->filter = $this->setFilter();
        $this->resource = $this->setResource();
    }

    /**
     * Method returns Model::class
     *
     * @return mixed
     */
    abstract public function setModel() : string;

    /**
     * Method returns BaseFilter::class
     *
     * @return mixed
     */
    abstract public function setFilter() : string;

    /**
     * Method returns Resource::class
     *
     * @return mixed
     */
    abstract public function setResource() : string;

    /**
     * Method returns collection
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function get(array $params) : LengthAwarePaginator
    {
        $page = isset($params['page']) ? intval($params['page']) : 1;
        $perPage = isset($params['per_page']) ? intval($params['per_page']) : static::ITEMS_PER_PAGE;

        $query = (new $this->filter($this->model::query(), $params))->apply();
        $cnt = $query->count() ?? 0;
        $query->limit($perPage)->offset(($page - 1) * $perPage);
        $result = $this->resource::collection($query->get())->toArray(null);

        return new LengthAwarePaginator(
            $result,
            $cnt,
            $perPage,
            $page,
            []
        );
    }
}
