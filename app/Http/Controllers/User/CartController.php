<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;

class CartController extends Controller
{

    public function index()
    {
        $user       = User::findOrFail(Auth::id());
        $products   = $user->products;
        $totalPrice = 0;

        // 全商品の合計金額の算出
        foreach($products as $product) {
            $totalPrice = $product->price * $product->pivot->quantity;
        }
        // dd($product,$totalPrice);
        return view('user.cart' , compact('products','totalPrice'));
    }

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
        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        Cart::where('product_id',$id)->where('user_id',Auth::id())->delete();
        return redirect()->route('user.cart.index');
    }

    public function checkout()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        // stripeに情報を渡すために、stripe用の命名規則で情報を渡す
        // https://stripe.com/docs/api/checkout/sessions/create
        $lineItems = [];
        foreach($products as $product) {
            $lineItem = [
                'name'        => $product->name,
                'description' => $product->information,
                'amount'      => $product->price,
                'currency'    => 'jpy',
                'quantity'    => $product->pivot->quantity,
            ];
            array_push($lineItems,$lineItem);
        }
        // dd($lineItems);

        // stripe側に秘密鍵と商品情報を渡す
        // 秘密鍵はenvファイルに記述しているので、変数として取得する
        // https://stripe.com/docs/checkout/quickstart
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items'  => [$lineItems],
            'mode'        => 'payment',
            // 支払いが成功した場合のリダイレクト処理
            'success_url' => route('user.items.index'),
            // 支払いがキャンセルした場合のリダイレクト処理
            'cancel_url'  => route('user.cart.index'),
        ]);
        // 公開鍵の取得。秘密鍵と公開鍵の両方の情報を渡すことで、決済することができる
        $publicKey = env('STRIPE_PUBLIC_KEY');
        return view('user.checkout',compact('session','publicKey'));
    }
}
