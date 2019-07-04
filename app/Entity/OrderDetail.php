<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected  $table = 'order_detail';
    protected  $primaryKey = 'id';

    public $timestamps = false;

    public function order(){
            return $this->belongsTo(Order::class);
    }

}
