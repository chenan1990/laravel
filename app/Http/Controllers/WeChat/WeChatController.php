<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 14:07
 */
namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use EasyWeChat\Support\Log;
use Illuminate\Http\Request;

class WeChatController extends  Controller
{
    public function __construct()
    {
        $this->app = new Application(config('wechat'));
    }

    public function index(Request $request)
    {
        $openPlatform = $this->app->open_platform;

        $server = $openPlatform->server;
        $server->setMessageHandler(function($event) use ($openPlatform) {
            // 事件类型常量定义在 \EasyWeChat\OpenPlatform\Guard 类里
            switch ($event->InfoType) {
                case Guard::EVENT_AUTHORIZED: // 授权成功
                    $authorizationInfo = $openPlatform->getAuthorizationInfo($event->AuthorizationCode);
                // 保存数据库操作等...
                case Guard::EVENT_UPDATE_AUTHORIZED: // 更新授权
                    // 更新数据库操作等...
                case Guard::EVENT_UNAUTHORIZED: // 授权取消
                    // 更新数据库操作等...
            }
        });
        $response = $server->serve();
        $response->send(); // Laravel 里请使用：return $response;


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

    //授权页
    public function auth(Request $request)
    {
        $app = $this->app;
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $request->session()->put('wechat_user',  $user->toArray());

        $targetUrl = empty(session('target_url')) ? '/' : session('target_url');
        header('location:'. $targetUrl); // 跳转到 user/profile
    }
}