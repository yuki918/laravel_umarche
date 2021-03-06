<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\Product;
use App\Services\imageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware( function( $request , $next ){
            $id = $request->route()->parameter('image');
            if( !is_null( $id ) ) {
                $imagesOwnerId = Image::findOrFail($id)->owner->id;
                $imageId = (int)$imagesOwnerId;
                if( $imageId !==  Auth::id() ) {
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
        $images = Image::where( 'owner_id' , Auth::id() )
            ->orderBy( 'updated_at' , 'desc' )
            ->paginate(20);
        return view( 'owner.images.index' , compact('images') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        // ファイルメソッドでname属性の「files」を取得する
        $imageFiles = $request->file('files');
        // 複数の画像を取得しているので、繰り返し処理をする
        if( !is_null( $imageFiles ) ) {
            foreach( $imageFiles as $imageFile ) {
                $fileNameToStore = ImageService::upload( $imageFile , 'products' );
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                ]);
            }
        }
        return redirect()
              ->route('owner.images.index')
              ->with(["message" => "画像登録が完了しました。","status" => "info"]);
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
        $image = Image::findOrFail($id);
        return view( 'owner.images.edit' , compact('image') );
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
        $request->validate([
            'title' => [ 'string' , 'max:50' ]
        ]);
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();
        return redirect()
              ->route('owner.images.index')
              ->with(["message" => "画像情報が更新されました","status" => "info"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image    = Image::findOrFail($id);
        // 画像の保存場所の取得
        $filePath = 'public/products/' . $image->filename;
        $imageInProdcuts = Product::where('image01',$image->id)
            ->orWhere('image02',$image->id)
            ->orWhere('image03',$image->id)
            ->orWhere('image04',$image->id)->get();
        if($imageInProdcuts) {
            $imageInProdcuts->each(function($product) use($image) {
                if($product->image01 === $image->id) {
                    $product->image01 = null;
                    $product->save();
                }
                if($product->image02 === $image->id) {
                    $product->image02 = null;
                    $product->save();
                }
                if($product->image03 === $image->id) {
                    $product->image03 = null;
                    $product->save();
                }
                if($product->image04 === $image->id) {
                    $product->image04 = null;
                    $product->save();
                }
            });
        }
        // もし画像が存在したら、削除する
        if( Storage::exists( $filePath ) ) {
            Storage::delete( $filePath );
        }
        // データベースの情報削除
        Image::findOrFail( $id )->delete();
        return redirect()
          ->route("owner.images.index")
          ->with(["message" => "画像を削除しました。","status" => "alert"]);
    }
}
