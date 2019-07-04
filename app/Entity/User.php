<?php

namespace App\Entity;


use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
