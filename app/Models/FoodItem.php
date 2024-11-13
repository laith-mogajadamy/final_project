<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{


    use HasFactory;

    // Specify the table name (if it differs from the default 'food_items')
    protected $table = 'food_items';

    // Specify fillable properties
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'photo',
    ];
    public function meals()
    {
    return $this->belongsToMany(Meal::class, 'food_item_meal');
    }
}
