<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2018/10/26
 * Time: 10:29
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;

class TempEmail extends Model
{
    protected $table = 'temp_email';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
