<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/23
 * Time: 11:48
 */
define('API_SECRET_PARAM', 'api_url_secret');
define('API_SECRET_CODE',  '0A1B0c2D0e3F0G');

return [
    'URL_ROUTE_RULES' => [
        ['index$', 'Index/index',  API_SECRET_PARAM.'='.API_SECRET_CODE, ['method' => 'get']],

    ]
];