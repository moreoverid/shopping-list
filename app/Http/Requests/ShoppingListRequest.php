<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'integer',
            'price' => 'numeric',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }
}
