<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * Method saves data to DB
     *
     * @param array $params
     * @param string $class
     * @return Model
     */
    public static function store(array $params, string $class): Model
    {
        $model = (new $class())->fill($params);
        $model->save();

        return $model;
    }

    /**
     * Method updates data in DB
     *
     * @param array $params
     * @param Model $model
     * @return Model
     */
    public static function update(array $params, Model $model): Model
    {
        $model->fill($params);
        $model->save();

        return $model;
    }

    /**
     * Method deletes data from DB
     *
     * @param Model $model
     */
    public static function destroy(Model $model)
    {
        $model->delete();
    }
}
