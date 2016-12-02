<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Auth;

class CommonController extends Controller {
    
    
    /**
     * 构造函数
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function __construct()
    {
        parent::__construct();
        $user_info = session('user_info');
        if(!$user_info['id']){
            $this->redirect('Login/login');
        }
        

            $name = CONTROLLER_NAME . '/' . ACTION_NAME;
            if(CONTROLLER_NAME != 'Index'){
            
             $auth = new Auth();
            $auth_result = $auth->check($name, $user_info['id']);
            
            if($auth_result === false){
                if(IS_AJAX){
                    $this->ajaxError('没有权限!');
                }else{
                    $this->error('没有权限!');
                }
                
            } 
        } 
    }
    /**
     * @description:错误返回
     * @author wuyanwen(2016年11月22日)
     * @param string $msg
     * @param unknown $fields
     */
    protected function ajaxError($msg='', $fields=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'error', 'msg'=>$msg, 'fields'=>$fields);
        echo json_encode($data);
        exit;
    }
    
    protected function ajaxSuccess($msg, $_data=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'success', 'msg' => $msg ,'data'=>$_data);
        echo json_encode($data);
        exit;
    }
}