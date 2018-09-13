<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const FACTOR = 100;

    protected $fillable = ['name', 'description', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pictures()
    {
        return $this->belongsToMany('ItemPicture');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany | Category
     */
    public function categories()
    {
        return $this->belongsToMany('Category');
    }


}
