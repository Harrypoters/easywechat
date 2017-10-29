<?php

namespace Home\Controller;

use Common\Common\Controller\BaseController;
use Composer\Config;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
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
//            return "您好！欢迎关注我!";
            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return new News([
                        'title'       => '你好，欢迎来到萧风公众号',
                        'description' => '点击进入百度网址',
                        'url'         => 'https://www.baidu.com/',
                        'image'       => 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png',
                        // ...
                    ]);
//                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        $response = $server->serve();
//        return $response;
        $response->send(); // Laravel 里请使用：return $response;
    }

    //群发
    public function weiXinBroadcast()
    {
        $config = C('easyWeChat');
        $app = new Application($config);

        $broadcast = $app->broadcast;
        $broadcast->sendText("大家好！欢迎使用 EasyWeChat。");
        die('群发成功');
    }

    //模板消息
    public function wxNotic()
    {
        $config = C('easyWeChat');
        $app = new Application($config);

        $notice = $app->notice;

        $messageId = $notice->send([
            'touser' => 'orpK-1epV3_mA2gYEZBvXYxINv94', //user_openid
            'template_id' => 'rNJUkEWGlJhRQYSYBngugiHCXDel15njrtlJ6CDVFtc',
            'url' => 'www.baidu.com',
            'data' => [
                "first"  => "恭喜你购买成功！",
                "name"   => "巧克力",
                "price"  => "39.8元",
                "remark" => "欢迎再次购买！",
            ],
        ]);
    }

    //用户信息
    public function wxUser()
    {
        $config = C('easyWeChat');
        $app = new Application($config);

        $openId = 'orpK-1epV3_mA2gYEZBvXYxINv94';
        $userService = $app->user;
        $userService->get($openId);
//        dd($userService->get($openId));
        dd($userService->lists());
    }
}