<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Shop;
use App\Services\imageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

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
        // phpinfo();
        // ログインしているオーナーのIDの取得
        // $ownerId = Auth::id();
        // Shopモデルのowner_idで、ownerIdを検索して、一致した情報を取得
        $shops = Shop::where( 'owner_id' , Auth::id() )->get();
        return view( 'owner.shops.index' , compact('shops') );
    }

    public function edit( $id )
    {
        $shop = Shop::findOrFail($id);
        return view( 'owner.shops.edit' , compact('shop') );
    }

    public function update( UploadImageRequest $request , $id )
    {
        // imageはname属性で設定されている値
        $imageFile = $request->image;
        // $imageFileがnullでなく、問題なくアップロードできる（isValid関数で確認）場合
        if( !is_null($imageFile) && $imageFile->isValid() ) {
              // // https://readouble.com/laravel/8.x/ja/filesystem.html
              // // 画像のファイル名と「public/storage/shops」というフォルダを自動生成をするテンプレート
              // // Storage::putFile( 'public/shops' , $imageFile );

              // // リサイズしないなら上記の記述で問題ないが、リサイズするので、記述の変更
              // // ランダムな数値_13桁の文字列
              // $fileName        = uniqid( rand().'_' );
              // // 拡張子の取得
              // $extension       = $imageFile->extension();
              // $fileNameToStore = $fileName.'.'.$extension;
              // // phpの画像ライブラリ（laravelの初期値にはない）で画像のリサイズ処理を行う
              // // https://intervention.io/
              // $resizedImage    = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
              // // dd($fileName,$resizedImage);
              // Storage::put( 'public/shops/'.$fileNameToStore , $resizedImage );
              
              // 上記を全て下記で関数化したため削除する
              // app\Services\imageService.php
              $fileNameToStore = ImageService::upload( $imageFile , 'shops' );
          }
          return redirect()->route('owner.shops.index');
    }
}
