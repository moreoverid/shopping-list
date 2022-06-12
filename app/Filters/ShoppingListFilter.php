<?php

namespace App\Filters;

class ShoppingListFilter extends BaseFilter
{
    public function searchQuery($value)
    {
        if ($value) {
            $this->builder->where('name', 'like', '%' . trim($value) . '%');
        }
    }
}
