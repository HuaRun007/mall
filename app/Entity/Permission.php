<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/4/2
 * Time: 23:47
 */

namespace App\Entity;


use Zizaco\Entrust\EntrustPermission;

/**
 * App\Entity\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $roles
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{
    //
    protected $table = 'permission';
    protected $primaryKey = 'id';
}