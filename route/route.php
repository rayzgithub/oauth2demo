<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/****************************app route*********************************/

\think\facade\Route::domain(\think\facade\Env::get('domain.home'), function(){

    //app获取code回调url
    \think\facade\Route::get('/recieve_authorization_code','index/recieveAuthorizationCode');

})->bind('home');


/****************************server route*********************************/

\think\facade\Route::domain(\think\facade\Env::get('domain.server'), function(){
    //server获取code回调url
    \think\facade\Route::get('/','login/index');
    //server获取code回调url
    \think\facade\Route::get('/login/index','login/index');

    //server获取code回调url
    \think\facade\Route::get('/authorize_code','authorize/authorizeCode');

    //server获取code回调url
    \think\facade\Route::get('/access_token','server/authorize/authorizeToken');

    //server 获取userinfo
    \think\facade\Route::get('/user_info','server/authorize/authorizeUserInfo');

})->bind('server');


return [

];
