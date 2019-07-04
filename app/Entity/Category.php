<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

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
