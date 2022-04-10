<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // カートモデルのproduct_idから取得したproduct_idに一致する情報の取得
        // 尚且つログインしているユーザー
        $itemInCart = Cart::where('product_id',$request->product_id)->where('user_id',Auth::id())->first();

        // カートに既に同じ商品がある場合は、商品の数量を増やす
        if($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
          // カートに同じ商品がない場合は商品情報をデータベースに保存する
          Cart::create([
              'user_id'    => Auth::id(),
              'product_id' => $request->product_id,
              'quantity'   => $request->quantity,
          ]);
        }
        dd('test');
    }
}
