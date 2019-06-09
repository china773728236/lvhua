<?php
namespace app\front\controller;
use app\front\model\Cat as CatModel;
use think\Controller;
use think\Db;
class Init extends Controller
{
    public function _initialize()
    {


          $this->catTree();

    }

    //栏目的无限级分类
    public function catTree()
    {
        /*
         * $pid默认为最顶级
         *
         * */
        //先获取到父栏目
        $pid_name = Db::name('cat')->where('cat_pid',0)->order('id','asc')->select();
        //循环父栏目
        foreach ($pid_name as $k => $v)
        {
            //找到所有子栏目
            $son_name = Db::name('cat')->where('cat_pid' , $v['id'])->select();
                 //如果主栏目下面有子栏目，如果没有在数组中加以一个0
            if($son_name){
                $pid_name[$k]['son_name']=$son_name;
            }else{
                $pid_name[$k]['son_name']=0;
            }

        }
       // dump($pid_name);die;
        $this->assign('cat',$pid_name);
    }
}
