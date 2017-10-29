<?php

namespace Home\Controller;

use Common\Common\Controller\BaseController;
use EasyWeChat\Foundation\Application;
use Think\Log;
class IndexController extends BaseController {
    public function index()
    {
        $config = C('easyWeChat');

        $app = new Application($config);
// 从项目实例中得到服务端应用实例。
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return "您好！欢迎关注我!";
        });
        $response = $server->serve();
//        return $response;
        $response->send(); // Laravel 里请使用：return $response;



    }
}