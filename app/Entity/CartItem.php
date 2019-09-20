<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\CartItem
 *
 * @mixin \Eloquent
 */
class CartItem extends Model
{
    //
    protected $table = 'cart_item';
    protected $primaryKey = 'id';
}
