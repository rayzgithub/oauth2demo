<?php
namespace app\home\controller;

use app\common\controller\Home;
use app\server\validate\Authorization;
use think\Request;

class Index extends Home {

    /**
     * @var string server url
     */
    private $server;

    private $appurl;

    public function initialize(){
        parent::initialize();

        $this->server = "http://" . \think\facade\Env::get('domain.server');

        $this->appurl = "http://" . \think\facade\Env::get('domain.home');
    }

    public function index(){
        $param = [
            'appid' => config('info.appid'),         //携带当前应用id
            'response_type' => 'code',                     //授权方式
            'redirect_url' => $this->appurl . '/recieve_authorization_code',  //回调url
            'state' => '123'                                //需要回传的参数
        ];

        $url = $this->server . '/authorize_code?' . http_build_query($param);

        $this->assign('viewData',[
            'authcode_url' => $url
        ]);

        return $this->fetch("index");
    }

    /**
     * @describe 接收返回code
     */
    public function recieveAuthorizationCode(Request $request){
        $code = $request->param('code');
        $this->assign('viewData',[
            'authcode' => $code
        ]);
        return $this->fetch('authcode');
    }

    /**
     * @describe 请求token
     */
    public function requestToken(Request $request){
        $param = [
            'code' => $request->param('code'),
            'appid' => config('info.appid'),
            'secret' => config('info.secret')
        ];

        $res = file_get_contents($this->server . '/access_token?' . http_build_query($param));
        $token = $err = '';
        try{
            $result = json_decode($res,true);
            if($result['code'] == 200){
                $token = $result['data']['access_token'];
            }else{
                $err = $result['msg'];
            }
        }catch (\Exception $e){
            $err = 'bad request';
        }

        $this->assign('viewData',[
            'token' => $token,
            'err' => $err
        ]);
        return $this->fetch('authtoken');
    }

    /**
     * @describe 获取用户信息
     */
    public function requestUserInfo(Request $request){
        $token = $request->param('access_token');

        $param = [
            'appid' => config('info.appid'),
            'access_token' => $token
        ];

        $res = file_get_contents($this->server . "/user_info?" . http_build_query($param));
        $response = json_decode($res,true);
        if($response['code'] != 200){
            $this->showMsg(501,$response['msg']);
        }

        $this->assign('viewData',[
            'user' => $response['data']['user']
        ]);

        return $this->fetch('userinfo');
    }

}
