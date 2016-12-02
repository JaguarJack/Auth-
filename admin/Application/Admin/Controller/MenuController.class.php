<?php
namespace Admin\Controller;

class MenuController extends CommonController
{
    protected $menu_model;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $menu_model \Admin\Model\AdminMenuModel */
        
        $menu_model = D('AdminMenu');
        
        $this->menu_model = $menu_model;
    }
    
    /**
     * @description:菜单首页
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        
        $menu = $this->menu_model->selectAllMenu();
        
        $menu = get_column($menu);

        $this->assign('menu',$menu);
        $this->display();
    }
    
    /**
     * @description:添加菜单
     * @author wuyanwen(2016年12月1日)
     */
    public function addMenu()
    {
        if(IS_POST){
            $data = I('post.');
            
            $data['is_menu'] = 1;
            //添加的菜单是否是三级菜单
            if($data['pid']){
                $data['is_menu'] = $this->menu_model->isSecondaryMenu($data['pid']) ? 2 : 1;
            }
            
            if($this->menu_model->isExistOpt($data['controller'], $data['action'])){
                $this->ajaxerror("该菜单已存在");
            }
            
            if($this->menu_model->addAdminMenu($data)){
                $this->ajaxSuccess("菜单添加成功");
            }else{
                $this->ajaxError("菜单添加失败");
            }
        }else{
            $id = I('get.id','','intval');
            
            $this->assign('id',$id);
            $this->display();
        }
    }
    
    /**
     * @description:更新菜单
     * @author wuyanwen(2016年12月1日)
     */
    public function editMenu()
    {
        if(IS_POST){
            $data = I('post.');
            
            
            if($this->menu_model->isExistOpt($data['controller'], $data['action'],$data['id'])){
                $this->ajaxerror("该菜单已存在");
            }
            
            $result = $this->menu_model->editAdminMenu($data);
            if($result !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');
            
            $menu_info = $this->menu_model->selectMenuById($id);
            
            $this->assign('menu_info',$menu_info);
            $this->assign('opt',explode('/',$menu_info['menu_name']));
            $this->display();
        }
    }
    
    /**
     * @description:删除菜单
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteMenu()
    {
        $id = I('post.id','','intval');

        if($this->menu_model->isExistSonMenu($id)){
            $this->ajaxError('存在子菜单未删除');
        }
        
        if(!$this->menu_model->deleteAdminMenu($id)){
            $this->ajaxError('删除失败');
        }else{
            $this->ajaxSuccess('删除成功');
        }
    }
    
    /**
     * @description:查看三级操作
     * @author wuyanwen(2016年12月1日)
     */
    public function viewOpt()
    {
        $id = I('get.id','','intval');
        
        $_opts = $this->menu_model->selectOpt($id);
        
        if(!count($_opts)){
            $this->ajaxError('该菜单还未添加任何操作');
        }

        $this->assign('opts',$_opts);
        $this->display();
    }
}