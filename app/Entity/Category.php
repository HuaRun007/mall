<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Product[] $product
 * @mixin \Eloquent
 */
class Category extends Model
{
    //
    protected $table      = 'category';
    protected $primaryKey = 'id';


    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
