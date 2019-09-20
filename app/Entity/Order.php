<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Order
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\OrderDetail[] $order_detail
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public function order_detail(){
        return $this->hasMany(OrderDetail::class);
    }
}
