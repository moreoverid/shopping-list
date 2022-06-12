<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    public const TABLE = 'shopping_lists';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'quantity',
        'price',
    ];

    static function boot()
    {
        parent::boot();

        // Automatically filter the Model from the table
        static::addGlobalScope('podcast', function ($builder) {
            $builder->where('user_id', auth()->user()->id);
        });

        // Save the sid when creating this model
        static::creating(function ($model) {
            $model->forceFill([
                'user_id' => auth()->user()->id,
            ]);
        });
    }
}
