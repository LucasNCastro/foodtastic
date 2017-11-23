<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAvailability extends Pivot
{
    protected $table = 'product_availabilities';
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
