<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// エロクアント
use App\Models\Owner;
// クエリビルダー
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
// パスワードのバリデーション
use Illuminate\Validation\Rules;

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
        $owners = Owner::select("name","email","created_at")->get();
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
        // リクエストされたオーナー情報を登録する
        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // リダイレクト処理
        return redirect()
          ->route("admin.owners.index")
          ->with("message","オーナー登録が完了しました");
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
