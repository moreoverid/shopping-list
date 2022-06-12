<?php

namespace App\Services;

use App\Models\ShoppingList;
use Illuminate\Support\Facades\DB;

class ShoppingListService extends BaseService
{
    public static function removeAll()
    {
        $userId = auth()->user()->id;

        if ($userId) {
            DB::table(ShoppingList::TABLE)->where('user_id', $userId)->delete();
        }
    }
}
