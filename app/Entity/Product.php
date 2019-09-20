<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Product
 *
 * @property-read \App\Entity\Category $category
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
    protected  $table      = 'product';
    protected  $primaryKey = 'id';

    protected $fillable = [
        'name' ,'category_id','price', 'preview','on_sale','rating', 'sold_count', 'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
