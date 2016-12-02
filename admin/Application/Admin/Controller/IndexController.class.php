<?php
namespace Admin\Controller;

class IndexController extends CommonController {
    public function index()
    {
        $user_info = session('user_info');
        /* @var $admin_auth_group_access_model \Admin\Model\AdminAuthGroupAccessModel */
        $admin_auth_group_access_model = D('AdminAuthGroupAccess');
        $menus = $admin_auth_group_access_model->getUserRules($user_info['id']);
        
        $this->assign('menus', $menus);
        $this->display();
    }
    
    public function nav()
    {
        $this->display();
    }
    
    
    public function login()
    {
       $this->display();
    }
    
    public function form()
    {
        $this->display();
    }
    
    
    public function table()
    {
       $this->display();
       
    }
    
    public function main()
    {
        $this->display();
    }
    public function upload()
    {
        if(IS_POST){
           $img = $_FILES['file'];
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize   = 3145728 ;// 设置附件上传大小
           $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath  = './Public/'; // 设置附件上传根目录
           $upload->savePath  = 'upload/'; // 设置附件上传（子）目录
           // 上传文件
           $info   =   $upload->uploadOne($img);
          
          
           if(!$info) {// 上传错误提示错误信息
               echo json_encode(array('status' => 'error','msg' => $upload->getError()));
               exit;
           }else{// 上传成功
               
               $imgpath = $info['savepath'].$info['savename'];
               echo json_encode(array('status' => 'success','url'=>'/Public/'.$imgpath));
               exit;
           }
           
        }else{
            $this->display();
        }
        
    }
    //验证码
    public function verify(){
        $Verify = new \Think\Verify();   
        $Verify->codeSet = '0123456789';// 设置验证码字符为纯数字   
        $Verify->length = 4;
        $Verify->imageH = 37;
        $Verify->imageW = 120;
        $Verify->fontSize = 18;
        $Verify->useNoise = true;
        $Verify->useCurve = true;
        $Verify->fontttf = "5.ttf";
        $Verify->bg = array(196,223,246);    
        $Verify->entry();    
    }
}