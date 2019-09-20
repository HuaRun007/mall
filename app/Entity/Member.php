<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Entity\Member
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Member onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Member withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Member withoutTrashed()
 * @mixin \Eloquent
 */
class Member extends Model
{

    use SoftDeletes;
    protected $table = 'member';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
