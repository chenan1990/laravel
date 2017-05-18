<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 14:07
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use EasyWeChat\Support\Log;
use Illuminate\Http\Request;

class WebController extends  Controller
{
    public function __construct()
    {
        $this->app = new Application(config('wechat'));
    }

    public function index(Request $request)
    {
        $input = $request->input();
        Log::debug('input:', [
            'input' => $input,
        ]);
        $server = $this->app->server;

        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            switch ($message->MsgType) {
                case 'event':
                    # code...
                    switch ($message->Event) {
                        case 'subscribe':
                            return '欢迎关注我的测试公众号';
                            break;
                        default:
                            # code...
                            break;
                    }
                    break;
                case 'text':
                    return new Text(['content' => 'text']);
                    break;
            }
        });

        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
//        echo '8888';
    }
}