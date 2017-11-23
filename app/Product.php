<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productAvailabilities()
    {
        return $this->hasMany(ProductAvailability::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
