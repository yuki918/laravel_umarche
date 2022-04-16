<?php

namespace App\Services;

use App\Models\product;
use App\Models\Cart;

class CartService
{
    public function getItemsInCart($items)
    {
        $products = [];
        // dd($items);
        foreach($items as $item) {
            // 1つの商品情報を取得する
            $productInfo = Product::findOrFail($item->product_id);
            // $productInfoからリレーションを繋げて、オーナーの名前とメールアドレスの1回目の情報だけを配列で取得する
            $owner       = $productInfo->shop->owner->select('name' , 'email')->first()->toArray();
            // $ownerの配列にあるキー名のnameが$productにも同じ名前で存在するので、キー名を変更する
            // array_values関数で値だけを取得する
            $values      = array_values($owner);
            // $keysでキー名を設定する
            $keys        = ['ownerName' , 'email'];
            // array_combine関数で指定された2つの配列から連想配列を作成する
            $ownerInfo   = array_combine($keys , $values);
            // id,name,priceの商品情報を配列として取得する
            $product     = Product::where('id' , $item->product_id)
                            ->select('id' , 'name' , 'price')->get()->toArray();
            // 在庫数を配列として取得する
            $quantity    = Cart::where('product_id' , $item->product_id)
                            ->select('quantity')->get()->toArray();
            $result      = array_merge($product[0] , $ownerInfo , $quantity[0]);
            // dd($ownerInfo , $product , $quantity , $result);
            // $reslutの配列は以下のようになる
            // array:6 [▼
            //   "id" => 135
            //   "name" => "小泉 翔太"
            //   "price" => 4662
            //   "ownerName" => "test01"
            //   "email" => "test01@gmail.com"
            //   "quantity" => 9
            // ]
            array_push($products , $result);
        }
        return $products;
    }
}