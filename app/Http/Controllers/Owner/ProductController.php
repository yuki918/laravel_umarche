<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Image;
use App\Models\Shop;
use App\Models\PrimaryCategory;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware( function( $request , $next ){
            $id = $request->route()->parameter('product');
            if( !is_null( $id ) ) {
                $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                $productId = (int)$productsOwnerId;
                if( $productId !==  Auth::id() ) {
                    abort(404);
                }
            }
            return $next( $request );
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ログインしているオーナーに紐づくショップの商品を取得する
        // 下記の記述方法では「n+1問題」が発生するので、別の記述をする
        // https://readouble.com/laravel/8.x/ja/eloquent-relationships.html
        // $products = Owner::findOrFail(Auth::id())->shop->product;
        $ownerInfo = Owner::with('shop.product.imageFirst')
            ->where('id' , Auth::id())->get();
        // dd($ownerInfo);
        // foreach($ownerInfo as $owner) {
        //     // dd($owner->shop->product);
        //     foreach($owner->shop->product as $product) {
        //         dd($product->imageFirst->filename);
        //     }
        // }

        return view('owner.products.index' , compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ログインしているオーナーIDと合致するshopモデルのowner_idのレコードを取得する
        // 上記で取得した情報の中から、更にidとnameの情報を取得する
        $shops = Shop::where('owner_id' , Auth::id())->select('id' , 'name')->get();
        $images = Image::where('owner_id' , Auth::id())
            ->select('id' , 'title' , 'filename')->orderBy('updated_at' , 'desc')->get();
        // 「app\Models\PrimaryCategory.php」で設定した関数名をしようしているので、フルネームでは書いていない
        $categories = PrimaryCategory::with('secondary')->get();

        return view('owner.products.create' , compact('shops' , 'images' , 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name'        => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'price'       => ['required', 'integer'],
            'quantity'    => ['required', 'integer'],
            'sort_order'  => ['required', 'nullable'],
            'shop_id'     => ['required', 'exists:shops,id'],
            'category'    => ['required', 'exists:secondary_categories,id'],
            'image01'     => ['nullable', 'exists:images,id'],
            'image02'     => ['nullable', 'exists:images,id'],
            'image03'     => ['nullable', 'exists:images,id'],
            'image04'     => ['nullable', 'exists:images,id'],
            'is_selling'  => ['required'],
        ]);

        try {
            DB::transaction(function () use( $request ) {
                $product = Product::create([
                    'name'        => $request->name,
                    'information' => $request->information,
                    'price'       => $request->price,
                    'quantity'    => $request->quantity,
                    'sort_order'  => $request->sort_order,
                    'shop_id'     => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image01'     => $request->image01,
                    'image02'     => $request->image02,
                    'image03'     => $request->image03,
                    'image04'     => $request->image04,
                    'is_selling'  => $request->is_selling,
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type'       => 1,
                    'quantity'   => $request->quantity,
                ]);
            },2);
        } catch ( Throwable $e ) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route("owner.products.index")
            ->with(["message" => "商品登録が完了しました","status" => "info"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
