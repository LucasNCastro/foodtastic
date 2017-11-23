<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function productAvailabilities()
    {
        return $this->hasMany(ProductAvailability::class);
    }
}
