<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // コントローラーにもミドルウェアの設定を行う。下記のコントローラーミドルウェア参照。
    // https://readouble.com/laravel/8.x/ja/controllers.html
    public function __construct()
    {
        $this->middleware('auth:owners');
        // オーナーが別の店舗にアクセスできないようにする処理
        $this->middleware( function( $request , $next ){
            // 下記で店舗IDを取得する
            // dd($request->route()->parameter('shop')); //文字列
            // dd(Auth::id()); //数字
            // 「http://127.0.0.1:8000/owner/shops/edit/1」にアクセスすると"1"と出力される
            // 「http://127.0.0.1:8000/owner/shops/edit/2」にアクセスすると"2"と出力される
            // URLを書き換えると別の店舗情報を取得することができる
            // 「http://127.0.0.1:8000/owner/shops/index」にアクセスするとnullになる

            // 店舗IDを取得する
            $id = $request->route()->parameter('shop');
            // 店舗IDがnull出端良い場合に
            if( !is_null( $id ) ) {
                // 店舗のオーナーのIDを取得する
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                // 店舗のオーナーのIDを文字列から数字に変換する
                $shopId = (int)$shopsOwnerId;
                // ログインしているオーナーのIDを取得する
                $ownerId = Auth::id();
                // ログインしているオーナーのIDと店舗IDが同じではない場合に404ページを返す
                if( $shopId !== $ownerId ) {
                    abort(404);
                }
            }
            return $next( $request );
        });
    }

    public function index()
    {
        // ログインしているオーナーのIDの取得
        // $ownerId = Auth::id();
        // Shopモデルのowner_idで、ownerIdを検索して、一致した情報を取得
        $shops = Shop::where( 'owner_id' , Auth::id() )->get();

        return view( 'owner.shops.index' , compact('shops') );
    }

    public function edit( $id )
    {
        dd(Shop::findOrFail($id));
    }

    public function update( Request $request , $id )
    {

    }
}
