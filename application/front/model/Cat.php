<?php
/*
 * 前台主页
 * */
namespace app\front\model;
use think\Model;
use think\Db;
class Cat extends Model
{
    //查询栏目下所有的子栏目
    public function sonTree($id,$clear=false)
    {
        //如果$clear=真清空掉数组
        if($clear)
        {
            unset($arr);
        }
        //先定义一个空数组
          $arr = array();
        //查询所有数据
        $data = Cat::all();
        //遍历数据
        foreach ($data as $k=>$v)
        {
            //如果发现当前栏目下的id等于查询出来的pid说明它下面有子栏目，一并取出来放到空数组中
            if($v['cat_pid'] == $id)
            {
                $arr[] = $v['id'];
                //依次寻找
                $this->sonTree($v['id'],true);
            }
        }

        $arr[] = $id;
        //将数组转换成字符串
        $str_id = implode(',',$arr);

        return $str_id;
    }



    //查询所有子栏目上面的父栏目
    public function getParentId($id)
    {
        $arr_parent = array();
        //查询到当前的pid
        $cats = $this->field('id,cat_name,enname,cat_pid')->find($id);
       // dump($cats);die;
        $pid_parent = $cats['cat_pid'];
        //如果$pid不等于0，说明它自己不是主栏目才需要去找到主栏目
        if($pid_parent)
        {
           $arr = $this->parentTree($pid_parent);
           $arr[] = $cats;
        }else
        {

            //等于0就直接显示主栏目
            $arr_parent[] = $cats;
            return $arr_parent;
        }

        //dump($arr);die;
        return $arr;
    }



    //查询所有子栏目上面的父栏目
    public function parentTree($pid)
    {
        //如果$clear=真清空掉数组
       /* if($clear)
        {
            unset($arr);
        }*/
        //先定义一个空数组
      static  $arr = array();
        //查询所有数据
        $data = $this->field('id,cat_name,enname,cat_pid')->select();
        //遍历数据
        foreach ($data as $k=>$v)
        {
            //如果发现当前栏目下的pid等于查询出来的id说明它上面有父栏目，一并取出来放到空数组中
            if($v['id'] == $pid)
            {
                $arr[] = $v;
                //依次寻找
                $this->parentTree($v['cat_pid']);
            }
        }
        return $arr;
    }
}
