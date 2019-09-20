<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Comment
 *
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $table = 'comment';
    protected  $primaryKey = 'id';
}
