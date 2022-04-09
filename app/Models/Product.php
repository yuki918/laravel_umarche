<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image01',
        'image02',
        'image03',
        'image04',
    ];

    public function Shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class , 'secondary_category_id');
    }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class , 'image01' , 'id');
    }

    public function imageSecond()
    {
        return $this->belongsTo(Image::class , 'image02' , 'id');
    }

    public function imageThird()
    {
        return $this->belongsTo(Image::class , 'image03' , 'id');
    }

    public function imageFourth()
    {
        return $this->belongsTo(Image::class , 'image04' , 'id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}