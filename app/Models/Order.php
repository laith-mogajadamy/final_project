<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define fillable attributes
    protected $fillable = ['user_id', 'total_price', 'status'];

    // Relationship: Each order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
