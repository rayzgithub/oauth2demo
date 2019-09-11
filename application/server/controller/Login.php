<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 2019/9/6
 * Time: 9:25
 */
namespace app\server\controller;

use app\common\controller\Server;
use think\facade\Config;
use think\Request;

class Login extends Server{

    /**
     * @describe 登录入口
     */
    public function index(){
        $redirect_url = urldecode($this->request->param('redirect_url'));
        $this->assign('viewData',[
            'redirect_url' => $redirect_url
        ]);
        return $this->fetch();
    }

    /**
     * @describe 登录接口
     */
    public function login(Request $request){

        $res = $this->checkUserPass($request->param('username'),$request->param('password'));
        if($res['code'] != 200){
            $this->showMsg($res);
        }

        $this->setUserInfo($res['data']['user']);

        if($redirect_url = $request->param('redirect_url')){
            $this->redirect($redirect_url);
        }

        return $this->fetch("login_success");
    }

    private function checkUserPass($username,$password){
        //加载所有用户
        $users = Config::pull('users');

        if(!isset($users[$username])){
            return make_ret(404,'用户不存在');
        }

        if($users[$username]['password'] !== $password){
            return make_ret(501,'密码错误');
        }

        return make_ret(200,'login success',['user' => $users[$username]]);
    }

}