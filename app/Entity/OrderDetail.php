<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\OrderDetail
 *
 * @property-read \App\Entity\Order $order
 * @mixin \Eloquent
 */
class OrderDetail extends Model
{
    protected  $table = 'order_detail';
    protected  $primaryKey = 'id';

    public $timestamps = false;

    public function order(){
            return $this->belongsTo(Order::class);
    }

}
