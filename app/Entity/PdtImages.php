<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\PdtImages
 *
 * @mixin \Eloquent
 */
class PdtImages extends Model
{
    //
    protected $table      =  'pdt_images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'image_path' ,'image_no','price', 'product_id',
    ];

}
