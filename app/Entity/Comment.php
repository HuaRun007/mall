<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected  $primaryKey = 'id';
}
