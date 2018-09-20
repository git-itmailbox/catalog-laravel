<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPicture extends Model
{
    const IMAGE_SIZE_110 = 1;
    const IMAGE_SIZE_250 = 2;
    const IMAGE_SIZE_450 = 3;

    protected $fillable = ['product_id', 'size', 'path'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->belongsTo('Product');
    }
    //
}
