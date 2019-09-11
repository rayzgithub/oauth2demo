<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @name 接口返回数据  - common
 * @param $key
 * @param array $values
 * @return array
 */
function make_ret($code,$msg = '',$data = null,$other = null){
    return [
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
        'other' => $other
    ];
}

/**
 * 生成UUID 单机使用
 * @access public
 * @return string
 */
function uuid() {
    $charid = md5(uniqid(mt_rand(), true));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12)
        .chr(125);// "}"
    return $uuid;
}

/**
 * 生成Guid主键
 * @return string
 */
function key_gen() {
    return str_replace('-','',substr(uuid(),1,-1));
}

function gen_cache_code($code,$appid){
    return "code_" . md5($code . $appid);
}

function gen_cache_token($token,$appid){
    return "token_" . md5($token . $appid);
}

function gen_cache_usertoken($username){
    return $username . "_token";
}