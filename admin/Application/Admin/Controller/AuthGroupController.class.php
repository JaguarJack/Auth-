<?php
namespace Admin\Controller;

class AuthGroupController extends CommonController {
    
    /**
     * 角色列表
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function authGroupList()
    {
        /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
        $admin_auth_group_model = D('AdminAuthGroup');
        $data = $admin_auth_group_model->getGroupList();
        
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        $this->display();
    }
    
    /**
     * 添加角色页面显示
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function addGroup()
    {   
        if(IS_POST){
            $params = array(
                'title' => I('title'),
                'status' => 1,
                'rules' => '',
            );
            if(!$params['title']){
                parent::ajaxError('请输入角色名称!');
            }

            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_model = D('AdminAuthGroup');
            $add_group_result = $admin_auth_group_model->add($params);
            if(!$add_group_result){
                parent::ajaxError('添加失败!');
            }
            parent::ajaxSuccess('添加成功!');
        }else{
            $this->display();
        }
        
    }
    
    
    /**
     * 编辑角色页面显示
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function editGroup()
    {
        if(IS_POST){
            $params = array(
                'id' => I('id', 0, 'intval'),
                'title' => I('title'),
            );
            if(!$params['id']){
                parent::ajaxError('角色不存在!');
            }
            if(!$params['title']){
                parent::ajaxError('请输入角色名称!');
            }
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_model = D('AdminAuthGroup');
            $save_group_result = $admin_auth_group_model->save($params);
            if($save_group_result === false){
                parent::ajaxError('修改失败!');
            }
            parent::ajaxSuccess('修改成功!');
        }else{
            $id = I('id', 0, 'intval');
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_model = D('AdminAuthGroup');
            $group_info = $admin_auth_group_model->findGroup($id);
            
            $this->assign('group_info', $group_info);
            $this->display();
        }
       
    }
    
    /**
     * 删除角色处理
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function deleteGroup()
    {
        $id = I('id', 0, 'intval');
        if(!$id){
            parent::ajaxError('角色不存在!');
        }
        /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
        $admin_auth_group_model = D('AdminAuthGroup');
        $group_info = $admin_auth_group_model->findGroup($id);
        if(!$group_info){
            parent::ajaxError('角色不存在!');
        }
        $change_result = $admin_auth_group_model->changeResult($id, 2);
        if($change_result === false){
            parent::ajaxError('删除失败!');
        }
        parent::ajaxSuccess('删除成功!');
    }
    
    /**
     * 分配角色
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function giveRole()
    {
        if(IS_POST){
            $user_id = I('user_id', 0, 'intval');
            if(!$user_id){
                parent::ajaxError('用户不存在!');
            }
            
            $group_id = $_POST['group_id'];
            //html_entity_decode($string)
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_access_model = D('AdminAuthGroupAccess');
            
            if(!empty($group_id)){
                //删除原有角色
                $admin_auth_group_access_model->where(array('uid'=>$user_id))->delete();
                foreach($group_id as $v){
                    $add_data = array(
                        'uid' => $user_id,
                        'group_id' => $v,
                    );
                    $admin_auth_group_access_model->add($add_data);
                }
            }
            parent::ajaxSuccess('分配成功!');
        }else{
            $user_id = I('user_id', 0, 'intval');
            
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_model = D('AdminAuthGroup');
            $data = $admin_auth_group_model->getGroupList($user_id);
            
            $this->assign('list', $data['list']);
            $this->assign('user_id', $user_id);
            $this->display();
        }
    }
    
    /**
     * 分配权限
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function ruleGroup()
    {
        /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
        $admin_auth_group_model = D('AdminAuthGroup');
        if(IS_POST){
            $data = I('post.');
            $rule_ids = implode(",", $data['menu']);

            $role_id = $data['role_id'];
            
            if(!count($rule_ids)){
                $this->ajaxError('请选择需要分配的权限');
            }
            
            if($admin_auth_group_model->addAuthRule($rule_ids, $role_id) !== false){
                $this->ajaxSuccess('分配成功');
            }else{
                $this->ajaxError('分配失败，请检查');
            }
        }else{
            
            $role_id = I('get.role_id','','intval');
            /* @var $menu_model \Admin\Model\AdminMenuModel */
            $menu_model = D('AdminMenu');
            
            $menus = get_column($menu_model->selectAllMenu(2),2);
            $role_info = $admin_auth_group_model->findGroup($role_id);
           
            if($role_info['rules']){
                $rulesArr = explode(',',$role_info['rules']);
               
                $this->assign('rulesArr',$rulesArr);
            }
                
            $this->assign('menus',$menus);
            $this->assign('role_id',$role_id);
            $this->display();
        }
    }

}