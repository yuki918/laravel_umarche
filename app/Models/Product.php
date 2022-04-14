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

    public function scopeSortOrder($query , $sortOrder)
    {
        // sortOrderに値がない場合（初期値）、若しくはrecommendが選択されいる場合
        if($sortOrder === null || $sortOrder === \Constants::SORT_ORDER['recommend']) {
            return $query->orderBy('sort_order','asc');
        }
        if($sortOrder === \Constants::SORT_ORDER['order']) {
            return $query->orderBy('products.created_at','asc');
        }
        if($sortOrder === \Constants::SORT_ORDER['later']) {
            return $query->orderBy('products.created_at','desc');
        }
        if($sortOrder === \Constants::SORT_ORDER['lowerPrice']) {
          return $query->orderBy('price','asc');
        }
        if($sortOrder === \Constants::SORT_ORDER['higherPrice']) {
            return $query->orderBy('price','desc');
        }
    }

    public function scopeSelectCategory($query , $categoryId)
    {
        if($categoryId !== '0') {
            return $query->where('secondary_category_id' , $categoryId);
        } else {
            return;
        }
    }

    public function scopeSearchKeyword($query , $keyword)
    {
        if(!is_null($keyword)) {
            //全角スペースを半角に
            $spaceConvert = mb_convert_kana($keyword,'s');
            // preg_split関数で空白ごとの文字を配列として取得する
            // https://www.php.net/manual/ja/function.preg-split.php
            $keywords = preg_split('/[\s]+/', $spaceConvert,-1,PREG_SPLIT_NO_EMPTY);
            foreach($keywords as $word) {
                // あいまい検索
                $query->where('products.name','like','%'.$word.'%');
            }
            return $query; 
        } else {
            return;
        }
    }
}
