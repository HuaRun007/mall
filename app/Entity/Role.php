<?php

namespace App\Entity;

use Zizaco\Entrust\EntrustRole;

/**
 * App\Entity\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\User[] $users
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{
    //
    protected $table = 'roles';
    protected $primaryKey = 'id';
}
