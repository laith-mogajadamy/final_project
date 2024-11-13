<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable =
 [
    'name',
    'description',
    'price',
    'photo',
    ];

     /**
     * Accessor for the photo URL.
     * This will return the full URL of the photo if it exists.
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
    /**
     * Define a many-to-many relationship with FoodItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foodItems()
    {
        return $this->belongsToMany(FoodItem::class, 'food_item_meal');
    }

    /**
     * Boot method to handle model events.
     */
    protected static function booted()
    {
        // Automatically detach associated food items when a meal is deleted
        static::deleting(function ($meal) {
            $meal->foodItems()->detach();
        });
    }
}
