<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use App\Mail\TestMail;
use App\Jobs\SendThanksMail;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:users');

        $this->middleware( function( $request , $next ) {
            $id = $request->route()->parameter('item');
            if( !is_null( $id ) ) {
                $itemId = Product::availableItems()->where('products.id' , $id)->exists();
                if( !$itemId ) {
                    abort(404);
                }
            }
            return $next( $request );
        });
    }

    public function index(Request $request)
    {
        // メール設定(動機的に送信)
        // Mail::to('test@sample.com')->send(new TestMail());

        // メール設定(jobを使って非同期的に送信する)
        // SendThanksMail::dispatch();

        // dd($request);
        $products = Product::availableItems()
            // app\Models\Product.phpで定義しているscopeSortOrder、scopeSelectCategory、scopeSearchKeyword
            // Null合体演算子を用いて、値がない場合は（つまりは初期値）値を補完している
            ->selectCategory($request->category ?? '0')
            ->searchKeyword($request->keyword)
            ->sortOrder($request->sort)
            ->paginate($request->pagination ?? '20');
        // dd($stocks,$products);
        $categories = PrimaryCategory::with('secondary')->get();
        return view('user.index',compact('products' , 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id',$product->id)->sum('quantity');
        if($quantity > 9) {
          $quantity = 9;
        }
        return view('user.show',compact('product','quantity'));
    }
}
