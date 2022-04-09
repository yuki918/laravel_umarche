<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:users');
    }

    public function index()
    {
        $stocks = DB::table('t_stocks')
            ->select('product_id',DB::raw('sum(quantity) as quantity'))
            ->groupBy('product_id')
            ->having('quantity','>=',1);
        $products = DB::table('products')
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
                    ,'image01.filename as filename')
            ->get();

        // dd($stocks,$products);
        return view('user.index',compact('products'));
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
