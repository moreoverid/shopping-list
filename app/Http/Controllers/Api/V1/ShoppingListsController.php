<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRequest;
use App\Http\Resources\ShoppingListResource;
use App\Models\ShoppingList;
use App\Repository\ShoppingListRepository;
use App\Services\ShoppingListService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ShoppingListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param ShoppingListRepository $shoppingListRepository
     * @return LengthAwarePaginator
     */
    public function index(Request $request, ShoppingListRepository $shoppingListRepository): LengthAwarePaginator
    {
        return $shoppingListRepository->get($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  ShoppingList  $shoppingList
     * @return ShoppingListResource
     */
    public function show(ShoppingList $shoppingList): ShoppingListResource
    {
        return ShoppingListResource::make($shoppingList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShoppingListRequest $request
     * @return Response
     */
    public function store(ShoppingListRequest $request): Response
    {
        ShoppingListService::store($request->all(), ShoppingList::class);

        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShoppingListRequest $request
     * @param  ShoppingList  $shoppingList
     * @return Response
     */
    public function update(ShoppingListRequest $request, ShoppingList $shoppingList): Response
    {
        ShoppingListService::update($request->all(), $shoppingList);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShoppingList  $shoppingList
     * @return Response
     */
    public function destroy(ShoppingList $shoppingList): Response
    {
        ShoppingListService::destroy($shoppingList);

        return response()->noContent();
    }

    public function removeAll()
    {
        ShoppingListService::removeAll();
    }
}
