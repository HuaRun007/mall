<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Cart
 *
 * @mixin \Eloquent
 */
class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
