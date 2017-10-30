<?php
return array(
	//'配置项'=>'配置值'
    'LOAD_EXT_CONFIG' => 'routers,easyWeChat,worker_score',
    'URL_ROUTER_ON'     => true,    // 开启路由
    // 视图输出字符串内容替换
    'TMPL_PARSE_STRING'  =>array(
        '__PUBLIC__' => '/Public', // 更改默认的/Public 替换规则
    )
);