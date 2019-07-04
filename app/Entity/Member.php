<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Member extends Model
{

    use SoftDeletes;
    protected $table = 'member';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
