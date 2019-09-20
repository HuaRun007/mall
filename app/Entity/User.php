<?php

namespace App\Entity;


use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * App\Entity\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $roles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use EntrustUserTrait {
        EntrustUserTrait::can as hasPermission;
        restore as private restoreA;
    }
    use SoftDeletes { restore as private restoreB; }


    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $dates = ['delete_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name' ,'email','phone', 'password','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 解决 EntrustUserTrait 和 SoftDeletes 冲突
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

}
