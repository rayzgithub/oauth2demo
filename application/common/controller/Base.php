<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 2019/9/5
 * Time: 16:05
 */
namespace app\common\controller;

use think\Controller;
use think\exception\HttpResponseException;
use think\facade\Response;

class Base extends Controller{

    public function showMsg($data,$format = ''){
        //优先指定返回类型    后根据url指定类型
        $format = $format ? $format : $this->request->ext();
        $format = $format ? $format : 'json';
        $response = null;
        switch($format){
            case 'json':
                $response = Response::create($data,'json');
                break;
            case 'html':
                //非数组  则是ajax $data 则为返回的html
                //是数组  则为过渡页面 $data为过渡页的模板数据
                if(!is_array($data)){
                    //渲染模板 -  提示
                    $response = Response::create($data,'html');
                }
            default:
                //返回过渡页面   操作成功 操作失败
                $this->assign('viewData',$data);
                $html = $this->fetch('../app/admin/view/public/show_msg_default.html');
                $response = Response::create($html,'html');
        }
        throw new HttpResponseException($response);
    }

}