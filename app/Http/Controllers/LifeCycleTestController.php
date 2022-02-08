<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceProviderTest() {
        $encrypt = app()->make("encrypter");
        $password = $encrypt->encrypt("password");

        $sample = app()->make("ServiceProviderTest");

        dd($sample,$password,$encrypt->decrypt($password));
    }

    public function showServiceContainerTest()
    {
        app()->bind("lifeSycleTest",function() {
            return "ライフサイクルのテスト";
        });

        // サービスコンテナなしのパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();
        // サービスコンテナありのパターン
        app()->bind("sample",Sample::class);
        $sample = app()->make("sample");
        $sample->run();

        $test = app()->make("lifeSycleTest");
        dd($test,app());

        dd(app());
    }
}

class Sample
{
    public $message;
    public function __construct(Message $message) {
        $this->message = $message;
    }
    public function run() {
        $this->message->send();
    }
}

class Message
{
    public function send() {
        echo("メッセージを表示");
    }
}