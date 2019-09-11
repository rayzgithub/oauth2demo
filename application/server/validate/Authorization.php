<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 2019/9/5
 * Time: 17:51
 */
namespace app\server\validate;

use think\facade\Config;
use think\Validate;

class Authorization extends Validate{

    protected $rule = [
        'appid' => 'require|checkAppid',
        'response_type' => 'require',
        'redirect_url' => 'url',
        'secret' => 'require|checkAppSecret',
        'code' => 'require',
        'access_token' => 'require'
    ];

    protected $message = [
        'appid.require' => 'appid is required',
        'appid.checkAppid' => 'invalid appid',
        'response_type.require' => 'response_type is required',
        'redirect_url.require' => 'redirect_url is required',
        'secret.require' => 'secret is required',
        'secret.checkAppSecret' => 'invalid secret',
        'code.require' => 'code is required',
        'access_token.require' => 'access_token is required'
    ];

    protected $scene = [
        'authcode' => ['appid','response_type','redirect_url'],
        'authtoken' => ['appid','secret','code'],
        'resource' => ['appid','access_token']
    ];

    /**
     * @describe 验证appid
     */
    protected function checkAppid($value){
        $apps = Config::pull('apps');
        if(!array_key_exists($value,$apps)){
            return 'invalid appid';
        }
        return true;
    }

    /**
     * @describe 验证secret
     */
    protected function checkAppSecret($value,$rule,$data){
        $apps = Config::pull('apps');
        $appid = $data['appid'];
        if($value !== $apps[$appid]['secret']){
            return 'invalid secret';
        }else{
            return true;
        }
    }

}