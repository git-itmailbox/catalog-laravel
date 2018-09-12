<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Category
 *
 * @mixin Eloquent
 */
class Category extends Model
{

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany('Product');
    }


}
