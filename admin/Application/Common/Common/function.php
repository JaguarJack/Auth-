<?php
/**
 * description: 递归菜单
 * @author: wuyanwen(2016年8月7日)
 * @param unknown $array
 * @param number $fid
 * @param number $level
 * @param number $type 1:顺序菜单 2树状菜单
 * @return multitype:number
 */
function get_column($array,$type=1,$fid=0,$level=0)
{
    $column = [];
    if($type == 2)
        foreach($array as $key => $vo){
        if($vo['pid'] == $fid){
            $vo['level'] = $level;
            $column[$key] = $vo;
            $column [$key][$vo['id']] = get_column($array,$type=2,$vo['id'],$level+1);
        }
    }else{
        foreach($array as $key => $vo){
            if($vo['pid'] == $fid){
                $vo['level'] = $level;
                $column[] = $vo;
                $column = array_merge($column, get_column($array,$type=1,$vo['id'],$level+1));
            }
        }
    }
    
    return $column;
}