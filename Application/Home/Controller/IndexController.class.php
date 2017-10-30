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
        dd($messageId);
    }

    //用户信息
    public function wxUser()
    {
        $config = C('easyWeChat');
        $app = new Application($config);

        $openId = 'orpK-1epV3_mA2gYEZBvXYxINv94';
        //用户详细信息
//        $userService = $app->user;
//        $userService->get($openId);

        //用户分组
        $group = $app->user_group;
        //创建分组
        $group->create('好朋友');
        $group->delete('102'); //分组的id
//        dd($userService->get($openId));
//        dd($userService->lists());
        dd($group->lists());
    }

    //网页授权
    public function oauth()
    {
        $config = C('easyWeChat');
        $app = new Application($config);
        $oauth = $app->oauth;
// 未登录
        if (session()->has('wechat_user')) {
//            $_SESSION['target_url'] = 'user/profile';
            session(['target_url' => 'user/profile']);
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
// 已经登录过
//        $user = $_SESSION['wechat_user'];
        $user = session('wechat_user');
        dd(session('wechat_user'));
    }
    public function oauthCallback()
    {
        $config = C('easyWeChat');
        $app = new Application($config);
        $oauth = $app->oauth;
// 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
//        $_SESSION['wechat_user'] = $user->toArray();
        session(['wechat_user'=> $user->toArray()]);
//        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
        $targetUrl = session()->has('target_url') ? '/' : session('target_url');
        dd('target_url');
//        header('location:'. $targetUrl); // 跳转到 user/profile
    }

    //素材管理
    public function material()
    {
        $config = C('easyWeChat');
        $app = new Application($config);

        $openId = 'orpK-1epV3_mA2gYEZBvXYxINv94';
        // 永久素材
        $material = $app->material;

        $result = $material->uploadImage($_SERVER['DOCUMENT_ROOT'].'/easywechat/img/11.png');
    }
}