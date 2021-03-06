<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// エロクアント
use App\Models\Owner;
use App\Models\Shop;
// クエリビルダー
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
// パスワードのバリデーション
use Illuminate\Validation\Rules;
use Throwable;
use Illuminate\Support\Facades\Log;


class OwnersController extends Controller
{
    // コントローラーにもミドルウェアの設定を行う。下記のコントローラーミドルウェア参照。
    // https://readouble.com/laravel/8.x/ja/controllers.html
    public function __construct()
    {
        $this->middleware("auth:admins");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_now = Carbon::now();
        $date_parse = Carbon::parse(now());
        // echo $date_now->year;
        // echo $date_now;
        // echo $date_parse;

        $e_all = Owner::all();
        $q_get = DB::table("owners")->select("name","created_at")->get();
        // $q_fast =  DB::table("owners")->select("name")->first();
        // $c_test = collect([
        //     "name" => "test"
        // ]);


        // var_dump($q_fast);
        // dd($e_all,$q_get,$q_fast,$c_test);
        $owners = Owner::select("id","name","email","created_at")->paginate(3);
        return view("admin.owners.index",compact("owners"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.owners.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // オーナーを登録するときのバリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // laravelは大抵のエラーは処理するが、想定外のエラーの場合の処理。

        // 例外処理でのデバック処理。テンプレート。
        // https://readouble.com/laravel/8.x/ja/errors.html
        // https://www.plus-one.tech/posts/2020/03/04.html
        try {
            DB::transaction(function () use( $request ) {
                $owner = Owner::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Shop::create([
                  'owner_id'    => $owner->id,
                  'name'        => "店舗名を入力してください",
                  'information' => '',
                  'filename'    => '',
                  'is_selling'  => true,
                ]);
            },2);
        } catch ( Throwable $e ) {
            // 全てのエラー・例外をキャッチしてログに残す
            // ログが保存される場所
            // storage\logs\laravel.log
            Log::error($e);
            // フロント（画面）に異常を通知するため例外はそのまま投げる
            throw $e;
        }

        // リクエストされたオーナー情報を登録する
        // Owner::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);
        // リダイレクト処理
        return redirect()
          ->route("admin.owners.index")
          ->with(["message" => "オーナー登録が完了しました","status" => "info"]);
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
        // findOrFailによって存在しないIDの場合は、404に返す。
        $owners = Owner::findOrFail($id);
        // dd($owners);
        return view("admin.owners.edit",compact("owners"));
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
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()
          ->route("admin.owners.index")
          ->with(["message" => "オーナー情報を更新しました。","status" => "info"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // ソフトデリート
        Owner::findOrFail($id)->delete();
        // リダイレクト処理
        return redirect()
          ->route("admin.owners.index")
          ->with(["message" => "オーナー情報を削除しました。","status" => "alert"]);
    }

    public function expiredOwnerIndex()
    {
        // onlyTrashed関数でゴミ箱にあるオーナー情報を取得する
        $expiredOwners = Owner::onlyTrashed()->get();
        // compact関数でview側に変数を渡す
        return view('admin.expired-owners' , compact('expiredOwners'));
    }

    public function expiredOwnerDestroy($id)
    {
        // findOrFailでIDがない場合は、404ページを返す
        // onlyTrashed関数でゴミ箱にあるオーナー情報を取得して、forceDelete関数で物理的（完全）に削除する
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()
            ->route('admin.expired-owners.index')
            ->with(["message" => "オーナー情報を完全に削除しました。","status" => "alert"]);
    }
}
