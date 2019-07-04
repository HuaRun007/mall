<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public function order_detail(){
        return $this->hasMany(OrderDetail::class);
    }
}
