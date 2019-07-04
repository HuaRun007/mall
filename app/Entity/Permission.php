<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/4/2
 * Time: 23:47
 */

namespace App\Entity;


use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    //
    protected $table = 'permission';
    protected $primaryKey = 'id';
}