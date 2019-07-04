<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

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
