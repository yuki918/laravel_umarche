<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use App\Jobs\SendThanksMail;

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

        // 自動送信用の情報を取得
        // ユーザーがカートに入れた商品情報を取得する
        $items    = Cart::where('user_id' , Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user     = User::findOrFail(Auth::id());

        SendThanksMail::dispatch($products , $user);
        dd($products);

        $products = $user->products;

        // stripeに情報を渡すために、stripe用の命名規則で情報を渡す
        // https://stripe.com/docs/api/checkout/sessions/create
        $lineItems = [];
        foreach($products as $product) {
            $quantity = "";
            $quantity = Stock::where('product_id',$product->id)->sum('quantity');
            // 商品の在庫数よりも購入数が多い場合は、カートページにリダイレクト処理をする
            if($product->pivot->quantity > $quantity) {
                return redirect()->route('user.cart.index');
            // 購入数よりも商品在庫が多い場合は、商品情報を配列にする
            } else {
                $lineItem = [
                    'name'        => $product->name,
                    'description' => $product->information,
                    'amount'      => $product->price,
                    'currency'    => 'jpy',
                    'quantity'    => $product->pivot->quantity,
                ];
                array_push($lineItems,$lineItem);
            }
        }
        // stripeで決済処理をする前に、商品の在庫を減らしておく
        foreach($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type'       => \Constants::PRODUCT_LIST['reduce'],
                'quantity'   => $product->pivot->quantity * -1,
            ]);
        }

        // dd($lineItems);
        // dd('test');

        // stripe側に秘密鍵と商品情報を渡す
        // 秘密鍵はenvファイルに記述しているので、変数として取得する
        // https://stripe.com/docs/checkout/quickstart
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [$lineItems],
            'mode'        => 'payment',
            // 支払いが成功した場合のリダイレクト処理
            'success_url' => route('user.cart.success'),
            // 支払いがキャンセルした場合のリダイレクト処理
            'cancel_url'  => route('user.cart.cancel'),
        ]);
        // 公開鍵の取得。秘密鍵と公開鍵の両方の情報を渡すことで、決済することができる
        $publicKey = env('STRIPE_PUBLIC_KEY');
        return view('user.checkout',compact('session','publicKey'));
    }

    public function success()
    {
        Cart::where('user_id',Auth::id())->delete();
        return redirect()->route('user.items.index');
    }

    public function cancel()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        foreach($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type'       => \Constants::PRODUCT_LIST['add'],
                'quantity'   => $product->pivot->quantity,
            ]);
        }
        return redirect()->route('user.cart.index');
    }
}
