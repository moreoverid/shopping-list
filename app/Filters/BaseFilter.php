<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    protected $builder;
    protected $filters;
    protected $default = [];

    public function __construct(Builder $builder,  array $filters)
    {
        $this->builder = $builder;
        $this->filters  = $filters;
    }

    public function apply()
    {
        foreach ($this->filters() as $filter => $value) {
            $method = $this->camelCase($filter);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        foreach ($this->default as $filter => $default) {
            $this->filters[$filter] = $this->filters[$filter] ?? $default;
        }

        return $this->filters;
    }

    private function camelCase($value)
    {
        $value = preg_replace_callback(
            '/_\w/',
            function ($matches) {
                $character = reset($matches);
                return strtoupper($character);
            },
            $value
        );

        return str_replace("_", "", $value);
    }
}
