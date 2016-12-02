<?php
namespace Admin\Model;

class AdminAuthGroupModel extends BaseModel
{
    protected $tableName = 'admin_auth_group';
    
    /**
     * 获取角色列表
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     * @params $type=1有分页，2无分布全部数据
     */
    public function getGroupList($user_id = 0)
    {
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );
        
        $count = $this->where($where)->count();
        
        $page = new \Think\Page($count, parent::PAGE_LIMIT);
        if(!$user_id){
            $list = $this->where($where)->limit($page->firstRow, $page->listRows)->order('is_manage DESC,id DESC')->select();
        }else{
            $where = array(
                'a.status' => 1,
            );
            $field = "a.*,b.uid";
            $join = "LEFT JOIN admin_auth_group_access b ON a.id=b.group_id AND b.uid={$user_id}";
            $list = $this->alias('a')->field($field)->join($join)->where($where)->order('a.is_manage DESC,a.id DESC')->select();
        }
        
        
        return array(
            'list' => $list,
            'page' => $page->show(),
        );
    }
    
    /**
     * 根据id查找角色信息
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     * @param unknown $id
     */
    public function findGroup($id)
    {
        $where = array(
            'id'     => $id,
            'status' => parent::NORMAL_STATUS,
        );
        return $this->where($where)->find();
    }
    
    /**
     * 根据id修改状态
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     * @param unknown $id
     */
    public function changeResult($id, $status)
    {
        $where = array(
            'id' => $id,
        );
        return $this->where($where)->setField('status', $status);
    }

    /**
     * @description:角色分配权限
     * @author wuyanwen(2016年12月2日)
     * @param unknown $rule_ids
     * @param unknown $role_id
     * @return Ambigous <boolean, unknown>
     */
    public function addAuthRule($rule_ids,$role_id)
    {
        $where = array(
            'id' => $role_id,
        );
        
        $data = array(
            'rules' => $rule_ids,
        );

        return $this->where($where)->save($data);
    }
}