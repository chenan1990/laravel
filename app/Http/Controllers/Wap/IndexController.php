<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 13:48
 */
namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class IndexController extends  Controller
{

    public function index(Request $request)
    {
        $app = new Application(config('wechat'));
        $oauth = $app->oauth;
        $user = session('wechat_user');

        // 未登录
        if (empty(session('wechat_user'))) {
            $request->session()->put('target_url',url('wap/index'));
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        } else {
            return view("wap.index");
        }
        // 已经登录过

    }
}