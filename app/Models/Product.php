<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;
use App\Models\User;

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

    public function users()
    {
        return $this->BelongsToMany(User::class,'carts')->withPivot(['id','quantity']);
    }


    // ローカルスコープでコントローラーの肥大化を抑えつつ、再利用できるようにする
    // app\Models\Product.phpのindexで使用
    public function scopeAvailableItems($query)
    {
        $stocks = DB::table('t_stocks')
            ->select('product_id',DB::raw('sum(quantity) as quantity'))
            ->groupBy('product_id')
            ->having('quantity','>=',1);

        return $query
            ->joinSub($stocks,'stock',function($join) {
                $join->on('products.id','=','stock.product_id');
            })
            ->join('shops','products.shop_id','=','shops.id')
            ->join('secondary_categories','products.secondary_category_id', '=','secondary_categories.id')
            ->join('images as image01', 'products.image01', '=', 'image01.id')
            ->where('shops.is_selling',true)
            ->where('products.is_selling',true)
            ->select('products.id as id', 'products.name as name', 'products.price'
                    ,'products.sort_order as sort_order'
                    ,'products.information', 'secondary_categories.name as category'
                    ,'image01.filename as filename');
    }
}
