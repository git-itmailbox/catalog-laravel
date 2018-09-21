<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Product extends Model
{
    const FACTOR = 100;

    protected $fillable = ['name', 'description', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | ItemPicture
     */
    public function pictures()
    {
        return $this->hasMany(ItemPicture::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany | Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id');
    }

    public function scopeSmallPictures()
    {
        return $this->pictures()->where('size', ItemPicture::IMAGE_SIZE_110);
    }

    public function scopeMediumPictures()
    {
        return $this->pictures()->where('size', ItemPicture::IMAGE_SIZE_250);
    }

    public function scopeLargePictures()
    {
        return $this->pictures()->where('size', ItemPicture::IMAGE_SIZE_450);
    }

    public function scopeHasCategories($query, array $ids)
    {
        return $query->whereHas('categories', function ($q) use ($ids) {
            $q->whereIn('category_id', $ids);
        });
    }

    public function getFirstSmallPicture()
    {
        return $this->smallPictures()->first();
    }

    public function getFormattedPrice()
    {
        return $this->price / static::FACTOR;
    }


}
