<?php

namespace App\Repository;

use App\Filters\ShoppingListFilter;
use App\Http\Resources\ShoppingListResource;
use App\Models\ShoppingList;

class ShoppingListRepository extends BaseRepository
{
    /**
     * Method returns Model::class
     *
     * @return mixed
     */
    public function setModel() : string
    {
        return ShoppingList::class;
    }

    /**
     * Method returns BaseFilter::class
     *
     * @return mixed
     */
    public function setFilter() : string
    {
        return ShoppingListFilter::class;
    }

    /**
     * Method returns Resource::class
     *
     * @return mixed
     */
    public function setResource() : string
    {
        return ShoppingListResource::class;
    }
}
